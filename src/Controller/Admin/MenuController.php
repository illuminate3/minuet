<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Menu;
use App\Form\Type\MenuType;
use App\Repository\MenuRepository;
use App\Service\Admin\MenuService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class MenuController extends BaseController
{
    #[Route(path: '/admin/menu', name: 'admin_menu')]
    public function index(
        Request $request,
        MenuRepository $repository
    ): Response {
        $menus = $repository->findAll();

        return $this->render('admin/menu/index.html.twig', [
            'title' => 'title.menu',
            'action_delete_url' => 'admin_menu_delete',
            'action_edit_url' => 'admin_menu_edit',
            'new_url' => 'admin_menu_new',
            'site' => $this->site($request),
            //            'menu' => $repository->findItems(),
            'menus' => $menus,
        ]);
    }

    #[Route(path: '/admin/menu/new', name: 'admin_menu_new')]
    public function new(
        Request $request,
        MenuService $menuService,
    ): Response {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $menuService->create($menu);
            $this->addFlash('success', 'message.created');

            return $this->redirectToRoute('admin_menu');
        }

        return $this->render('admin/menu/new.html.twig', [
            'title' => 'title.menu',
            'cancel_url' => 'admin_menu',
            'site' => $this->site($request),
            'menu' => $menu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing menu item.
     */
    #[Route(path: '/admin/menu/{id<\d+>}/edit', name: 'admin_menu_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Menu $menu,
        MenuService $menuService,
    ): Response {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $menuService->edit($menu);
            $this->addFlash('success', 'message.updated');

            return $this->redirectToRoute('admin_menu');
        }

        return $this->render('admin/menu/edit.html.twig', [
            'title' => 'title.menu',
            'cancel_url' => 'admin_menu',
            'site' => $this->site($request),
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a menu item.
     */
    #[Route(path: '/admin/menu/{id<\d+>}/delete', name: 'admin_menu_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Menu $menu): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_menu');
        }

        $em = $this->doctrine->getManager();
        $em->remove($menu);
        $em->flush();
        $this->addFlash('success', 'message.deleted');

        return $this->redirectToRoute('admin_menu');
    }
}
