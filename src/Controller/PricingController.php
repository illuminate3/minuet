<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\SubscriptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PricingController extends BaseController

{

    /**
     * @param  Request                 $request
     * @param  SubscriptionRepository  $subscriptionRepository
     *
     * @return Response
     */
    #[Route('/pricing', name: 'app_pricing', methods: ['GET'])]
    public function index(
        Request $request,
        SubscriptionRepository $subscriptionRepository,
    ): Response {

        // Get pages
        $subscriptions = $subscriptionRepository->findAll();

        return $this->render('pricing/index.html.twig', [
            'title' => 'title.subscription',
            'site' => $this->site($request),
            'subscriptions' => $subscriptions,
        ]);

    }

//    #[Route('/{id}', name: 'admin_subscription_show', methods: ['GET'])]
//    public function show(
//        Subscription $subscription,
//    ): Response {
//        return $this->render('subscription/show.html.twig', [
//            'subscription' => $subscription,
//        ]);
//    }

}
