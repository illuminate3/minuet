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

    #[Route(path: '/{make<\w+>?}/{models?}', name: 'product_index', defaults: ['page' => 1], methods: ['GET'])]
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
        $subCategories = [];
        if ($make>0) {
            $subCategories = $cr->fetchSubCategories($make);
        }
        if (!empty($models)) {
            $selectedModels = array_map('intval',explode(",",$models));
            $searchParams["category"] = $selectedModels;            
        }else{            
            $modelIds = [];
            foreach ($subCategories as $key => $value) {
                array_push($modelIds,$value->getId());
            }                                           
            $searchParams["category"] = $modelIds; 
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
                'models' => $selectedModels,
                'categories' => $categories,
                'subCategories' => $subCategories,
                "isDisabled"=>count($products)>0 ? '' : 'disabled'
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
}
