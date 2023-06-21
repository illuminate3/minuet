<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/dash')]
class DashController extends BaseController
{

    /**
     * @param  Request   $request
     * @param  Security  $security
     *
     * @return Response
     */
    #[Route('/', name: 'app_dash')]
    public function index(
        Request $request,
        Security $security,
): Response
    {
        if (!$security->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_index');
        }

        $user = $security->getUser();

        return $this->render('dash/index.html.twig', [
            'title' => 'title.dashboard',
            'site' => $this->site($request),
            'error' => null,
            'user' => $user
        ]);
    }

}
