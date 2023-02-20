<?php

namespace App\Controller;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashController extends BaseController
{
    #[Route('/dash', name: 'app_dash')]
    public function index(Request $request, Security $security): Response
    {

// Redirect Admin Users
        if ($security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('dash/index.html.twig', [
            'title' => 'Dash',
            'site'  => $this->site($request),
            'error' => null,
        ]);
    }
}
