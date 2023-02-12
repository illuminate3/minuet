<?php

namespace App\Controller;

use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends AbstractController
{
    /**
     * @throws ApiErrorException
     */
    #[Route('/subscription', name: 'app_subscription')]
    public function index(): Response
    {
//        return $this->render('subscription/index.html.twig', [
//            'controller_name' => 'SubscriptionController',
//        ]);

        $stripe_pk = $this->getParameter('app.stripe.publishable_api_key');
        $stripe = new StripeClient(
            $this->getParameter('app.stripe.secret_api_key')
        );

        $customer = $stripe->customers->create();
        $product = $stripe->products->create([
            'name' => 'Symfony demo',
        ]);
        $subscription = $stripe->subscriptions->create([
            'customer' => $customer->id,
            'items' => [
                [
                    'price_data' => [
                        'unit_amount' => 1000,
                        'currency'    => 'jpy',
                        'recurring'   => [
                            'interval' => 'month',
                        ],
                        'product'     => $product->id,
                    ],
                    'quantity'   => 1,
                ],
            ],
            'payment_behavior' => 'default_incomplete',
            'expand' => [
                'latest_invoice.payment_intent',
            ],
            'payment_settings' => [
                'save_default_payment_method' => 'on_subscription',
            ],
        ]);


        return $this->render('subscription/index.html.twig', [
            'controller_name' => 'SubscriptionController',
            'stripe_pk'       => $stripe_pk,
            'subscription_pi_secret' => $subscription->latest_invoice->payment_intent->client_secret,
        ]);
    }
}
