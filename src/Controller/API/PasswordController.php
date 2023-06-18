<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Service\User\PasswordService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

final class PasswordController extends AbstractController implements AjaxController
{

    /**
     * @param  Request          $request
     * @param  PasswordService  $service
     *
     * @return JsonResponse
     */
    #[Route(path: '/api/user/password', name: 'api_user_password', methods: ['POST'])]
    public function update(Request $request, PasswordService $service): JsonResponse
    {
        try {
            $service->update($request);

            return new JsonResponse([]);
        } catch (Throwable $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

}
