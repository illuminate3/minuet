<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

final class VerificationController extends AbstractController implements AuthController
{

    /**
     * @param  Request                     $request
     * @param  VerifyEmailHelperInterface  $verifyEmailHelper
     * @param  UserRepository              $userRepository
     * @param  EntityManagerInterface      $entityManager
     *
     * @return Response
     */
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
        if ($user->getIsVerified() === true) {
            $this->addFlash('warning', 'message.already_verified');
            return $this->redirectToRoute('security_login');
        }
        try {
            $verifyEmailHelper->validateEmailConfirmation(
                $request->getUri(),
                (string) $user->getId(),
                $user->getEmail(),
            );
        } catch (VerifyEmailExceptionInterface $e) {            
            $this->addFlash('danger', $e->getReason());
            return $this->redirectToRoute('auth_request_verify_email');
        }

        $user->setIsVerified(true);
        $user->setEmailVerifiedAt(new DateTimeImmutable('now'));
        $entityManager->flush();

        $this->addFlash('success', 'message.email_verified');

        return $this->redirectToRoute('security_login');
    }

}
