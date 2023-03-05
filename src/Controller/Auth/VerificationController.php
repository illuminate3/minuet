<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Repository\UserRepository;
use App\Service\Auth\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

final class VerificationController extends AbstractController implements AuthController
{
    public function __construct(private EmailVerifier $emailVerifier)
    {
    }

    #[Route(path: '/email/verify', name: 'verify_email')]
    public function verifyUserEmail(
        Request $request,
        VerifyEmailHelperInterface $verifyEmailHelper,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $userRepository->find($request->query->get('id'));
        if (!$user) {
            throw $this->createNotFoundException();
        }
        try {
            $verifyEmailHelper->validateEmailConfirmation(
                $request->getUri(),
                (string) $user->getId(),
                $user->getEmail(),
            );
        } catch (VerifyEmailExceptionInterface $e) {
            if (true === $user->getIsVerified()) {
                $this->addFlash('warning', 'message.already_verified');

                return $this->redirectToRoute('security_login');
            }
            $this->addFlash('danger', $e->getReason());

            return $this->redirectToRoute('auth_request_verify_email');
        }

        $user->setIsVerified(true);
        $user->setEmailVerifiedAt(new \DateTime('now'));
        $entityManager->flush();

        $this->addFlash('success', 'message.email_verified');

        return $this->redirectToRoute('security_login');
    }

}
