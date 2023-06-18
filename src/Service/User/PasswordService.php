<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use function count;

final class PasswordService
{

    private UserService $service;
    private TokenStorageInterface $tokenStorage;
    private ValidatorInterface $validator;

    public function __construct(
        UserService $service,
        TokenStorageInterface $tokenStorage,
        ValidatorInterface $validator
    ) {
        $this->service = $service;
        $this->tokenStorage = $tokenStorage;
        $this->validator = $validator;
    }

    /**
     * @param  Request  $request
     *
     * @return void
     * @throws Exception
     */
    public function update(Request $request): void
    {
        $violations = $this->findViolations($request);

        if (count($violations) > 0) {
            throw new Exception($violations[0]->getMessage());
        }

        /* @var $user User */
        $user = $this->tokenStorage->getToken()->getUser();
        $user->setPassword($request->get('password1'));
        $this->service->update($user);
    }

    /**
     * @param  Request  $request
     *
     * @return ConstraintViolationListInterface
     */
    private function findViolations(Request $request): ConstraintViolationListInterface
    {
        $password1 = $this->validator->validate($request->get('password1'), [
            new Assert\Length(null, 10),
        ]);

        $password2 = $this->validator->validate($request->get('password2'), [
            new Assert\EqualTo($request->get('password1'), null, "Passwords Don't Match"),
        ]);

        return count($password1) > 0 ? $password1 : $password2;
    }

}
