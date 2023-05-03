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
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ProductController extends AbstractController implements AjaxController
{
    #[Route(path: '/user/product/{id<\d+>}/update', name: 'user_product_update', methods: ['GET'])]
//    #[IsGranted('PROPERTY_EDIT', subject: 'product', message: 'You cannot change this product.')]
    public function update(Request $request, Product $product, UserProductRepository $repository): JsonResponse
    {
        $state = $request->query->get('state');

        if (!\in_array($state, ['published', 'private'], true)) {
            return new JsonResponse(['status' => 'fail'], 422);
        }

        if ($repository->changeState($product, $state)) {
            return new JsonResponse(['status' => 'ok']);
        }

        return new JsonResponse(['status' => 'fail'], 500);
    }
}
