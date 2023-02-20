<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Entity\User as AppUser;
use App\Repository\UserRepository;
use App\Service\Auth\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

final class VerificationController extends AbstractController implements AuthController
{
    public function __construct(private EmailVerifier $emailVerifier)
    {
    }


    #[Route('/email/verify', name: 'verify_email')]
    public function verifyUserEmail(
        Request $request,
        VerifyEmailHelperInterface $verifyEmailHelper,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
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

            if ( $user->getIsVerified() === true ) {
                $this->addFlash('warning', 'message.already_verified');
                return $this->redirectToRoute('security_login');
            } else {
                $this->addFlash('danger', $e->getReason());
                return $this->redirectToRoute('app_request_verify_email');
            }

        }

        $user->setIsVerified(true);
        $user->setEmailVerifiedAt(new \DateTime('now'));
        $entityManager->flush();
//        $this->addFlash('success', 'Account Verified! You can now log in.');
        $this->addFlash('success', 'message.email_verified');
        return $this->redirectToRoute('security_login');
    }


    #[Route('/old/email/verify', name: 'old_verify_email')]
    public function OLDverifyUserEmail(Request $request, TranslatorInterface $translator, UserRepository $userRepository): Response
    {

//        if (!$user instanceof AppUser) {
//            $this->addFlash('danger', 'message.email_verified');
////            return;
//        }

//        $user = $userRepository->find($request->query->get('id'));
////        $request->query->get('expires');
////        $request->query->get('token');
//
//        if (!$user->getEmailVerifiedAt()) {
//            throw new DisabledException("Accout Email has not been verified.");
//        }

//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
//        try {
//            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
//        } catch (AccessDeniedException $exception) {
//            $this->addFlash('danger', 'message.verify.email.error');
//
//            return $this->redirectToRoute('app_request_verify_email');
//        }




//        $time = new \DateTime('now');
        if ($request->query->get('expires') <= time() ) {

            echo 'hello';
            die;

//            1676515167 : Thu, 16 Feb 2023 02:39:27 +0000
//            1676533385 : Thu, 16 Feb 2023 07:43:05 +0000

        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('danger', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_dash');
        }

        $this->addFlash('success', 'message.email_verified');

        return $this->redirectToRoute('app_dash');
    }
}
