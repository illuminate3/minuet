<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AccountListingRepository;
use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use App\Repository\SubscriptionRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashController extends BaseController
{
    #[Route('/user/dash', name: 'app_dash')]
    public function index(
        Request $request,
        Security $security,
        AccountRepository $accountRepository,
        AccountListingRepository $accountListingRepository,
        AccountUserRepository $accountUserRepository,
        SubscriptionRepository $subscriptionRepository,
    ): Response {
        // Redirect Admin Users
        if ($security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_dashboard');
        }

        $user = $security->getUser();
        $account = $accountRepository->findOneBy(['user' => $user->getId()]);
        $usersData = $account->getAccountUser()->toArray();
        $listingData = $account->getAccountListing()->toArray();
        $subscription_id = $account->getSubscription()->getId();
        $subscription = $subscriptionRepository->findOneBy(['id' => $subscription_id]);

        return $this->render('dash/index.html.twig', [
            'title' => 'title.dashboard',
            'site' => $this->site($request),
            'error' => null,
            'account' => $account,
            'usersData' => $usersData,
            'listingData' => $listingData,
            'subscription' => $subscription,
        ]);
    }
}
