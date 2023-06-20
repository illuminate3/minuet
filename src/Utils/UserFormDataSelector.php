<?php

declare(strict_types=1);

namespace App\Utils;

use DateTimeImmutable;
use Symfony\Component\Form\FormInterface;

final class UserFormDataSelector
{

    /**
     * @param  FormInterface  $form
     *
     * @return bool
     */
    public function getEmailVerified(FormInterface $form): bool
    {
        return $form->get('email_verified')->getNormData();
    }

    /**
     * @param  FormInterface  $form
     *
     * @return DateTimeImmutable|null
     */
    public function getEmailVerifiedAt(FormInterface $form): ?DateTimeImmutable
    {
        return $this->getEmailVerified($form)
            ? new DateTimeImmutable('now')
            : null;
    }

}
