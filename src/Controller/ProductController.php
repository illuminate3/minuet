<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Form\Type\ProductType;
use App\Repository\ProductRepository;
use App\Service\Admin\ProductService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProductController extends BaseController
{
    #[Route(path: '/admin/product', name: 'admin_product')]
    public function index(
        Request $request,
        ProductRepository $repository
    ): Response {
        $products = $repository->findAll();

        return $this->render('product/index.html.twig', [
            'title' => 'title.products',
            'action_delete_url' => 'admin_product_delete',
            'action_edit_url' => 'admin_product_edit',
            'new_url' => 'admin_product_new',
            'cancel_url' => 'admin_product',
            'site' => $this->site($request),
            'products' => $products,
        ]);
    }

    /**
     * @param  Request         $request
     * @param  ProductService  $productService
     *
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route('/admin/product/new', name: 'admin_product_new')]
    public function add(
        Request $request,
        ProductService $productService,
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productService->create($product);
            $this->addFlash('success', 'message.created');

            return $this->redirectToRoute('admin_product');
        }

        return $this->render('product/new.html.twig', [
            'title' => 'title.products',
            'cancel_url' => 'admin_product',
            'site' => $this->site($request),
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/product/{id<\d+>}/edit', name: 'admin_product_edit', methods: ['GET', 'POST'])]
    public function edit(
        Product $product,
        Request $request,
        ProductService $productService,
    ): Response {
        $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productService->edit($product);
            $this->addFlash('success', 'message.updated');

            return $this->redirectToRoute('admin_product');
        }

        return $this->render('product/edit.html.twig', [
            'title' => 'title.products',
            'cancel_url' => 'admin_product',
            'site' => $this->site($request),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param  Request         $request
     * @param  Product         $product
     * @param  ProductService  $productService
     *
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route(path: '/admin/product/{id<\d+>}/delete', name: 'admin_product_delete', methods: ['GET', 'POST'])]
    public function delete(
        Request $request,
        Product $product,
        ProductService $productService
    ): Response {
        $this->denyAccessUnlessGranted('PRODUCT_DELETE', $product);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_product');
        }
        $productService->delete($product);

        return $this->redirectToRoute('admin_product');
    }

}
