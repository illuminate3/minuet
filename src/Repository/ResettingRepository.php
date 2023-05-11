<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Transformer\UserTransformer;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

final class ResettingRepository extends UserRepository
{
    private UserTransformer $transformer;

    private PaginatorInterface $paginator;

    public function __construct(
        ManagerRegistry $registry,
        UserTransformer $transformer,
        PaginatorInterface $paginator
    ) {
        parent::__construct(
            $registry,
            $paginator
        );
        $this->transformer = $transformer;
    }

    public function setPassword(User $user, string $plainPassword): void
    {
        $user->setPassword($plainPassword);
        $user->setConfirmationToken(null);
        $user->setPasswordRequestedAt(null);
        $user = $this->transformer->transform($user);
        $this->save($user);
    }

    public function setToken(User $user, string $token): void
    {
        $user->setConfirmationToken($token);
        $user->setPasswordRequestedAt(new DateTime());
        $this->save($user);
    }

    private function save(User $user): void
    {
        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();
    }
}
