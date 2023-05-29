<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Admin\DashboardService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class DashboardController extends BaseController
{

    /**
     * @param  Request              $request
     * @param  DashboardService     $service
     * @param  AuthenticationUtils  $helper
     *
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route(path: '/admin', name: 'admin_dashboard')]
    public function index(
        Request $request,
        DashboardService $service,
        AuthenticationUtils $helper,
    ): Response {
        $pages = $service->countPages();

        $users = $service->countUsers();

        return $this->render('dashboard/index.html.twig', [
            'title' => 'title.dashboard',
            'site' => $this->site($request),
            'error' => $helper->getLastAuthenticationError(),
            'number_of_pages' => $pages,
            'number_of_users' => $users,
        ]);
    }
}
