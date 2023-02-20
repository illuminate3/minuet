<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Controller\BaseController;
use App\Entity\Profile;
use App\Entity\User;
use App\Form\Type\RequestVerifyUserEmailFormType;
use App\Form\Type\RegistrationFormType;
use App\Message\SendEmailConfirmationLink;
use App\Repository\SettingsRepository;
use App\Repository\UserRepository;
use App\Security\RegistrationFormAuthenticator;
use App\Service\Admin\UserService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

final class RegisterController extends BaseController implements AuthController
{
    private array $settings;

    public function __construct(
        private MessageBusInterface $messageBus,
        private RegistrationFormAuthenticator $authenticator,
        private Security $security,
        private UserAuthenticatorInterface $userAuthenticator,
        private UserService $service,
        ManagerRegistry $doctrine,
        RequestStack $requestStack,
        SettingsRepository $settingsRepository
    ) {
        parent::__construct($settingsRepository, $doctrine);
        $this->settings = $this->site($requestStack->getCurrentRequest());
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request): ?Response
    {
        if ($this->security->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_dash');
        } elseif ('1' !== $this->settings['anyone_can_register']) {
            $this->addFlash('danger', 'message.registration_suspended');

            return $this->redirectToRoute('no_register');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setProfile(new Profile());
            $this->service->create($user);
            $this->messageBus->dispatch(new SendEmailConfirmationLink($user));

            return $this->authenticate($user, $request);
        }

        return $this->render('auth/register.html.twig', [
            'registrationForm' => $form,
            'site' => $this->settings,
            'error' => null,
        ]);
    }

    #[Route('/closed', name: 'no_register')]
    public function noRegister(Request $request): ?Response
    {
        if ($this->security->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_dash');
        }

        if ('1' === $this->settings['anyone_can_register']) {
            return $this->redirectToRoute('register');
        }

        return $this->render('auth/no-register.html.twig', [
            'site' => $this->settings,
        ]);
    }

    /**
     * requestVerifyUserEmail.
     */
    #[Route('/request-verify-email', name: 'app_request_verify_email')]
    public function requestVerifyUserEmail(
        Request $request,
        UserRepository $userRepository
    ): Response {
        $form = $this->createForm(RequestVerifyUserEmailFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // generate a signed url and email it to the user
            $user = $userRepository->findOneByEmail($form->get('email')->getData());

            if ($user) {
//                $this->emailVerifier->sendEmailConfirmation(
//                    'app_verify_email',
//                    $user,
//                    (new TemplatedEmail())
//                        ->from(new Address('email@example.com', 'Sender'))
//                        ->to($user->getEmail())
//                        ->subject('Validation Link')
//                        ->htmlTemplate('auth/registration/confirmation_email.html.twig')
//                );

                $this->messageBus->dispatch(new SendEmailConfirmationLink($user));

                // do anything else you need here, like flash message
                $this->addFlash('success', 'message.email.resent');

                return $this->redirectToRoute('auth_messages');
            }

            $this->addFlash('error', 'Email inconnu.');

        }

        return $this->render('auth/registration/request.html.twig', [
            'requestForm' => $form->createView(),
            'title' => 'Request Verification Email',
            'site' => $this->settings,
            'error' => null,
        ]);
    }

    #[Route('/auth/messages', name: 'auth_messages')]
    public function authTimeout(Request $request): ?Response
    {
        return $this->render('auth/auth-messages.html.twig', [
            'site' => $this->settings,
        ]);
    }

    private function authenticate(User $user, Request $request): ?Response
    {
        return $this->userAuthenticator->authenticateUser(
            $user,
            $this->authenticator,
            $request
        );
    }
}
