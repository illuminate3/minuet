<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Entity\User;
use App\Message\SendEmailConfirmationAndResetPassword;
use App\Repository\ResettingRepository;
use App\Service\AbstractService;
use App\Utils\TokenGenerator;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class EmailVerifierAndResetPasswordService extends AbstractService
{
    private ResettingRepository $repository;
    private MessageBusInterface $messageBus;
    private TokenGenerator $generator;

    public function __construct(
        CsrfTokenManagerInterface $tokenManager,
        RequestStack $requestStack,
        ResettingRepository $repository,
        MessageBusInterface $messageBus,
        TokenGenerator $generator
    ) {
        parent::__construct($tokenManager, $requestStack);
        $this->repository = $repository;
        $this->messageBus = $messageBus;
        $this->generator = $generator;
    }

    /**
     * @param  Request  $request
     *
     * @return void
     * @throws Exception
     */
    public function SendEmailConfirmationAndResetPassword(Request $request): void
    {
        /** @var User $user */
        $user = $this->repository->findOneBy(['email' => $request->get('registration_form_admin')['email']]);
        $this->updateToken($user);
        $this->messageBus->dispatch(new SendEmailConfirmationAndResetPassword($user));
        //$this->addFlash('success', 'message.emailed_reset_link');
    }

    /**
     *
     * Generating a Confirmation Token.
     *
     * @return string
     * @throws Exception
     */
    private function generateToken(): string
    {
        return $this->generator->generateToken();
    }

    /**
     *
     * Refreshing a Confirmation Token.
     *
     * @param  User  $user
     *
     * @return void
     * @throws Exception
     */
    private function updateToken(User $user): void
    {
        $this->repository->setToken($user, $this->generateToken());
    }

}
