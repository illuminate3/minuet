<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\User;
use App\Form\Type\UserType;
use App\Repository\UserRepository;
use App\Service\Admin\UserService;
use App\Utils\UserFormDataSelector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UserController extends BaseController
{
    #[Route(path: '/admin/user', name: 'admin_user')]
    public function index(
        Request $request,
        UserRepository $repository
    ): Response {
        $users = $repository->findUsers($request);

        return $this->render('admin/user/index.html.twig', [
            'title' => 'title.users',
            'action_delete_url' => 'admin_user_delete',
            'action_edit_url' => 'admin_user_edit',
            'new_url' => 'admin_user_new',
            'cancel_url' => 'admin_user',
            'site' => $this->site($request),
            'users' => $users,
        ]);
    }

    #[Route(path: '/admin/user/new', name: 'admin_user_new')]
    public function new(
        Request $request,
        UserService $service,
        UserFormDataSelector $selector
    ): Response {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailVerifiedAt = $selector->getEmailVerifiedAt($form);
            $user->setEmailVerifiedAt($emailVerifiedAt);
            $service->create($user);
            $this->addFlash('success', 'message.created');

            return $this->redirectToRoute('admin_user');
        }

        return $this->render('admin/user/new.html.twig', [
            'title' => 'title.users',
            'cancel_url' => 'admin_user',
            'site' => $this->site($request),
            'page' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing User entity.
     */
    #[Route(path: '/admin/user/{id<\d+>}/edit', name: 'admin_user_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        User $user,
        UserService $service,
        UserFormDataSelector $selector
    ): Response {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->isVerified() !== $selector->getEmailVerified($form)) {
                $emailVerifiedAt = $selector->getEmailVerifiedAt($form);
                $user->setEmailVerifiedAt($emailVerifiedAt);
            }

            $service->update($user);

            return $this->redirectToRoute('admin_user');
        }

        return $this->render('admin/user/edit.html.twig', [
            'title' => 'title.users',
            'cancel_url' => 'admin_user',
            'site' => $this->site($request),
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes an User entity.
     */
    #[Route(path: '/user/{id<\d+>}/delete', name: 'admin_user_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(
        Request $request,
        User $user,
        UserService $service
    ): Response {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_user');
        }

        $service->remove($user);

        return $this->redirectToRoute('admin_user');
    }
}
