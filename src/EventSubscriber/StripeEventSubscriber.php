<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Service\StripeService;
use Fpt\StripeBundle\Event\StripeEvents;
use Fpt\StripeBundle\Event\StripeWebhook;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StripeEventSubscriber implements EventSubscriberInterface
{
    private StripeService $stripeService;

    public function __construct(
        StripeService $stripeService
    ) {
        $this->stripeService = $stripeService;
    }

    public static function getSubscribedEvents(): array
    {
        return [           
            StripeEvents::INVOICE_PAID => 'stripeInvoicePaid'
        ];
    }

    public function stripeChargeFailed(StripeWebhook $webhook): void
    {
        $this->stripeService->stripeChargeFailed($webhook->getStripeObject());
    }

    public function stripeInvoicePaid(StripeWebhook $webhook): void
    {
        $this->stripeService->stripeInvoicePaid($webhook->getStripeObject());
    }

    public function stripeCustomerSubscriptionCreated(StripeWebhook $webhook): void
    {
        $this->stripeService->stripeCustomerSubscriptionCreated($webhook->getStripeObject());
    }



}
