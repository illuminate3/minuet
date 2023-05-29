<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CategoryController extends BaseController
{
//    #[Route(path: '/admin/categories', name: 'admin_categories')]
//    public function index(CategoryRepository $categoryRepository): Response
//    {
//        $categories = $categoryRepository->findBy([], ['categoryOrder' => 'asc']);
//
//        return $this->render('category/index.html.twig', compact('categories'));
//    }

    #[Route(path: '/admin/category', name: 'admin_category')]
    public function index(
        Request $request,
        CategoryRepository $repository
    ): Response {
//        $categories = $repository->findUsers($request);
        $categories = $repository->findBy([], ['categoryOrder' => 'asc']);

        return $this->render('category/index.html.twig', [
            'title' => 'title.categories',
            'action_delete_url' => 'admin_category_delete',
            'action_edit_url' => 'admin_category_edit',
            'new_url' => 'admin_category_new',
            'cancel_url' => 'admin_category',
            'site' => $this->site($request),
            'categories' => $categories,
        ]);
    }

    #[Route(path: '/admin/category/new', name: 'admin_category_new')]
    public function new(
        Request $request,
        CategoryRepository $repository
    ): Response {
//        $categories = $repository->findUsers($request);
        $categories = $repository->findBy([], ['categoryOrder' => 'asc']);

        return $this->render('category/index.html.twig', [
            'title' => 'title.categories',
            //            'action_delete_url' => 'admin_category_delete',
            //            'action_edit_url' => 'admin_category_edit',
            //            'new_url' => 'admin_category_new',
            'action_delete_url' => 'admin_category',
            'action_edit_url' => 'admin_category_edit',
            'new_url' => 'admin_category',
            'cancel_url' => 'admin_category',
            'site' => $this->site($request),
            'categories' => $categories,
        ]);
    }

    #[Route(path: '/admin/category/{id<\d+>}/edit', name: 'admin_category_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        CategoryRepository $repository
    ): Response {
//        $categories = $repository->findUsers($request);
        $categories = $repository->findBy([], ['categoryOrder' => 'asc']);

        return $this->render('category/index.html.twig', [
            'title' => 'title.categories',
            //            'action_delete_url' => 'admin_category_delete',
            //            'action_edit_url' => 'admin_category_edit',
            //            'new_url' => 'admin_category_new',
            'action_delete_url' => 'admin_category',
            'action_edit_url' => 'admin_category',
            'new_url' => 'admin_category',
            'cancel_url' => 'admin_category',
            'site' => $this->site($request),
            'categories' => $categories,
        ]);
    }

    #[Route(path: '/admin/category/{id<\d+>}/delete', name: 'admin_category_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        CategoryRepository $repository
    ): Response {
//        $categories = $repository->findUsers($request);
        $categories = $repository->findBy([], ['categoryOrder' => 'asc']);

        return $this->render('category/index.html.twig', [
            'title' => 'title.categories',
            //            'action_delete_url' => 'admin_category_delete',
            //            'action_edit_url' => 'admin_category_edit',
            //            'new_url' => 'admin_category_new',
            'action_delete_url' => 'admin_category',
            'action_edit_url' => 'admin_category',
            'new_url' => 'admin_category',
            'cancel_url' => 'admin_category',
            'site' => $this->site($request),
            'categories' => $categories,
        ]);
    }

}
