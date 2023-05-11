<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Entity\Menu;
use App\Entity\Page;
use App\Service\AbstractService;
use App\Utils\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class PageService extends AbstractService
{
    private EntityManagerInterface $em;

    public function __construct(
        CsrfTokenManagerInterface $tokenManager,
        RequestStack $requestStack,
        EntityManagerInterface $entityManager,
        Slugger $slugger,
    ) {
        parent::__construct($tokenManager, $requestStack);
        $this->em = $entityManager;
        $this->slugger = $slugger;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function create(Page $page): void
    {
        // Make slug
        if ($page->getSlug() !== null) {
            $slug = $this->slugger->slugify($page->getTitle());
            $page->setSlug($slug);
        }

        // Save page
        $this->save($page);
        $this->clearCache('pages_count');

        // Add a menu item
        if ($page->getShowInMenu() === true) {
            $menu = new Menu();
            $menu->setTitle($page->getTitle() ?? '');
            $menu->setLocale($page->getLocale() ?? '');
            $menu->setUrl('/info/' . ($page->getSlug() ?? ''));
            $this->save($menu);
        }
    }

    public function edit(Page $page): void
    {
        // Make slug
        if ($page->getSlug() !== null) {
            $slug = $this->slugger->slugify($page->getTitle());
            $page->setSlug($slug);
        }

        // Save page
        $this->save($page);
    }

    public function save(object $object): void
    {
        $this->em->persist($object);
        $this->em->flush();
    }

    public function remove(object $object): void
    {
        $this->em->remove($object);
        $this->em->flush();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function delete(Page $page): void
    {
        // Delete page
        $this->remove($page);
        $this->clearCache('pages_count');
        $this->addFlash('success', 'message.deleted');

        // Delete a menu item
        $menu = $this->em->getRepository(Menu::class)->findOneBy(['url' => '/page/' . ($page->getSlug() ?? '')]);
        if ($menu) {
            $this->remove($menu);
        }
    }
}
