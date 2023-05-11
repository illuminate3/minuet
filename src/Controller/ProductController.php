<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\FilterRepository;
use App\Repository\ProductRepository;
use App\Repository\SimilarRepository;
use App\Service\URLService;
use App\Transformer\RequestToArrayTransformer;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/product')]
class ProductController extends BaseController
{

    #[Route(path: '/', name: 'product_index', defaults: ['page' => 1], methods: ['GET'])]
    public function search(
        Request $request,
        FilterRepository $repository,
        CategoryRepository $cr,
        EntityManagerInterface $em,
        RequestToArrayTransformer $transformer
    ): Response {
        $searchParams = $transformer->transform($request);
        $make = (int)$request->query->get('make');

    
        $models = $request->query->get('models'); // category_ids of product
        if (!empty($models)) {
            $searchParams["category"] = $models;            
        }else{
            // check for models of the selected make
            if (!empty($make)) {
                $query = $em->createQuery(
                    "SELECT c.id
                            FROM App\Entity\Category c 
                            WHERE c.parent=$make"
                );
                $models = $query->getResult();                
                $models = array_map(function($val){
                    return $val['id'];
                }, $models);
                $searchParams["category"] = $models; 
            }
        }
        $products = $repository->findByFilter($searchParams);        
        $categories = $cr->findBy(["parent" => null]);
        return $this->render(
            'product/index.html.twig',
            [
                'title' => 'ROOT',
                'site' => $this->site($request),
                'products' => $products,
                'categories' => $categories,
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
                'number_of_photos' => \count($product->getImages()),
                //                'show_back_button' => $showBackButton ?? false,
            ]
        );
    }

    // API to fetch subcategories by category-id(parent_id)
    public function fetchSubcategories(
        Request $request,        
        EntityManagerInterface $em
    ): Response {
        try {  
            $categoryId = $request->attributes->get('category_id');         
            $query = $em->createQuery(
                "SELECT c.id, c.name, c.slug
                         FROM App\Entity\Category c 
                         WHERE c.parent=$categoryId"
            );
            $subCategories = $query->getResult();

            $data = [
                "status" => true,
                'data' => $subCategories
            ];
        } catch (\Throwable $th) {
            $data = [
                "status" => false,
                'message' => $th->getMessage()
            ];
        }
        return $this->json($data);
    }
}
