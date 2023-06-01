<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use App\Utils\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class ProductService extends AbstractService
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

    /**
     * @throws InvalidArgumentException
     */
    public function create(Product $product): void
    {
        // Make slug
        if ($product->getSlug() !== null) {
            $slug = $this->slugger->slugify($product->getTitle());
            $product->setSlug($slug);
        }

        // Save product
        $this->save($product);
        $this->clearCache('products_count');
    }

    public function edit(Product $product): void
    {
        // Make slug
        if ($product->getSlug() !== null) {
            $slug = $this->slugger->slugify($product->getTitle());
            $product->setSlug($slug);
        }

        // Save product
        $this->save($product);
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
    public function delete(Product $product): void
    {
        // Delete product
        $this->remove($product);
        $this->clearCache('products_count');
        $this->addFlash('success', 'message.deleted');
    }
}
