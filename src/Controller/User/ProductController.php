<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use App\Entity\Image;
use App\Entity\MakeModel;
use App\Entity\Product;
use App\Entity\ProductTrims;
use App\Controller\AbstractImageController;
use App\Service\FileUploader;
use App\Form\Type\ProductCustomType;
use App\Utils\GeneralUtil;
use App\Form\Type\ProductType;
use App\Repository\AccountRepository;
use App\Repository\FilterRepository;
use App\Repository\MakeModelRepository;
use App\Service\Admin\ProductService;
use App\Transformer\RequestToArrayTransformer;
use DateTimeImmutable;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProductController extends BaseController
{
    public AbstractImageController $abstractImageController;

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
        RequestToArrayTransformer $transformer
    ): Response {

        $searchParams = $transformer->transform($request);
        $products = $repository->findByFilter($searchParams);
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
    public function new(Request $request, ProductService $service,AccountRepository $accountRepository, MakeModelRepository $makeModelRepository, FileUploader $fileUploader): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        
        $pageNo = $request->request->get('page_no');
        if($pageNo == 2)
        {
            $form = $this->createForm(ProductCustomType::class, $product);
        }
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($pageNo == 2)
            {
                $year = $request->request->get('year');
                $make = $request->request->get('make');
                $model = $request->request->get('model');
                $exists = $makeModelRepository->findBy(array('year' => $year, 'make' => $make, 'model' => $model));
                $requestTrim = $request->request->all('trim');
                if(!count($exists) > 0)
                {
                    $makeModel = new MakeModel();
                    $makeModel->setYear($year);
                    $makeModel->setMake($make);
                    $makeModel->setModel($model);
                    $makeModel->setBodyStyle('');
                    $makeModelRepository->save($makeModel, true);
                    $lastInsertedId = $makeModel->getId();
                    $product->setYear($lastInsertedId);
                    $product->setMake($lastInsertedId);
                    $product->setModel($lastInsertedId);
                }
                else
                {
                    $newId = $exists[0]->getId();
                    $product->setYear($newId);
                    $product->setMake($newId);
                    $product->setModel($newId);
                }
                $user = $this->getUser();

                $account = $accountRepository->findOneBy(['primaryUser' => $user->getId()]);
                $product->setAccount($account);
                $product->setTrim(implode(", ", $requestTrim));
                $product->setVinResposne(base64_decode($request->request->get('responseData')));
                $service->save($product);
                $lastInsertedId = $product->getId();
                $productImageFile = $form->get('images')->getData();
                $fileName = $fileUploader->upload($productImageFile);

                $image = new Image();
                $image->setProduct($product)
                    ->setSortOrder(1)
                    ->setFile($fileName)
                    ->setCreatedAt(new DateTimeImmutable('now'))
                    ->setModifiedAt(new DateTimeImmutable('now'));

                $entityManager = $this->doctrine->getManager();
                $entityManager->persist($image);
                $entityManager->flush();
            
                $arrResponseData = json_decode(base64_decode($request->request->get('responseData')),true);
                foreach($requestTrim as $key => $value)
                {
                    $founKey = array_search($value, array_column($arrResponseData['trims'], 'name'));
                    if($founKey !== false)
                    { 
                        $arrResponseData['trims'][$founKey]['product_id'] = $lastInsertedId;
                        $productTrims = new ProductTrims($arrResponseData['trims'][$founKey]);
                        $service->save($productTrims);
                    }
                }
                return $this->redirectToRoute('user_products');
            }
            
            $vinNumber = 'vin/'.$product->getvin();
            $endPoint = 'auth/login';

            $sessionCart = $request->getSession();
            $sessionExists = $sessionCart->get('carApiToken');
            $jwtResponse = $this->is_jwt_valid($sessionExists);
            if($jwtResponse == false)
            {
                $validateRequest = GeneralUtil::CurlCallLoginApi($endPoint, $request, $data = array(), 'POST');    
            }

            $responseData = GeneralUtil::CURLCallCARAPI($vinNumber, $request, $data = array(), 'GET');
            if(!empty($responseData))
            {
                $arrResponseData = json_decode(json_encode($responseData), true);
                $products = new Product();
                $formData = $this->createForm(ProductCustomType::class, $products);
                $formData->handleRequest($request);
                $makes = $makeModelRepository->findAllUniqueMake();
                $years = $makeModelRepository->findAllUniqueYear();
                $models = $makeModelRepository->findAllUniqueModel($arrResponseData['make']);
                $trim = explode(", ", $arrResponseData['trim']);
                return $this->render('user/product/new.html.twig', [
                    'title' => 'title.products',
                    'site' => $this->site($request),
                    'product_response' => json_decode(json_encode($responseData), true),
                    'product_response_data' => base64_encode(json_encode($responseData)),
                    'vehical_identification_number' => $product->getvin(),
                    'form' => $formData,
                    'makes' => $makes,
                    'models' => $models,
                    'years' => $years,
                    'trim' => $trim,
                    'page_no' => 2
                ]); 
            }
        }
        else
        {
            return $this->render('user/product/new.html.twig', [
                'title' => 'title.products',
                'site' => $this->site($request),
                'form' => $form->createView(),
                'vehical_identification_number' => '',
                'makes' => array(),
                'product_response' => array(),
                'product_response_data' => '',
                'models' => array(),
                'page_no' => 1
            ]);
        }
    }

    /**
     * @param  Request         $request
     * @param  Product         $product
     * @param  ProductService  $service
     *
     * @return Response
     */
    #[Route(path: '/user/product/{id<\d+>}/edit', name: 'user_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductService $service, AccountRepository $accountRepository, MakeModelRepository $makeModelRepository, FileUploader $fileUploader): Response
    {
        $allTrims = json_decode($product->getVinResposne(), true);
        $trims = $product->getProductTrims();
        $makes = $makeModelRepository->findAllUniqueMake();
        $years = $makeModelRepository->findAllUniqueYear();
        $makeModelId = $product->getModel();
        $modelData = $makeModelRepository->findAllMakeModelYear($makeModelId);
        $models = $makeModelRepository->findAllUniqueModel($modelData[0]->getMake());
        $selectedYear = $modelData[0]->getYear();
        $selectedMake = $modelData[0]->getMake();
        $selectedModel = $modelData[0]->getModel();
        $form = $this->createForm(ProductCustomType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->save($product);

            return $this->redirectToRoute('user_products');
        }

        return $this->render('user/product/edit.html.twig', [
            'title' => 'title.products',
            'site' => $this->site($request),
            'cancel_url' => 'user_products',
            'form' => $form->createView(),
            'product' => $product,
            'makes' => $makes,
            'years'=> $years,
            'models' => $models,
            'selectedyear' => $selectedYear,
            'selectedmake' => $selectedMake,
            'selectedmodel' => $selectedModel,
            'selectedtrims' => $trims,
            'alltrims' => $allTrims['trims']
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

    #[Route(path: '/user/product/{year}', name: 'user_product_get_make', methods: ['POST'])]
    public function getMakeList(Request $request, MakeModelRepository $makeModelRepository): JsonResponse
    {
        $yearId = $request->request->get('year');

        $arrMakes = $makeModelRepository->findAllMakeUsingYear($yearId);
        $options = '<option value>Select Make</option>';
        foreach($arrMakes as $key => $value)
        {
            $options .= '<option value="'.$value["make"].'">'.$value["make"].'</option>';
        }
    
        return new JsonResponse(['status' => 'success', 'data' => $options]);
    }

    #[Route(path: '/user/product/{year}/{make}', name: 'user_product_get_model', methods: ['POST'])]
    public function getModelList(Request $request, MakeModelRepository $makeModelRepository): JsonResponse
    {
        $yearId = $request->request->get('year');
        $makeId = $request->request->get('make');

        $arrModels = $makeModelRepository->findAllModelUsingYearAndMake($yearId, $makeId);
        $options = '<option value>Select Model</option>';
        foreach($arrModels as $key => $value)
        {
            $options .= '<option value="'.$value["model"].'">'.$value["model"].'</option>';
        }
        return new JsonResponse(['status' => 'success', 'data' => $options]);
    }

    function is_jwt_valid($jwt, $secret = 'secret') {
        $tokenParts = explode('.', $jwt);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signature_provided = $tokenParts[2];
        $expiration = json_decode($payload)->exp;
        $is_token_expired = ($expiration - time()) < 0;
        $base64_url_header = $this->base64url_encode($header);
        $base64_url_payload = $this->base64url_encode($payload);
        $signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $secret, true);
        $base64_url_signature = $this->base64url_encode($signature);
    
        // verify it matches the signature provided in the jwt
        $is_signature_valid = ($base64_url_signature === $signature_provided);
        
        if ($is_token_expired || !$is_signature_valid) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function base64url_encode($str) {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }

}
