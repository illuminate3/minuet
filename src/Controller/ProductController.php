<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Repository\FilterRepository;
use App\Repository\ProductRepository;
use App\Transformer\RequestToArrayTransformer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function count;

#[Route('/product')]
class ProductController extends BaseController
{
    #[Route(path: '/', name: 'product_index', defaults: ['page' => 1], methods: ['GET'])]
    public function search(
        Request $request,
        FilterRepository $repository,
        ProductRepository $productRepository,
        RequestToArrayTransformer $transformer
    ): Response {
        $searchParams = $transformer->transform($request);
        $products = $repository->findByFilter($searchParams);
//        $products = $productRepository->findAll();

        return $this->render(
            'product/index.html.twig',
            [
                'title' => 'ROOT',
                'site' => $this->site($request),
                'products' => $products,
                //                'searchParams' => $searchParams,
            ]
        );
    }

//    #[Route(path: '/{citySlug}/{slug}/{id<\d+>}', name: 'product_show', methods: ['GET'])]
//    #[IsGranted(
//        'PROPERTY_VIEW',
//        subject: 'product',
//        message: 'Properties can only be shown to their owners.'
//    )]
    #[Route(path: '/{slug}/{id<\d+>}', name: 'product_show', methods: ['GET'])]
    public function productShow(
        Request $request,
//        URLService $url,
        Product $product,
//        SimilarRepository $repository
    ): Response {
//        if (!$url->isCanonical($product, $request)) {
//            return $this->redirect($url->generateCanonical($product), 301);
//        } elseif ($url->isRefererFromCurrentHost($request)) {
//            $showBackButton = true;
//        }

        return $this->render(
            'product/show.html.twig',
            [
                'title' => $product->getTitle(),
                'site' => $this->site($request),
                'product' => $product,
                //                'products' => $repository->findSimilarProperties($product),
                'number_of_photos' => count($product->getImages()),
                //                'show_back_button' => $showBackButton ?? false,
            ]
        );
    }
}
