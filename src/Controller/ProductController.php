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

use function count;

#[Route('/product')]
class ProductController extends BaseController
{

    /**
     * @param  Request                    $request
     * @param  FilterRepository           $repository
     * @param  CategoryRepository         $categoryRepository
     * @param  RequestToArrayTransformer  $transformer
     *
     * @return Response
     */
    #[Route(path: '/{make<\w+>?}/{models?}', name: 'product_index', defaults: ['page' => 1], methods: ['GET'])]
    public function search(
        Request $request,
        FilterRepository $repository,
        CategoryRepository $categoryRepository,
        RequestToArrayTransformer $transformer
    ): Response {
        $searchParams = $transformer->transform($request);
        $make = (int)$request->get('make');
        $selectedModels = [];
        $models = $request->get('models');
        $subCategories = [];
        if ($make > 0) {
            $subCategories = $categoryRepository->fetchSubCategories($make);
        }
        if (!empty($models)) {
            $selectedModels = array_map('intval', explode(",", $models));
            $searchParams["category"] = $selectedModels;
        } else {
            $modelIds = [];
            foreach ($subCategories as $key => $value) {
//                array_push($modelIds, $value->getId());
                $modelIds[] = $value->getId();
            }
            $searchParams["category"] = $modelIds;
        }
        $products = $repository->findByFilter($searchParams);
        $categories = $categoryRepository->findBy(["parent" => null]);


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
                "isDisabled" => (count($products) === 0 && empty($models))  ? 'disabled' : ''
            ]
        );
    }

    /**
     * @param  Request  $request
     * @param  Product  $product
     *
     * @return Response
     */
    #[Route(path: '/{slug}/{id<\d+>}', name: 'product_show', methods: ['GET'])]
    public function productShow(
        Request $request,
        Product $product,
    ): Response {

        return $this->render(
            'product/show.html.twig',
            [
                'title' => $product->getTitle(),
                'site' => $this->site($request),
                'product' => $product,
                'number_of_photos' => count($product->getImages()),
            ]
        );
    }

}
