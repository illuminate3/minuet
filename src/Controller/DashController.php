<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\AccountListingRepository;
use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use App\Repository\ProductRepository;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Customer;
use Stripe\Stripe;
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
        EntityManagerInterface $entityManager,     
        AccountRepository $accountRepository,
        AccountUserRepository $accountUserRepository,
        SubscriptionRepository $subscriptionRepository,
        ProductRepository $productRepository,
    ): Response {
        // Redirect Admin Users
        if ($security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_dashboard');
        }
        $this->em = $entityManager;
        $user = $security->getUser();
        $account = $accountRepository->findOneBy(['user' => $user->getId()]);



        if (!$account) {
            $stripeAPIKey = $_ENV['STRIPE_SECRET_KEY'];
            Stripe::setApiKey($stripeAPIKey);
            if (is_null($user->getStripeCustomerId())) {               
                $stripeCustomerObj =  \Stripe\Customer::create([
                    'description' => 'Minuet customer',
                    'email'=>$user->getEmail(),
                    'metadata'=>[
                        "userId"=>$user->getId()
                    ]                  
                ]);                 
                $stripeCustomerId =  $stripeCustomerObj->id;
                $user->setStripeCustomerId($stripeCustomerId);            
                $this->em->persist($user);   
                $this->em->flush();  
                }                                    
            return $this->redirectToRoute('app_pricing');
        }
        $usersData = $account->getAccountUser()->toArray();
        $listingData = $account->getAccountListing()->toArray();
        $subscription_id = $account->getSubscription()->getId();
        $subscription = $subscriptionRepository->findOneBy(['id' => $subscription_id]);

        return $this->render('dash/index.html.twig', [
            'title' => 'title.dashboard',
            'site' => $this->site($request),
            'error' => null,
            'account' => $account,
            'subscription' => $subscription,
            'is_primary' => $is_primary,
            'account_users' => $account_users,
            'products' => $products,
        ]);
    }
}
