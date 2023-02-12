<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashController extends AbstractController
{
    #[Route('/dash', name: 'app_dash')]
    public function index(): Response
    {
        return $this->render('dash/index.html.twig', [
            'controller_name' => 'DashController',
        ]);
    }
}
