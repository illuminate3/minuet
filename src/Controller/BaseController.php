<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Entity\City;
use App\Entity\DealType;
use App\Entity\Feature;
use App\Entity\Menu;
use App\Repository\SettingsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseController extends AbstractController
{
    public function __construct(private SettingsRepository $settingsRepository, protected ManagerRegistry $doctrine)
    {
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

    public function site(Request $request): array
    {
        $settings = $this->settingsRepository->findAllAsArray();

        $menu = $this->menu($request);

        return array_merge($settings, $menu);
    }
}
