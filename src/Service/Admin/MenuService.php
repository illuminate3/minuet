<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Entity\Menu;
use App\Service\AbstractService;
use App\Utils\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class MenuService extends AbstractService
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

    public function create(Menu $menu): void
    {
        // Make slug
        if (null !== $menu->getUrl()) {
            $slug = $this->slugger->slugify($menu->getTitle());
            $menu->setUrl($slug);
        }

        // Save mwnu
        $this->save($menu);
    }

    public function edit(Menu $menu): void
    {
        // Make slug
        if ($menu->getIsSlug()) {
            $slug = $this->slugger->slugify($menu->getTitle());
            $menu->setUrl($slug);
        }

        // Save mwnu
        $this->save($menu);
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

    public function delete(Menu $menu): void
    {
        // Delete mwnu
        $this->remove($menu);
        $this->addFlash('success', 'message.deleted');
    }
}
