<?php

declare(strict_types=1);

namespace App\Controller\User\Ajax;

use App\Controller\AbstractImageController;
use App\Controller\AjaxController;
use App\Entity\Product;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ImageController extends AbstractImageController implements AjaxController
{
    #[Route(path: '/user/image/{id<\d+>}/upload', name: 'user_image_upload', methods: ['POST'])]
//    #[IsGranted('PROPERTY_EDIT', subject: 'product', message: 'You cannot change this product.')]
    public function upload(Product $product, Request $request, FileUploader $fileUploader): JsonResponse
    {
        return $this->uploadImage($product, $request, $fileUploader);
    }

    /**
     * Sort images.
     */
    #[Route(path: '/user/image/{id<\d+>}/sort', name: 'user_image_sort', methods: ['POST'])]
//    #[IsGranted('PROPERTY_EDIT', subject: 'product', message: 'You cannot change this product.')]
    public function sort(Request $request, Product $product): JsonResponse
    {
        return $this->sortImages($request, $product);
    }
}
