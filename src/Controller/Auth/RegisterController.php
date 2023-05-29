<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Controller\BaseController;
use App\Entity\Profile;
use App\Entity\User;
use App\Form\Type\RegistrationFormType;
use App\Form\Type\RequestVerifyUserEmailFormType;
use App\Message\SendEmailConfirmationLink;
use App\Repository\SettingsRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use App\Security\RegistrationFormAuthenticator;
use App\Service\UserService;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

final class RegisterController extends BaseController implements AuthController
{
    private array $settings;
    private MessageBusInterface $messageBus;
    private RegistrationFormAuthenticator $authenticator;
    private Security $security;
    private UserAuthenticatorInterface $userAuthenticator;
    private UserService $service;

    public function __construct(
        MessageBusInterface $messageBus,
        RegistrationFormAuthenticator $authenticator,
        Security $security,
        UserAuthenticatorInterface $userAuthenticator,
        UserService $service,
        ManagerRegistry $doctrine,
        RequestStack $requestStack,
        SettingsRepository $settingsRepository
    ) {
        parent::__construct($settingsRepository, $doctrine);
        $this->settings = $this->site($requestStack->getCurrentRequest());
        $this->messageBus = $messageBus;
        $this->authenticator = $authenticator;
        $this->security = $security;
        $this->userAuthenticator = $userAuthenticator;
        $this->service = $service;
    }

    /**
     * @param  Request  $request
     *
     * @return Response|null
     * @throws InvalidArgumentException
     */
    #[Route(path: '/register', name: 'auth_register', methods: ['GET','POST'])]
    public function register(Request $request, MailerInterface $mailer): ?Response
    {
        if ($this->security->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_dash');
        }

        if ($this->settings['allow_register'] !== '1') {
            $this->addFlash('danger', 'message.registration_suspended');

            return $this->redirectToRoute('auth_no_register');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setProfile(new Profile());
            $this->service->create($user);
            $lastInsertedID = $user->getId();
            if (isset($form->getData()->getRoles()[0]) && $form->getData()->getRoles()[0] == 'ROLE_BUYER') {
                $this->messageBus->dispatch(new SendEmailConfirmationLink($user));
            }
            $this->addFlash('success', 'message.registration_successful');
            if (isset($form->getData()->getRoles()[0]) && $form->getData()->getRoles()[0] == 'ROLE_DEALER') {
                return $this->redirectToRoute('dealer_choose_plan', ['id' => $lastInsertedID]);
            }
            // return $this->authenticate($user, $request);
        }

        return $this->render('auth/register/register.html.twig', [
            'title' => 'title.register',
            'site' => $this->settings,
            'error' => null,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/closed', name: 'auth_no_register')]
    public function noRegister(): ?Response
    {
        if ($this->security->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_dash');
        }

        if ($this->settings['allow_register'] === '1') {
            return $this->redirectToRoute('auth_register');
        }

        return $this->render('auth/register/closed-register.html.twig', [
            'title' => 'title.closed_register',
            'site' => $this->settings,
        ]);
    }

    /**
     * requestVerifyUserEmail.
     */
    #[Route(path: '/request/verify-email', name: 'auth_request_verify_email')]
    public function requestVerifyUserEmail(
        Request $request,
        UserRepository $userRepository
    ): Response {
        $form = $this->createForm(RequestVerifyUserEmailFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // generate a signed url and email it to the user
            $user = $userRepository->findOneByEmail(
                $form->get('email')->getData());

            if ($user) {
                $this->messageBus->dispatch(
                    new SendEmailConfirmationLink($user));

                return $this->forward(
                    'App\Controller\Auth\MessageController::authMessages',
                    [
                        'title' => 'title.verify_account_email_sent',
                        'message' => 'message.verify_account_email_sent',
                        'link' => 'app_index',
                        'error_message' => null,
                        'link_title' => 'action.return_to_root',
                    ]
                );
            }

            $this->addFlash('error', 'Email NEED TRANSLATION.');
        }

        $error = null;
        if ($request->getSession()->getFlashBag() !== null) {
            $error = $request->getSession()->getFlashBag()->get('danger');
        }

        return $this->render(
            'auth/registration/request_verify_email.html.twig',
            [
                'title' => 'title.request_new_verification_email',
                'site' => $this->settings,
                'error' => $error,
                'form' => $form->createView(),
            ]
        );
    }

    private function authenticate(User $user, Request $request): ?Response
    {
        return $this->userAuthenticator->authenticateUser(
            $user,
            $this->authenticator,
            $request
        );
    }

    /**
     * After create account to redirect chooseplan page.
     */
    #[Route(path: '/dealer/choosePlan/{id}', name: 'dealer_choose_plan', methods: ['GET', 'POST'])]
    public function choosePlan(Request $request, SubscriptionRepository $subscriptionRepository, $id)
    {
        // Get pages
        $subscriptions = $subscriptionRepository->findAll();
        return $this->render('plans/index.html.twig', [
            'title' => 'title.subscription',
            'site' => $this->site($request),
            'subscriptions' => $subscriptions,
            'userId' => $id
        ]);
    }
}
