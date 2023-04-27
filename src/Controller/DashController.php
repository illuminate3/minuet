<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use App\Repository\MessageRepository;
use App\Repository\ProductRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\ThreadRepository;
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
        AccountUserRepository $accountUserRepository,
        SubscriptionRepository $subscriptionRepository,
        ProductRepository $productRepository,
        ThreadRepository $threadRepository,
        MessageRepository $messageRepository
    ): Response {
        // Redirect Admin Users
        if ($security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_dashboard');
        }

        $user = $security->getUser();

        if ($user->getIsAccount() === FALSE) {
            return $this->redirectToRoute('app_index');
        }

        // get the account information the user is registered to
        $accountUser = $accountUserRepository->findOneBy(['user' => $user->getId()]);

        // get the account information
        $account = $accountRepository->findOneBy(['id' => $accountUser->getAccount()]);
        $account_id = $account->getId();
        // check to see if the current user is the primary user for the account
        $primaryUser = $account->getPrimaryUser();
        $is_primary = $primaryUser === $user->getId();

        // get the subscription for the account
        $subscription = $subscriptionRepository->findOneBy(['id' => $account->getSubscription()]);

        // get all the users for the accout
        $account_users = $accountUserRepository->findBy(['account' => $account]);

        // if the user isn't a primary user they still can manage products
        // get all the products associated to the account
        $products = $productRepository->findBy(['account' => $account_id]);

        // threads
        $productThreads = $productRepository->findAllThreadsByAccount($account_id);
//        $threads = $threadRepository->findAll();
        // messages
//        $messages = $messageRepository->findAll();

        return $this->render('dash/index.html.twig', [
            'title' => 'title.dashboard',
            'site' => $this->site($request),
            'error' => null,
            'account' => $account,
            'subscription' => $subscription,
            'is_primary' => $is_primary,
            'account_users' => $account_users,
            'products' => $products,
            'productThreads' => $productThreads,
//            'threads' => $threads,
//            'messages' => $messages,
        ]);
    }
}
