<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;
use App\Service\AbstractService;
use App\Transformer\UserTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class UserService extends AbstractService
{
    private EntityManagerInterface $em;
    private UserTransformer $transformer;

    public function __construct(
        CsrfTokenManagerInterface $tokenManager,
        RequestStack $requestStack,
        EntityManagerInterface $entityManager,
        UserTransformer $transformer
    ) {
        parent::__construct($tokenManager, $requestStack);
        $this->em = $entityManager;
        $this->transformer = $transformer;
    }

    public function create(User $user): void
    {
        $user = $this->transformer->transform($user);
        $this->save($user);
        $this->clearCache('users_count');
        $this->addFlash('success', 'message.created');
    }

    public function update(User $user): void
    {
        $user = $this->transformer->transform($user);
        $this->save($user);
        $this->addFlash('success', 'message.updated');
    }

    private function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
