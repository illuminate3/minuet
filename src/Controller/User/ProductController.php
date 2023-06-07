<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use App\Entity\Product;
use App\Form\Type\ProductType;
use App\Repository\FilterRepository;
use App\Service\ProductService;
use App\Transformer\RequestToArrayTransformer;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use App\Service\StripeService;
use Symfony\Bundle\SecurityBundle\Security;

final class ProductController extends BaseController
{

    /**
     * @param  Request                    $request
     * @param  FilterRepository           $repository
     * @param  RequestToArrayTransformer  $transformer
     *
     * @return Response
     */
    #[Route(path: '/user/products', name: 'user_products', defaults: ['page' => 1], methods: ['GET'])]
    public function index(
        Request $request,
        FilterRepository $repository,
        RequestToArrayTransformer $transformer,
        AccountRepository $accountRepository,
        AccountUserRepository $accountUserRepository,
        Security $security,
        StripeService $stripeService,
    ): Response {
        $searchParams = $transformer->transform($request);
        $products = $repository->findByFilter($searchParams);
        
        $resp = $stripeService->checkStripeSubscriptionActive($security,$accountRepository,$accountUserRepository);                      
        if ($resp === 'account') {
            $this->addFlash('error','message.stripe_in_active');  
            return $this->redirectToRoute('app_pricing');
        }elseif (!$resp) {
            $this->addFlash('error','message.stripe_in_active');  
            return $this->redirectToRoute('security_login');      
        }        
        return $this->render('user/product/index.html.twig', [
            'title' => 'title.products',
            'site' => $this->site($request),
            'new_url' => 'user_product_new',
            'products' => $products,
            'searchParams' => $searchParams,
        ]);
    }


    /**
     * @param  Request         $request
     * @param  ProductService  $service
     *
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route(path: '/user/product/new', name: 'user_product_new')]
    public function new(Request $request, ProductService $service): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->create($product);

            return $this->redirectToRoute('user_image_edit', ['id' => $product->getId()]);
        }

        return $this->render('user/product/new.html.twig', [
            'title' => 'title.products',
            'site' => $this->site($request),
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @param  Request         $request
     * @param  Product         $product
     * @param  ProductService  $service
     *
     * @return Response
     */
    #[Route(path: '/user/product/{id<\d+>}/edit', name: 'user_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductService $service): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->update($product);

            return $this->redirectToRoute('user_products');
        }

        return $this->render('user/product/edit.html.twig', [
            'title' => 'title.products',
            'site' => $this->site($request),
            'cancel_url' => 'user_products',
            'form' => $form->createView(),
        ]);
    }


    /**
     * @param  Request         $request
     * @param  Product         $product
     * @param  ProductService  $service
     *
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route(path: '/product/{id<\d+>}/delete', name: 'user_product_delete', methods: ['POST'])]
//    #[IsGranted('ROLE_ADMIN')]
    public function delete(
        Request $request,
        Product $product,
        ProductService $service,
    ): Response {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('user_products');
        }

        $service->delete($product);

        return $this->redirectToRoute('user_products');
    }
}
