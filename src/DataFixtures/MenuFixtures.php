<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class MenuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getMenuData() as [$title, $url, $locale]) {
            $menu = new Menu();
            $menu->setTitle($title);
            $menu->setUrl($url);
            $menu->setLocale($locale);
            $manager->persist($menu);
            $this->addReference($title, $menu);
        }
        $manager->flush();
    }

    private function getMenuData(): array
    {
        return [
            ['Site', '/', 'en'],
            ['Lorem', '/page/lorem', 'en'],
            ['Ipsum', '/page/ipsum', 'en'],
            ['Source Code', 'https://github.com/illuminate3/minuet', 'en'],
        ];
    }
}
