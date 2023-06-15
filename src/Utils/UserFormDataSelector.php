<?php

declare(strict_types=1);

namespace App\Utils;

use DateTimeImmutable;
use Symfony\Component\Form\FormInterface;

final class UserFormDataSelector
{
    public function getEmailVerified(FormInterface $form): bool
    {
        return $form->get('email_verified')->getNormData();
    }

    public function getEmailVerifiedAt(FormInterface $form): ?DateTimeImmutable
    {
        return $this->getEmailVerified($form)
            ? new DateTimeImmutable('now')
            : null;
    }
}
