<?php

declare(strict_types=1);

namespace App\Controller\User\Ajax;

use App\Controller\AjaxController;
use App\Entity\Product;
use App\Repository\UserProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use function in_array;

final class ProductController extends AbstractController implements AjaxController
{

    /**
     * @param  Request                $request
     * @param  Product                $product
     * @param  UserProductRepository  $repository
     *
     * @return JsonResponse
     */
    #[Route(path: '/user/product/{id<\d+>}/update', name: 'user_product_update', methods: ['GET'])]
    public function update(Request $request, Product $product, UserProductRepository $repository): JsonResponse
    {
        $state = $request->query->get('state');

        if (!in_array($state, ['published', 'private'], true)) {
            return new JsonResponse(['status' => 'fail'], 422);
        }

        if ($repository->changeState($product, $state)) {
            return new JsonResponse(['status' => 'ok']);
        }

        return new JsonResponse(['status' => 'fail'], 500);
    }
}
