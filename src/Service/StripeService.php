<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Account;
use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use App\Repository\SettingsRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use App\Service\User\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;
use Symfony\Bundle\SecurityBundle\Security;

final class StripeService
{

    //    app.stripe.public_key   pk_test_
    //    app.stripe.secret_key   sk_test_
    //    app.stripe.webhook_key  whsec_


    private UserRepository $userRepository;
    private UserService $userService;
    private Security $security;
    private SettingsRepository $settingsRepository;
    private SubscriptionRepository $subscriptionRepository;
    private AccountRepository $accountRepository;
    private EntityManagerInterface $entityManagerInterface;

    public function __construct(
        UserRepository $userRepository,
        UserService $userService,
        SubscriptionRepository $subscriptionRepository,
        AccountRepository $accountRepository,
        SettingsRepository $settingsRepository,
        EntityManagerInterface $entityManagerInterface,
        Security $security,
    ) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->settingsRepository = $settingsRepository;
        $this->accountRepository = $accountRepository;
        $this->security = $security;
        $this->entityManagerInterface = $entityManagerInterface;
    }


    public function stripeInvoicePaid($stripeObject)
    {
        try {
            $invoiceObj = $stripeObject->data->object;
            $user = $this->userRepository->findOneBy(['email' => $invoiceObj->customer_email]);
            $plan = $this->subscriptionRepository->findOneBy(['stripe_price_id' => $invoiceObj->lines->data[0]->price->id]);
            $account = $this->accountRepository->findOneBy(['primaryUser' => $user->getId()]);
            if (!$account) {
                $account = new Account();
            }
            $account->setName($invoiceObj->customer_email);
            $account->setPrimaryUser($user->getId());
            $account->setSubscription($plan);
            $account->setIsSubscriptionActive(true);
            $this->entityManagerInterface->persist($account);
            $this->entityManagerInterface->flush();
            $user->setStripeSubscriptionId($invoiceObj->subscription);
            $this->entityManagerInterface->persist($user);
            $this->entityManagerInterface->flush();
            http_response_code(200);
            return;
        } catch (\Throwable $th) {
            http_response_code(500);        
            return json_encode(["status" => false, $th->getMessage()]);
        }
    }
    public function stripeInvoicePaymentFailed($stripeObject)
    {
        try {
            $invoiceObj = $stripeObject->data->object;
            $user = $this->userRepository->findOneBy(['email' => $invoiceObj->customer_email]);
            $plan = $this->subscriptionRepository->findOneBy(['stripe_price_id' => $invoiceObj->lines->data[0]->price->id]);
            $account = $this->accountRepository->findOneBy(['primaryUser' => $user->getId()]);
            if (!$account) {
                $account = new Account();
            }
            $account->setName($invoiceObj->customer_email);
            $account->setPrimaryUser($user->getId());
            $account->setSubscription($plan);
            $account->setIsSubscriptionActive(false);
            $this->entityManagerInterface->persist($account);
            $this->entityManagerInterface->flush();
            http_response_code(200);
            return;
        } catch (\Throwable $th) {
            http_response_code(500);
            return json_encode(["status" => false, $th->getMessage()]);            
        }
    }

    public function stripeChargeFailed($stripeObject): void
    {
        $stripeEvent = $stripeObject;
        dd($stripeEvent);
    }

    public function stripeCustomerCreated(): Customer
    {

        Stripe::setApiKey($this->getParameter('app.stripe.secret_key'));
        $stripeCustomerObject = Customer::create([
            'description'    => $this->settingsRepository->findOneBy(['setting_name' => 'site_name'])->getSettingValue(),
            'email'          => $this->getUser()->getEmail(),
            'metadata'       =>
            [
                'userId' => $this->getUser()->getId(),
            ],
        ]);
        $stripeCustomerId = $stripeCustomerObject->id;
        $user = $this->security->getUser();
        $user->setStripeCustomerId($stripeCustomerId);
        $this->userService->update($user);
        return $stripeCustomerObject;
    }

    public function stripeCreateSession($success_url, $cancel_url, $stripeCustomerId, $priceId): Session
    {

        $stripeSession = Session::create(
            [
                'success_url'          => $success_url,
                'cancel_url'           => $cancel_url,
                'payment_method_types' => ['card'],
                'mode'                 => 'subscription',
                'customer'             => $stripeCustomerId,
                'line_items' => [
                    [
                        'price'    => $priceId,
                        'quantity' => 1,
                    ]
                ],
            ]
        );

        return $stripeSession;
    }


    public function stripeCustomerSubscriptionCreated($stripeObject): void
    {
        $stripeCustomer = $stripeObject->data->object->customer;
        $subscriptionId = $stripeObject->data->object->id;

        $user = $this->userRepository->findOneBy(['stripe_customer_id' => $stripeCustomer]);
        $user->setStripeSubscriptionId($subscriptionId);
        $this->userService->update($user);
    }

    public function stripeAddSubscriptionToCustomer($stripeCustomerId): void
    {
         $stripe = new \Stripe\StripeClient(
                    $this->getParameter('app.stripe.secret_key')
                );
        $stripe->subscriptions->update(
            $userData->getStrSubscriptionId(),
            ['metadata' => ['customer_id' => $stripeCustomerId]]
        );

    }


    public function checkStripeSubscriptionActive(Security $security, AccountRepository $accountRepository, AccountUserRepository $accountUserRepository)
    {

        $user = $security->getUser();
        if ($security->isGranted('ROLE_USER')===true && $user->getIsAccount()) {
            // get the account information the user is registered to
            $accountUser = $accountUserRepository->findOneBy(['user' => $user->getId()]);

            // get the account information
            // if accountUser is null then it means this user is a primary user and we can use the main $account
            if ($accountUser) {
                $account = $accountRepository->findOneBy(['id' => $accountUser->getAccount()]);
            } else {
                $account = $accountRepository->findOneBy(['primaryUser' => $user->getId()]);
            }

            // check to see if the current user is the primary user for the account
            $primaryUser = $account->getPrimaryUser();
            $is_primary = $primaryUser === $user->getId();
            if (!$is_primary) {
                $account = $accountRepository->findOneBy(['primaryUser' => $primaryUser]);
                if (!$account->getIsSubscriptionActive()) {
                    $security->logout(false);
                    return false;
                } else {
                    return true;
                }
            } else {
                if (!$account->getIsSubscriptionActive()) {
                    if (is_null($user->getStripeCustomerId())) {
                        $stripeCustomerObj = $this->stripeCustomerCreated();
                        $stripeCustomerId =  $stripeCustomerObj->id;
                        $user->setStripeCustomerId($stripeCustomerId);                        
                        $this->entityManagerInterface->persist($user);
                        $this->entityManagerInterface->flush();
                    }
                    return "account";
                } else {
                    return true;
                }
            }
        }
        return true;
    }
}
