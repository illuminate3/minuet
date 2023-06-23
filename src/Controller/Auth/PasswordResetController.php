<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Controller\BaseController;
use App\Entity\User;
use App\Form\Type\PasswordChangeType;
use App\Form\Type\PasswordType;
use App\Form\Type\UserEmailType;
use App\Repository\ResettingRepository;
use App\Repository\UserRepository;
use App\Service\Auth\PasswordResetService;
use App\Service\User\UserService;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PasswordResetController extends BaseController implements AuthController
{

    /**
     * @param  PasswordResetService  $service
     * @param  Request               $request
     *
     * @return Response
     * @throws Exception
     */
    #[Route(path: '/password/reset', name: 'auth_password_reset', methods: ['GET|POST'])]
    public function passwordReset(
        PasswordResetService $service,
        UserRepository $userRepository,
        Request $request
    ): Response {
        $form = $this->createForm(UserEmailType::class, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneBy(["email"=>$form->getData()["email"]]);
            $passwordRequestedAt = $user->getPasswordRequestedAt();
            // Create a DateTime object with the current time
            $currentTime = new DateTime();

            // Create a DateTime object with the password_requested_at value
            $requestedAtTime = new DateTime($passwordRequestedAt->format('Y-m-d H:i:s'));

            // Calculate the time difference between the current time and the password requested time
            $timeDifference = $currentTime->diff($requestedAtTime);
                if ($timeDifference->i <= 15) {
                return $this->forward(
                    'App\Controller\Auth\MessageController::authMessages',
                    [
                        'title' => 'title.password_reset_emailed',
                        'message' => 'message.password_request_ban',
                        'link' => null,                   
                    ]
                );
            }

            $service->sendResetPasswordLink($request);

            return $this->forward(
                'App\Controller\Auth\MessageController::authMessages',
                [
                    'title' => 'title.password_reset_emailed',
                    'message' => 'message.emailed_reset_link',
                    'link' => null,                   
                ]
            );
        }

        return $this->render('auth/password/password_reset.html.twig', [
            'title' => 'title.forgot_password',
            'site' => $this->site($request),
            'link' => 'auth_password_reset',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param  ResettingRepository  $repository
     * @param  Request              $request
     * @param  string               $token
     *
     * @return Response
     */
    #[Route(path: '/password/reset/{token}', name: 'password_reset_confirm', methods: ['GET|POST'])]
    public function passwordResetConfirm(
        ResettingRepository $repository,
        Request $request,
        string $token
    ): Response {
        /** @var User $user */
        $user = $repository->findOneBy(['confirmation_token' => $token]);

        if (!$user) {
            // Token not found.
            $this->addFlash('danger', 'message.token_processed');

            return new RedirectResponse($this->generateUrl('security_login'));
        }

        if (!$user->isPasswordRequestNonExpired($user::TOKEN_TTL)) {
            // Token has expired.
            $this->addFlash('danger', 'message.token_expired');

            return new RedirectResponse(
                $this->generateUrl('auth_password_reset'));
        }

        $form = $this->createForm(PasswordType::class, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setIsVerified(true);
            $user->setEmailVerifiedAt(new DateTimeImmutable('now'));
            $repository->setPassword($user, $form->getNormData()['password']);
            $this->addFlash('success', 'message.password_has_been_reset');

            return $this->redirectToRoute('security_login');
        }

        return $this->render('auth/password/change_password.html.twig', [
            'title' => 'title.change_password',
            'site' => $this->site($request),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param  Request                 $request
     * @param  EntityManagerInterface  $entityManager
     *
     * @return Response
     */
    #[Route('/password/change', name: 'user_password_change', methods: ['GET', 'POST'])]
    public function passwordChange(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {

        // check to see if user is logged in
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('security_login');
        }

        $form = $this->createForm(PasswordChangeType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'message.password_has_been_reset');

            return $this->redirectToRoute('app_dash');
        }

        return $this->render('user/password/password_change.html.twig', [
            'title' => 'title.change_password',
            'action_cancel_url' => 'app_dash',
            'site' => $this->site($request),
            'form' => $form->createView(),
        ]);
    }

}
