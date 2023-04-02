<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Service\Admin\DashboardService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class DashboardController extends BaseController
{
    #[Route(path: '/admin', name: 'admin_dashboard')]
    public function index(
        Request $request,
        DashboardService $service,
        AuthenticationUtils $helper,
        Security $security,
    ): Response
    {
        $pages = $service->countPages();

        $users = $service->countUsers();

        return $this->render('admin/dashboard/index.html.twig', [
            'title' => 'title.dashboard',
            'site' => $this->site($request),
            'error' => $helper->getLastAuthenticationError(),
            'number_of_pages' => $pages,
            'number_of_users' => $users,
        ]);
    }
}
