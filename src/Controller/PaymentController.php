<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{

    /**
     * @Route("/payment", name="app_payment")
     */
    public function index(): Response
    {
//        return $this->render('payment/index.html.twig', [
//            'controller_name' => 'PaymentController',
//        ]);
        return $this->render('payment/index.html.twig',
            [
//                'site' => $this->site($request),
                'site' => "Site Name",
//                'page' => $page,
//                'form' => (!empty($form) ? $form : []),
                'controller_name' => 'PaymentController',
            ]);


    }

    /**
     * @Route("/checkout", name="app_checkout")
     */
    public function checkout($stripe_secret_key): Response
    {
        $stripe = new \Stripe\StripeClient($stripe_secret_key);
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                                 'price_data' => [
                                     'currency' => 'usd',
                                     'product_data' => [
                                         'name' => 'T-shirt',
                                     ],
                                     'unit_amount' => 2000,
                                 ],
                                 'quantity' => 1,
                             ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($checkout_session->url, 303);

    }

    /**
     * @Route("/success_url", name="success_url")
     */
    public function successUrl(): Response
    {
        return $this->render('payment/success.html.twig', [] );
    }

    /**
     * @Route("/cancel_url", name="cancel_url")
     */
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig', [] );
    }
}
