<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Account;
use App\Entity\AccountUser;
use App\Entity\Profile;
use App\Entity\User;
use App\Form\Type\RegistrationFormAdminType;
use App\Repository\AccountUserRepository;
use App\Repository\AccountRepository;
use App\Repository\SettingsRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use App\Service\Auth\EmailVerifierAndResetPasswordService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dealer')]
class DealerController extends BaseController
{
    private array $settings;

    public function __construct(
        private MessageBusInterface $messageBus,
        ManagerRegistry $doctrine,
        RequestStack $requestStack,
        SettingsRepository $settingsRepository
    ) {
        parent::__construct($settingsRepository, $doctrine);
        $this->settings = $this->site($requestStack->getCurrentRequest());
    }

    #[Route('/', name: 'app_dealer_index', methods: ['GET'])]
    public function index(
        Request $request,
        AccountRepository $accountRepository,
        AccountUserRepository $accountUserRepository,
    ): Response {

        $account = $accountRepository->findOneBy(['primaryUser' => $this->getUser()->getId()]);
        $testUsers = $accountUserRepository->findBy(['account' => $account->getId()]);

        return $this->render('dealer/index.html.twig', [
            'title' => 'title.dealer',
            'new_url' => 'app_dealer_staff_new',
            'site' => $this->site($request),
            'staffUsers' => $testUsers
        ]);
    }

    #[Route('/new', name: 'app_dealer_staff_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmailVerifierAndResetPasswordService $service, SubscriptionRepository $sr,  AccountRepository $accountRepository, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManage): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormAdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roles[] = 'ROLE_STAFF';
            $user->setProfile(new Profile());
            $user->setRoles($roles);
            $entityManage->persist($user);
            $entityManage->flush();
            // $subscription = $sr->findOneBy(['stripe_price_id' => 'price_1N1LrhHxcL7TQhSHcRcfL89i']);
            $account = $accountRepository->findOneBy(['primaryUser' => $this->getUser()->getId()]);
            $account_user = new AccountUser();
            $account_user->setAccount($account);
            $account_user->setUser($user);
            $entityManage->persist($account_user);
            $entityManage->flush();
            $service->SendEmailConfirmationAndResetPassword($request);

            // $this->addFlash('success', 'message.created');
            return $this->redirectToRoute('app_dealer_index');
        }

        return $this->render('dealer/new.html.twig', [
            'title' => 'title.new.dealer',
            'action_cancel_url' => 'app_dealer_index',
            'site' => $this->site($request),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dealer_staff_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManage, $id): Response
    {
        $form = $this->createForm(RegistrationFormAdminType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $usersrepo = $userRepository->findOneBy(['id' => $id]);
            if (empty($usersrepo)) {
                $this->addFlash('danger', 'message.not_found');
                return $this->redirectToRoute('app_dealer_staff_edit', ['id' =>  (int) $id], Response::HTTP_SEE_OTHER);
            }

            $usersrepo->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManage->persist($user);
            $entityManage->flush();

            // $userRepository->save($usersrepo, true);
            $this->addFlash('success', 'message.updated');

            return $this->redirectToRoute('app_dealer_staff_edit', ['id' => (int) $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message/edit.html.twig', [
            'title' => 'title.edit.dealer',
            'action_cancel_url' => 'app_dealer_index',
            'action_dealer_staff_delete_url' => true,
            'site' => $this->site($request),
            'users' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_dealer_staff_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, userRepository $userRepository, EntityManagerInterface $entityManage, AccountRepository $accountRepository): JsonResponse
    {
        $parent = $entityManage->getRepository(AccountUser::class)->findOneBy(['user' => $request->request->get('id')]);
        $entityManage->remove($parent);

        $parent = $entityManage->getRepository(Account::class)->findOneBy(['primaryUser' => $request->request->get('id')]);
        $entityManage->remove($parent);

        $parent = $entityManage->getRepository(Profile::class)->findOneBy(['user_id' => $request->request->get('id')]);
        $entityManage->remove($parent);

        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('csrf_token'))) {
            $users = $userRepository->findOneBy(['id' => $request->request->get('id')]);
            $userRepository->remove($users, true);
            // $this->addFlash('success', 'message.deleted');
        }
        return new JsonResponse(['status' => 'success', 'data' => $request->request->get('id')]);

        // return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
    }
}
