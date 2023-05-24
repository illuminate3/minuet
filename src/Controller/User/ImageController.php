<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use App\Entity\Image;
use App\Entity\Product;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ImageController extends BaseController
{

    /**
     * @param  Request  $request
     * @param  Product  $product
     *
     * @return Response
     */
    #[Route(path: '/user/image/{id<\d+>}/edit', name: 'user_image_edit')]
    public function edit(Request $request, Product $product): Response
    {
        $images = $product->getImages();

        return $this->render('user/image/edit.html.twig', [
            'title' => 'title.images',
            'site' => $this->site($request),
            'cancel_url' => 'user_products',
            'images' => $images,
            'product_id' => $product->getId(),
        ]);
    }

//    'action_delete_url' => 'admin_menu_delete',
//    'action_edit_url' => 'admin_menu_edit',
//    'new_url' => 'admin_menu_new',
//    'cancel_url' => 'user_products',


    /**
     * Deletes Image entity.
     */
    #[Route(path: '/product/{product_id<\d+>}/image/{id<\d+>}/delete', name: 'user_image_delete', methods: ['POST'])]
//    #[IsGranted('ROLE_ADMIN')]
    public function delete(
        Request $request,
        Image $image,
        FileUploader $fileUploader
    ): Response {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute(
                'user_image_edit',
                ['id' => $request->attributes->get('product_id')]
            );
        }

        // Delete from db
        $em = $this->doctrine->getManager();
        $em->remove($image);
        $em->flush();

        // Delete file from folder
        $fileUploader->remove($image->getFile());

        $this->addFlash('success', 'message.deleted');

        return $this->redirectToRoute(
            'user_image_edit',
            ['id' => $request->attributes->get('product_id')]
        );
    }
}
