<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Entity\User;
use App\Message\SendResetPasswordLink;
use App\Repository\ResettingRepository;
use App\Service\AbstractService;
use App\Utils\TokenGenerator;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class PasswordResetService extends AbstractService
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
     * @throws Exception
     */
    public function sendResetPasswordLink(Request $request): void
    {
        /** @var User $user */
        $user = $this->repository->findOneBy(['email' => $request->get('user_email')['email']]);
        $this->updateToken($user);
        $this->messageBus->dispatch(new SendResetPasswordLink($user));
        $this->addFlash('success', 'message.emailed_reset_link');
    }

    /**
     * Generating a Confirmation Token.
     *
     * @throws Exception
     */
    private function generateToken(): string
    {
        return $this->generator->generateToken();
    }

    /**
     * Refreshing a Confirmation Token.
     *
     * @throws Exception
     */
    private function updateToken(User $user): void
    {
        $this->repository->setToken($user, $this->generateToken());
    }
}
