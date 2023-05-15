<?php
declare(strict_types=1);
namespace App\Controller;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\FilterRepository;
use App\Transformer\RequestToArrayTransformer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use function count;

#[Route('/product')]
class ProductController extends BaseController
{

    #[Route(path: '/', name: 'product_index', defaults: ['page' => 1], methods: ['GET','POST'])]
    public function search(
        Request $request,
        FilterRepository $repository,
        CategoryRepository $cr,
        EntityManagerInterface $em,
        RequestToArrayTransformer $transformer
    ): Response {
        $searchParams = $transformer->transform($request);
        $make = (int)$request->get('make');
        $selectedModels = [];
        $models = $request->get('models');
        if (!empty($models)) {
            $selectedModels = array_map('intval', $models);
            $searchParams["category"] = $selectedModels;            
        }else{            
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
        $products = $repository->findByFilter($searchParams);

        return $this->render(
            'product/index.html.twig',
            [
                'title' => 'ROOT',
                'site' => $this->site($request),
                'products' => $products,
                'make' => $make,
                'models' => json_encode($selectedModels),
                'categories' => $categories,
                //                'searchParams' => $searchParams,
            ]
        );
    }

 
    #[Route(path: '/{slug}/{id<\d+>}', name: 'product_show', methods: ['GET'])]
    public function productShow(
        Request $request,
        //        URLService $url,
        Product $product,
        //        SimilarRepository $repository
    ): Response {
       
        return $this->render(
            'product/show.html.twig',
            [
                'title' => $product->getTitle(),
                'site' => $this->site($request),
                'product' => $product,
                'number_of_photos' => \count($product->getImages()),
                'number_of_photos' => count($product->getImages()),                
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
