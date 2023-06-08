<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Entity\ProductTrims;
use App\Service\AbstractService;
use App\Utils\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class ProductTrimsService extends AbstractService
{
    private EntityManagerInterface $em;
    private Slugger $slugger;

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
    public function delete(ProductTrims $producttrims): void
    {
        // Delete product
        $this->remove($producttrims);
        $this->clearCache('products_count');
        $this->addFlash('success', 'message.deleted');
    }
}
