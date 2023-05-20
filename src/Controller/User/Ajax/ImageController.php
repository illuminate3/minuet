<?php

declare(strict_types=1);

namespace App\Controller\User\Ajax;

use App\Controller\AbstractImageController;
use App\Controller\AjaxController;
use App\Entity\Product;
use App\Service\FileUploader;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ImageController extends AbstractImageController implements AjaxController
{

    /**
     * @param  Product       $product
     * @param  Request       $request
     * @param  FileUploader  $fileUploader
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route(path: '/user/image/{id<\d+>}/upload', name: 'user_image_upload', methods: ['POST'])]
    public function upload(Product $product, Request $request, FileUploader $fileUploader): JsonResponse
    {
        return $this->uploadImage($product, $request, $fileUploader);
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    #[Route(path: '/user/image/{id<\d+>}/sort', name: 'user_image_sort', methods: ['POST'])]
    public function sort(Request $request): JsonResponse
    {
        return $this->sortImages($request);
    }
}
