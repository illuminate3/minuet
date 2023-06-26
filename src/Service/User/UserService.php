<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;
use App\Service\AbstractService;
use App\Transformer\UserTransformer;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;
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

    /**
     * @param  User  $user
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function create(User $user): void
    {
        $user = $this->transformer->transform($user);
        $user->setCreatedAt(new DateTimeImmutable('now'));
        $user->setModifiedAt(new DateTimeImmutable('now'));
        $user->setIsAccount(false);
        $user->setStatus(true);
        $this->save($user);
        $this->clearCache('users_count');
        $this->addFlash('success', 'message.created');
    }

    /**
     * @param  User  $user
     *
     * @return void
     */
    public function update(User $user): void
    {
        $user = $this->transformer->transform($user);
        $this->save($user);
        $this->addFlash('success', 'message.updated');
    }

    /**
     * @param  User  $user
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function remove(User $user): void
    {
        $this->em->remove($user);
        $this->em->flush();
        $this->clearCache('users_count');
        $this->addFlash('success', 'message.deleted');
    }

    /**
     * @param  User  $user
     *
     * @return void
     */
    private function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }



     /**
     * @param  User  $user
     *
     * @return int
     */
    private function getMaxLoginAttempt(User $user): int
    {
        if ($user->getLoginAttempts()<3) {
            $user->setLoginAttempts($user->getLoginAttempts()+1);
            $this->em->flush();
            $attemptsRemaining = 3-$user->getLoginAttempts();            
            return $attemptsRemaining;
        }       
    }


    
     /**
     * @param  User  $user
     *
     * @return void
     */

    private function resetMaxLoginAttempt(User $user): void
    {
        $user->setLoginAttempts(0);
        $this->em->flush(); 
    }


}
