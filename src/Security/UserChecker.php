<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    /**
     * @param  UserInterface  $user
     *
     * @return void
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }
        if (!$user->getEmailVerifiedAt()) {
            // the message passed to this exception is meant to be displayed to the user
            throw new CustomUserMessageAccountStatusException('message.user_unverified');
        }
        if (!$user->isVerified()) {
            throw new CustomUserMessageAccountStatusException('message.user_unverified');
        }
        if (!$user->getStatus()) {
            throw new CustomUserMessageAccountStatusException('message.user_inactive');
        }
    }

    /**
     * @param  UserInterface  $user
     *
     * @return void
     */
    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }
    }

}
