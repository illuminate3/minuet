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
            StripeEvents::CUSTOMER_CREATED => 'stripeCustomerCreated',
            StripeEvents::CUSTOMER_DELETED => 'stripeCustomerDeleted',
            StripeEvents::CUSTOMER_UPDATED => 'stripeCustomerUpdated',
            StripeEvents::CUSTOMER_SUBSCRIPTION_CREATED => 'stripeCustomerSubscriptionCreated',
            StripeEvents::CUSTOMER_SUBSCRIPTION_DELETED => 'stripeCustomerSubscriptionDeleted',
            StripeEvents::CUSTOMER_SUBSCRIPTION_UPDATED => 'stripeCustomerDubscriptionUpdated',
        ];
    }

//    public function stripeCustomerSubscriptionCreated(StripeWebhook $webhook, StripeService $stripeService): void {
//        $stripeService->customerSubscriptionCreated($webhook->getStripeObject());
////        $stripeEvent = $webhook->getStripeObject();
////        $subscriptionStripe = $stripeEvent->data->object;
////        dd($subscriptionStripe);
//    }

    public function stripeCustomerSubscriptionCreated(StripeWebhook $webhook): void
    {
        $this->stripeService->customerSubscriptionCreated($webhook->getStripeObject());
    }

//    public function stripeCustomerCreated(StripeWebhook $webhook, StripeService $stripeService): void
//    {
////        /** @var \Stripe\Event $stripeEvent */
//        $stripeEvent = $webhook->getStripeObject();
////        /** @var \Stripe\Subscription $subscriptionStripe */
//        $subscriptionStripe = $stripeEvent->data->object;
//
//        // ... Your custom logic here.
//    }

    public function stripeCustomerCreated(StripeWebhook $webhook): void
    {
        $this->stripeService->chargeFailed($webhook->getStripeObject());
    }

    public function stripeChargeFailed(StripeWebhook $webhook): void
    {
        $this->stripeService->chargeFailed($webhook->getStripeObject());
    }

}
