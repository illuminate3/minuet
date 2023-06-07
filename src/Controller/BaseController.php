<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Page;
use App\Repository\SettingsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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
        $menuPages = $this->menuPages($request);
        $footerPages = $this->menuFooterPages($request);

        return array_merge($settings, $menu, $menuPages, $footerPages);
    }


  
}
