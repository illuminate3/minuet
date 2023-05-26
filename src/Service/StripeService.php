<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Account;
use App\Repository\AccountRepository;
use App\Repository\SettingsRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use App\Service\User\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
            $this->entityManagerInterface->persist($account);
            $this->entityManagerInterface->flush();
            $user->setStripeSubscriptionId($invoiceObj->subscription);
            $this->entityManagerInterface->persist($user);
            $this->entityManagerInterface->flush();
            http_response_code(200);
            exit();
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode(["status" => false, $th->getMessage()]);
            exit();
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
            exit();
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode(["status" => false, $th->getMessage()]);
            exit();
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
}
