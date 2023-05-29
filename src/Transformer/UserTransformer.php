<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use function in_array;

final class UserTransformer
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function transform(User $user): User
    {
        $user = $this->setRoles($user);

        return $this->setEncodedPassword($user);
    }

    private function setRoles(User $user): User
    {
        if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        } elseif (in_array('ROLE_DEALER', $user->getRoles(), true)) {
            $user->setRoles(['ROLE_DEALER']);
        } elseif (in_array('ROLE_BUYER', $user->getRoles(), true)) {
            $user->setRoles(['ROLE_BUYER']);
        } elseif (in_array('ROLE_STAFF', $user->getRoles(), true)) {
            $user->setRoles(['ROLE_STAFF']);
        } else {
            $user->setRoles(['ROLE_USER']);
        }

        return $user;
    }

    private function setEncodedPassword(User $user): User
    {
        $password = $user->getPassword();
        $user->setPassword($this->passwordHasher->hashPassword($user, (string) $password));

        return $user;
    }
}
