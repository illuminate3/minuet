<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Page;
use App\Repository\SettingsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use Stripe\Stripe;

abstract class BaseController extends AbstractController
{
    public function __construct(
        private readonly SettingsRepository $settingsRepository,
        protected ManagerRegistry $doctrine
    ) {
    }

    private function menu(Request $request): array
    {
        return [
            'menu' => $this->doctrine->getRepository(Menu::class)
                ->findBy([
                    'locale' => $request->getLocale(),
                ], ['sort_order' => 'ASC']),
        ];
    }

    private function menuPages(Request $request): array
    {
        return [
            'menu_pages' => $this->doctrine->getRepository(Page::class)
                ->findBy(
                    [
                        'locale' => $request->getLocale(),
                        'publish' => '1',
                    ],
                    [
                        'id' => 'ASC',
                    ],
                ),
        ];
    }

    private function menuFooterPages(Request $request): array
    {
        return [
            'footer_pages' => $this->doctrine->getRepository(Page::class)
                ->findBy(
                    [
                        'locale' => $request->getLocale(),
                        'publish' => '1',
                    ],
                    [
                        'id' => 'ASC',
                    ],
                    5
                ),
        ];
    }

    public function site(Request $request): array
    {
        $settings = $this->settingsRepository->findAllAsArray();
        $menu = $this->menu($request);
        $menu_pages = $this->menuPages($request);
        $footer_pages = $this->menuFooterPages($request);

        return array_merge($settings, $menu, $menu_pages, $footer_pages);
    }


    public function checkStripeSubscriptionActive(Security $security, AccountRepository $accountRepository, AccountUserRepository $accountUserRepository)
    {

        $user = $security->getUser();
        if ($security->isGranted('ROLE_USER') && $user->getIsAccount()) {
            // get the account information the user is registered to
            $accountUser = $accountUserRepository->findOneBy(['user' => $user->getId()]);

            // get the account information
            // if accountUser is null then it means this user is a primary user and we can use the main $account
            if ($accountUser) {
                $account = $accountRepository->findOneBy(['id' => $accountUser->getAccount()]);
            } else {
                $account = $accountRepository->findOneBy(['primaryUser' => $user->getId()]);
            }

            // check to see if the current user is the primary user for the account
            $primaryUser = $account->getPrimaryUser();
            $is_primary = $primaryUser === $user->getId();
            if (!$is_primary) {
                $account = $accountRepository->findOneBy(['primaryUser' => $primaryUser]);
                if (!$account->getIsSubscriptionActive()) {
                    $security->logout(false);
                    return false;
                } else {
                    return true;
                }
            } else {
                if (!$account->getIsSubscriptionActive()) {
                    if (is_null($user->getStripeCustomerId())) {
                        $stripeAPIKey = $_ENV['STRIPE_SECRET_KEY'];
                        Stripe::setApiKey($stripeAPIKey);
                        $stripeCustomerObj =  \Stripe\Customer::create([
                            'description' => 'Minuet customer',
                            'email' => $user->getEmail(),
                            'metadata' => [
                                "userId" => $user->getId()
                            ]
                        ]);
                        $stripeCustomerId =  $stripeCustomerObj->id;
                        $user->setStripeCustomerId($stripeCustomerId);
                        $entityManager = $this->doctrine->getManager();
                        $entityManager->persist($user);
                        $entityManager->flush();
                    }
                    return "account";
                } else {
                    return true;
                }
            }
        }
        return true;
    }
}
