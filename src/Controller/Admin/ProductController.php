<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Product;
use App\Form\Type\ProductType;
use App\Repository\ProductRepository;
use App\Service\Admin\ProductService;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class ProductController extends BaseController
{
    #[Route(path: '/admin/product', name: 'admin_product')]
    public function index(
        Request $request,
        ProductRepository $repository
    ): Response {
        $products = $repository->findAll();

        return $this->render('admin/product/index.html.twig', [
            'title' => 'title.products',
            'action_delete_url' => 'admin_product_delete',
            'action_edit_url' => 'admin_product_edit',
            'new_url' => 'admin_product_new',
            'cancel_url' => 'admin_product',
            'site' => $this->site($request),
            'products' => $products,
        ]);
    }

    #[Route('/admin/product/new', name: 'admin_product_new')]
    public function add(
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger,
        PictureService $pictureService,
        ProductService $productService,
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productService->create($product);
            $this->addFlash('success', 'message.created');

            return $this->redirectToRoute('admin_page');
        }

//        if ($productForm->isSubmitted() && $productForm->isValid()) {
//            $images = $productForm->get('images')->getData();
//
//            foreach ($images as $image) {
//                $folder = 'product';
//                $image_file = $pictureService->add($image, $folder, 300, 300);
//
//                $img = new Image();
//                $img->setName($image_file);
//                $product->addImage($img);
//            }

        // $price = $product->getPrice() * 100;
        // $product->setPrice($price);

//            $em->persist($product);
//            $em->flush();

//            $this->addFlash('success', 'Produit ajouté avec succès');

//            return $this->redirectToRoute('admin_product_index');
//        }

        // return $this->render('admin/product/add.html.twig',[
        //     'productForm' => $productForm->createView()
        // ]);

//        return $this->renderForm('admin/product/add.html.twig', compact('productForm'));
        // ['productForm' => $productForm]

        return $this->render('admin/product/new.html.twig', [
            'title' => 'title.products',
            'cancel_url' => 'admin_product',
            'site' => $this->site($request),
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route(path: '/admin/product/{id<\d+>}/edit', name: 'admin_product_edit', methods: ['GET', 'POST'])]
    public function edit(
        Product $product,
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger,
        PictureService $pictureService,
        ProductService $productService,
    ): Response {
        $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);

//        // $price = $product->getPrice() / 100;
//        // $product->setPrice($price);
//
//        $form = $this->createForm(ProductFormType::class, $product);
//        $form->handleRequest($request);
//
//        // If submitted and Valid
//        if ($form->isSubmitted() && $form->isValid()) {
////            // Get Image
////            $images = $form->get('images')->getData();
////            foreach ($images as $image) {
////                // Destination Folder
////                $folder = 'product';
////                // Add Image
////                $image_file = $pictureService->add($image, $folder, 300, 300);
////                $img = new Image();
////                $img->setName($image_file);
////                $product->addImage($img);
////            }
//
//            // Generate Slug
//            $slug = $slugger->slug($product->getTitle());
//            $product->setSlug($slug);
//
//            // Round the Price
//            // $price = $product->getPrice() * 100;
//            // $product->setPrice($price);
//
//            $em->persist($product);
//            $em->flush();
//
//            $this->addFlash('success', 'Produit modifié avec succès');
//
//            return $this->redirectToRoute('admin_product_index');
//        }

//        return $this->render('admin/product/edit.html.twig', [
//            'productForm' => $form->createView(),
//            'product' => $product,
//        ]);

//        return $this->render('admin/product/edit.html.twig', [
//            'title' => 'title.products',
//            'cancel_url' => 'admin_product',
//            'site' => $this->site($request),
//            'form' => $form,
//        ]);

        // return $this->renderForm('admin/product/edit.html.twig', compact('productForm'));
        // ['productForm' => $form]
//    }
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productService->edit($product);
            $this->addFlash('success', 'message.updated');

            return $this->redirectToRoute('admin_product');
        }

        return $this->render('admin/product/edit.html.twig', [
            'title' => 'title.products',
            'cancel_url' => 'admin_product',
            'site' => $this->site($request),
            'form' => $form,
        ]);
    }

    #[Route(path: '/admin/product/{id<\d+>}/delete', name: 'admin_product_delete', methods: ['GET', 'POST'])]
    public function delete(
        Request $request,
        Product $product,
        ProductService $productService
    ): Response {
        $this->denyAccessUnlessGranted('PRODUCT_DELETE', $product);

//        return $this->render('admin/product/index.html.twig');
//    }
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_page');
        }
        $productService->delete($page);

        return $this->redirectToRoute('admin_page');
    }

//    #[Route(path: '/admin/product/image/{id<\d+>}/delete', name: 'admin_product_delete_image', methods: ['DELETE'])]
//    public function deleteImage(Image $image, Request $request, EntityManagerInterface $em, PictureService $pictureService): JsonResponse
//    {
//        $data = json_decode($request->getContent(), true);
//
//        if ($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])) {
//            $name = $image->getTitle();
//
//            if ($pictureService->delete($name, 'product', 300, 300)) {
//                $em->remove($image);
//                $em->flush();
//
//                return new JsonResponse(['success' => true], 200);
//            }
//
//            return new JsonResponse(['error' => 'message.delete_error'], 400);
//        }
//
//        return new JsonResponse(['error' => 'message.invalid_token'], 400);
//    }
}
