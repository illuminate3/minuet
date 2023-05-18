<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Entity\Subscription;
use App\Service\AbstractService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class SubscriptionService extends AbstractService
{
    private EntityManagerInterface $em;

    public function __construct(
        CsrfTokenManagerInterface $tokenManager,
        RequestStack $requestStack,
        EntityManagerInterface $entityManager,
    ) {
        parent::__construct($tokenManager, $requestStack);
        $this->em = $entityManager;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function create(Subscription $subscription): void
    {
        // Save subscription
        $this->save($subscription);
        $this->clearCache('subscriptions_count');
    }

    public function edit(Subscription $subscription): void
    {
        // Save subscription
        $this->save($subscription);
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
    public function delete(Subscription $subscription): void
    {
        // Delete subscription
        $this->remove($subscription);
        $this->clearCache('subscriptions_count');
        $this->addFlash('success', 'message.deleted');
    }
}
