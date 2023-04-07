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

final class ProfileController extends BaseController
{
    #[Route(path: '/user/profile', name: 'user_profile')]
    public function profile(
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

        return $this->render('user/profile/profile.html.twig', [
            'title' => 'title.profile',
            'site' => $this->site($request),
            'error' => $error,
            'form' => $form,
            'profile' => $profile,
        ]);
    }

}
