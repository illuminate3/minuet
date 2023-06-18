<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use App\Entity\User;
use App\Form\Type\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/user/dash')]
final class ProfileController extends BaseController
{

    /**
     * @param  Request  $request
     *
     * @return Response
     */
    #[Route(path: '/', name: 'user_profile')]
    public function index(
        Request $request,
    ): Response {

        /** @var User $user */
        $user = $this->getUser();
        $profile = $user->getProfile();

        return $this->render('user/profile/index.html.twig', [
            'title' => 'title.profile',
            'action_edit_url' => 'user_profile_edit',
            'site' => $this->site($request),
            'profile' => $profile,
        ]);
    }

    /**
     * @param  Request                 $request
     * @param  EntityManagerInterface  $entityManager
     * @param  AuthenticationUtils     $helper
     *
     * @return Response
     */
    #[Route(path: '/edit', name: 'user_profile_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        AuthenticationUtils $helper,
    ): Response {

        /** @var User $user */
        $user = $this->getUser();

        $profile = $user->getProfile();

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        $error = $helper->getLastAuthenticationError();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($profile);
            $entityManager->flush();
            $this->addFlash('success', 'message.updated');
        }

        return $this->render('user/profile/edit.html.twig', [
            'title' => 'title.profile',
            'action_cancel_url' => 'user_profile',
            'site' => $this->site($request),
            'error' => $error,
            'form' => $form->createView(),
            'profile' => $profile,
        ]);
    }

}
