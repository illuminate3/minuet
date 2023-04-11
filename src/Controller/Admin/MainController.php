<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
//    #[Route('/', name: 'main')]
//    public function index(CategoriesRepository $categoriesRepository): Response
//    {
//        return $this->render('main/index.html.twig', [
//            'categories' => $categoriesRepository->findBy([], ['categoryOrder' => 'asc'])
//        ]);
//    }
}
