<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\SettingsRepository;
use App\Repository\UserRepository;
use App\Service\User\UserService;
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

    public function __construct(
        UserRepository $userRepository,
        UserService $userService,
        SettingsRepository $settingsRepository,
        Security $security,
    )
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->settingsRepository = $settingsRepository;
        $this->security = $security;
    }


    public function stripeChargeFailed($stripeObject): void
    {
        $stripeEvent = $stripeObject;
        dd($stripeEvent);
    }

    public function stripeCustomerCreated(): Customer
    {
//        $stripeEvent = $stripeObject;

//   {
//          "id": "cus_Nu4fu9hqLKtnl2",
//          "object": "customer",
//          "account_balance": 0,
//          "address": null,
//          "balance": 0,
//          "created": 1684215220,
//          "currency": null,
//          "default_currency": null,
//          "default_source": null,
//          "delinquent": false,
//          "description": "Minuet",
//          "discount": null,
//          "email": "test1@test.com",
//          "invoice_prefix": "7D25AAB1",
//          "invoice_settings": {
//                    "custom_fields": null,
//            "default_payment_method": null,
//            "footer": null,
//            "rendering_options": null
//          },
//          "livemode": false,
//          "metadata": {
//                    "userId": "3"
//          },
//          "name": null,
//          "next_invoice_sequence": 1,
//          "phone": null,
//          "preferred_locales": [],
//          "shipping": null,
//          "sources": {
//                    "object": "list",
//            "data": [],
//            "has_more": false,
//            "total_count": 0,
//            "url": "/v1/customers/cus_Nu4fu9hqLKtnl2/sources"
//          },
//          "subscriptions": {
//                    "object": "list",
//            "data": [],
//            "has_more": false,
//            "total_count": 0,
//            "url": "/v1/customers/cus_Nu4fu9hqLKtnl2/subscriptions"
//          },
//          "tax_exempt": "none",
//          "tax_ids": {
//                    "object": "list",
//            "data": [],
//            "has_more": false,
//            "total_count": 0,
//            "url": "/v1/customers/cus_Nu4fu9hqLKtnl2/tax_ids"
//          },
//          "tax_info": null,
//          "tax_info_verification": null,
//          "test_clock": null
//        }

        Stripe::setApiKey($this->getParameter('app.stripe.secret_key'));

//        $stripeCustomerObject = [];

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
                    // For metered billing, do not pass quantity
                    'quantity' => 1,
                ]
            ],
        ]);

        return $stripeSession;

    }


    public function stripeCustomerSubscriptionCreated($stripeObject): void
    {
//        $stripeEvent = $stripeObject;
//        dd($stripeEvent);
//        $stripeEvent = $webhook->getStripeObject();
//        $subscriptionStripe = $stripeEvent->data->object;
//        dd($subscriptionStripe);

        // evt_1N8bwyHxcL7TQhSHAJ39IPxK

//        $user = $this->security->getUser();

        $stripeCustomer = $stripeObject->data->object->customer;
        $subscriptionId = $stripeObject->data->object->id;

        $user = $this->userRepository->findOneBy(['stripe_customer_id' => $stripeCustomer]);
        $user->setStripeSubscriptionId($subscriptionId);
        $this->userService->update($user);

    }




//        $stripe = new \Stripe\StripeClient(
//            'sk_test_4eC39HqLyjWDarjtT1zdp7dc'
//        );
//        $stripe->subscriptions->create([
//            'customer' => 'cus_Nu4wmzDdGnmr75',
//            'items' => [
//                ['price' => 'price_1N7yy22eZvKYlo2CTExCxGA1'],
//            ],
//        ]);




//        $em->persist($this->getUser());
//        $em->flush();



//        $stripeCustomerId = $stripeCustomerObj->id;
//        $this->getUser()->setStripeCustomerId($stripeCustomerId);
//        $em->persist($this->getUser());
//        $em->flush();


//        dd($stripeEvent);


//    public function stripeChargeFailed($stripeObject): void
//    {
//        $stripeEvent = $stripeObject;
//        dd($stripeEvent);
////        $stripeEvent = $webhook->getStripeObject();
////        $subscriptionStripe = $stripeEvent->data->object;
////        dd($subscriptionStripe);
//    }


//    public function fetchGitHubInformation()
//    {
//        $response = $this->client->request(
//            'GET',
//            'http://localhost:8000/webhook'
//        );
//        $session = $this->requestStack->getSession();
//        $session->set('res', $response);
//        $statusCode = $response->getStatusCode();
//        // $statusCode = 200
//        $contentType = $response->getHeaders()['content-type'][0];
//        // $contentType = 'application/json'
//        $content = $response->getContent();
//        // $content = '{"id":521583, "name":"symfony-docs", ...}'
//        $content = $response->toArray();
//        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
//
//        return $content;
//    }
}
