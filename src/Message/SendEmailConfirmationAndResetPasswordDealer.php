<?php

declare(strict_types=1);

namespace App\Message;

use App\Entity\User;

final class SendEmailConfirmationAndResetPasswordDealer
{
    public function __construct(private User $user)
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }
}