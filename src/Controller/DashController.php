<?php

declare(strict_types=1);

namespace App\Controller;
use App\Repository\MessageRepository;
use App\Repository\ThreadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/dash')]
class DashController extends BaseController
{

    private EntityManagerInterface $entityManager;

    #[Route('/', name: 'app_dash')]
    public function index(
        Request $request,
        Security $security,
        EntityManagerInterface $entityManager,
        ThreadRepository $threadRepository,
        MessageRepository $messageRepository
): Response
    {
        $this->entityManager = $entityManager;
        $user = $security->getUser();
        return $this->render('dash/index.html.twig', [
            'title' => 'title.dashboard',
            'site' => $this->site($request),
            'error' => null,
            'user' => $user
        ]);
    }

}
