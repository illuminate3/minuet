<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User as AppUser;
use App\EventListener\ExceptionListener;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

// checkuser information: https://symfony.com/doc/current/security/user_checkers.html

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }

//        if ($user->getConfirmationToken() === null) {
////            throw  new DisabledException('User account is not activated');
//        }

        if (!$user->getEmailVerifiedAt()) {
            throw new DisabledException("Accout Email has not been verified.");
        }

        if (!$user->isVerified()) {
            throw new DisabledException("Accout Email has not been verified.");
        }


//        $this->addFlash('danger', 'message.registration_suspended');
//        return $this->redirectToRoute('no_register');


        // User account is not validated

//        $user->getConfirmationToken()


//        if ($user->isDeleted()) {
//            // the message passed to this exception is meant to be displayed to the user
//            throw new CustomUserMessageAccountStatusException('Your user account no longer exists.');
//        }

    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }


//        if ($user->getConfirmationToken() == null) {
//            throw  new DisabledException('User account is not activated');
//        }


//        // user account is expired, the user may be notified
//        if ($user->isExpired()) {
//            throw new AccountExpiredException('...');
//        }

    }


}
