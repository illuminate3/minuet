<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Entity\User;
use App\Message\SendResetPasswordLink;
use App\Repository\ResettingRepository;
use App\Repository\SettingsRepository;
use App\Service\AbstractService;
use App\Utils\TokenGenerator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class MessengerService extends AbstractService
{
//    private ResettingRepository $repository;
//    private MessageBusInterface $messageBus;
//    private TokenGenerator $generator;
    private array $settings;

    public function __construct(
//        CsrfTokenManagerInterface $tokenManager,
//        RequestStack $requestStack,
//        ResettingRepository $repository,
//        MessageBusInterface $messageBus,
//        TokenGenerator $generator,
//        SettingsRepository $settingsRepository
        ManagerRegistry $doctrine,
        RequestStack $requestStack,
        SettingsRepository $settingsRepository,
    ) {
        parent::__construct( $settingsRepository, $doctrine);
//        $this->repository = $repository;
//        $this->messageBus = $messageBus;
//        $this->generator = $generator;
        $this->settings = $this->site($requestStack->getCurrentRequest());
    }


    private function message($title, $message, $link = NULL): ?Response
    {
        return $this->render('auth/message.html.twig', [
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'site' => $this->settings,
        ]);
    }

//    public function sendResetPasswordLink(Request $request): void
//    {
//        /** @var User $user */
//        $user = $this->repository->findOneBy(['email' => $request->get('user_email')['email']]);
//        $this->updateToken($user);
//        $this->messageBus->dispatch(new SendResetPasswordLink($user));
//        $this->addFlash('success', 'message.emailed_reset_link');
//    }

//    /**
//     * Generating a Confirmation Token.
//     */
//    private function generateToken(): string
//    {
//        return $this->generator->generateToken();
//    }

//    /**
//     * Refreshing a Confirmation Token.
//     */
//    private function updateToken(User $user): void
//    {
//        $this->repository->setToken($user, $this->generateToken());
//    }
}
