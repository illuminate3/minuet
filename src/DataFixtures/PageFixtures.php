<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Page;
use App\Utils\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class PageFixtures extends Fixture
{
    private const LOREM_SLUG = 'lorem';
    private const IPSUM_SLUG = 'ipsum';

    public function load(ObjectManager $manager): void
    {
        $page = new Page();
        $page->setTitle('Lorem');
        $page->setDescription('Lorem Lorem Lorem Lorem');
        $page->setSlug(Slugger::slugify(self::LOREM_SLUG));
        $page->setLocale('en');
        $page->setContent($this->getAContent());
        $page->setShowInMenu(true);
        $page->setPublish(true);
        $manager->persist($page);

        $page = new Page();
        $page->setTitle('Ipsum');
        $page->setDescription('Ipsum Ipsum Ipsum Ipsum');
        $page->setSlug(Slugger::slugify(self::IPSUM_SLUG));
        $page->setLocale('en');
        $page->setContent($this->getBContent());
        $page->setShowInMenu(true);
        $page->setPublish(true);
        $manager->persist($page);

        $manager->flush();
    }

    private function getAContent(): string
    {
        return '<h3>Lorem Lorem</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                <h3>Lorem Lorem</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                <h3>Lorem Lorem</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>';
    }

    private function getBContent(): string
    {
        return '<h3>Ipsum Ipsum</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                <h3>Ipsum Ipsum</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                <h3>Ipsum Ipsum</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>';
    }
}
