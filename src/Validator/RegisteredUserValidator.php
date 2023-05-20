<?php

declare(strict_types=1);

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class RegisteredUserValidator extends ConstraintValidator
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validate($value, Constraint $constraint): void
    {
        /* @var $constraint RegisteredUser */

        if ($value === null || $value === '') {
            return;
        }

        $existingUser = $this->userRepository->findOneBy(['email' => $value]);

        if ($existingUser === null) {
            $this->context->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }
}
