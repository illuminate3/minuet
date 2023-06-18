<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingController extends BaseController
{

    /**
     * @param  Request  $request
     *
     * @return Response
     */
    #[Route('/', name: 'app_index')]
    public function index(
        Request $request,
    ): Response {
        return $this->render('landing/index.html.twig', [
            'title' => 'ROOT',
            'site' => $this->site($request),
            'error' => null,
        ]);
    }

}
