<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Service\StripeService;
use Fpt\StripeBundle\Event\StripeEvents;
use Fpt\StripeBundle\Event\StripeWebhook;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StripeEventSubscriber implements EventSubscriberInterface
{
//    private StripeService $stripeService;
//
    private StripeService $stripeService;

    public function __construct(
        StripeService $stripeService,
    ) {
        $this->stripeService = $stripeService;
    }

    public static function getSubscribedEvents(): array
    {
//    case 'invoice.paid':
//    case 'charge.succeeded':
//    case 'customer.updated':
        return [
            StripeEvents::CHARGE_FAILED => 'stripeChargeFailed',
//            StripeEvents::CUSTOMER_CREATED => 'stripeCustomerCreated',
//            StripeEvents::CUSTOMER_DELETED => 'stripeCustomerDeleted',
//            StripeEvents::CUSTOMER_UPDATED => 'stripeCustomerUpdated',
            StripeEvents::CUSTOMER_SUBSCRIPTION_CREATED => 'stripeCustomerSubscriptionCreated',
//            StripeEvents::CUSTOMER_SUBSCRIPTION_DELETED => 'stripeCustomerSubscriptionDeleted',
//            StripeEvents::CUSTOMER_SUBSCRIPTION_UPDATED => 'stripeCustomerDubscriptionUpdated',
        ];
    }

    public function stripeChargeFailed(StripeWebhook $webhook): void
    {
        $this->stripeService->stripeChargeFailed($webhook->getStripeObject());
    }

    public function stripeCustomerSubscriptionCreated(StripeWebhook $webhook): void
    {
        $this->stripeService->stripeCustomerSubscriptionCreated($webhook->getStripeObject());
    }

//    public function stripeCustomerCreated(StripeWebhook $webhook): void
//    {
//        $this->stripeService->stripeCustomerCreated($webhook->getStripeObject());
//    }

//    public function stripeCustomerSubscriptionCreated(StripeWebhook $webhook, StripeService $stripeService): void {
//        $stripeService->customerSubscriptionCreated($webhook->getStripeObject());
////        $stripeEvent = $webhook->getStripeObject();
////        $subscriptionStripe = $stripeEvent->data->object;
////        dd($subscriptionStripe);
//    }

//    public function stripeCustomerCreated(StripeWebhook $webhook, StripeService $stripeService): void
//    {
////        /** @var \Stripe\Event $stripeEvent */
//        $stripeEvent = $webhook->getStripeObject();
////        /** @var \Stripe\Subscription $subscriptionStripe */
//        $subscriptionStripe = $stripeEvent->data->object;
//
//        // ... Your custom logic here.
//    }


}


//        2023-05-15 02:11:24   --> customer.created [evt_1N7vZ2HxcL7TQhSHkKwcBbt3]
//        2023-05-15 02:11:24  <--  [500] POST http://minuet.test/stripe/webhooks [evt_1N7vZ2HxcL7TQhSHkKwcBbt3]
//        2023-05-15 02:11:46   --> payment_method.attached [evt_1N7vZOHxcL7TQhSHpTf4bt65]
//        2023-05-15 02:11:46   --> setup_intent.succeeded [evt_1N7vZOHxcL7TQhSHQeMTbjzf]
//        2023-05-15 02:11:46   --> setup_intent.created [evt_1N7vZOHxcL7TQhSHSdZELtin]
//        2023-05-15 02:11:46  <--  [204] POST http://minuet.test/stripe/webhooks [evt_1N7vZOHxcL7TQhSHSdZELtin]
//        2023-05-15 02:11:46  <--  [204] POST http://minuet.test/stripe/webhooks [evt_1N7vZOHxcL7TQhSHpTf4bt65]
//        2023-05-15 02:11:46  <--  [204] POST http://minuet.test/stripe/webhooks [evt_1N7vZOHxcL7TQhSHQeMTbjzf]
//        2023-05-15 02:11:48   --> checkout.session.completed [evt_1N7vZPHxcL7TQhSHzN1sUuZE]
//        2023-05-15 02:11:48  <--  [204] POST http://minuet.test/stripe/webhooks [evt_1N7vZPHxcL7TQhSHzN1sUuZE]
//        2023-05-15 02:11:48   --> customer.updated [evt_1N7vZQHxcL7TQhSHNpLH9t0M]
//        2023-05-15 02:11:48  <--  [500] POST http://minuet.test/stripe/webhooks [evt_1N7vZQHxcL7TQhSHNpLH9t0M]
//        2023-05-15 02:11:48   --> invoice.created [evt_1N7vZQHxcL7TQhSHITrDFZWA]
//        2023-05-15 02:11:48  <--  [204] POST http://minuet.test/stripe/webhooks [evt_1N7vZQHxcL7TQhSHITrDFZWA]
//        2023-05-15 02:11:48   --> invoice.finalized [evt_1N7vZQHxcL7TQhSH3AeTlNsQ]
//        2023-05-15 02:11:48  <--  [204] POST http://minuet.test/stripe/webhooks [evt_1N7vZQHxcL7TQhSH3AeTlNsQ]
//        2023-05-15 02:11:48   --> invoice.paid [evt_1N7vZQHxcL7TQhSHWS1xSpZe]
//        2023-05-15 02:11:48   --> invoice.payment_succeeded [evt_1N7vZQHxcL7TQhSHEHECNp6P]
//        2023-05-15 02:11:48  <--  [204] POST http://minuet.test/stripe/webhooks [evt_1N7vZQHxcL7TQhSHWS1xSpZe]
//        2023-05-15 02:11:49   --> customer.subscription.created [evt_1N7vZQHxcL7TQhSHgLApOB13]
//        2023-05-15 02:11:49  <--  [500] POST http://minuet.test/stripe/webhooks [evt_1N7vZQHxcL7TQhSHgLApOB13]
//        2023-05-15 02:11:49  <--  [204] POST http://minuet.test/stripe/webhooks [evt_1N7vZQHxcL7TQhSHEHECNp6P]
