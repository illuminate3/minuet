<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Page;
use App\Form\Type\PageType;
use App\Repository\PageRepository;
use App\Service\Admin\PageService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class PageController extends BaseController
{

    /**
     * @param  Request         $request
     * @param  PageRepository  $repository
     *
     * @return Response
     */
    #[Route(path: '/admin/page', name: 'admin_page', defaults: ['page' => 1], methods: ['GET'])]
    public function index(
        Request $request,
        PageRepository $repository,
    ): Response {
        // Get pages
        $pages = $repository->findLatest($request);

        return $this->render('admin/page/index.html.twig', [
            'title' => 'title.pages',
            'action_delete_url' => 'admin_page_delete',
            'action_edit_url' => 'admin_page_edit',
            'cancel_url' => 'admin_page',
            'new_url' => 'admin_page_new',
            'site' => $this->site($request),
            'pages' => $pages,
        ]);
    }

    /**
     * @param  Request      $request
     * @param  PageService  $pageService
     *
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route(path: '/admin/page/new', name: 'admin_page_new')]
    public function new(
        Request $request,
        PageService $pageService,
    ): Response {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pageService->create($page);
            $this->addFlash('success', 'message.created');

            return $this->redirectToRoute('admin_page');
        }

        return $this->render('admin/page/new.html.twig', [
            'title' => 'title.pages',
            'cancel_url' => 'admin_page',
            'site' => $this->site($request),
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @param  Request      $request
     * @param  Page         $page
     * @param  PageService  $pageService
     *
     * @return Response
     */
    #[Route(path: '/admin/page/{id<\d+>}/edit', name: 'admin_page_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Page $page,
        PageService $pageService,
    ): Response {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pageService->edit($page);
            $this->addFlash('success', 'message.updated');

            return $this->redirectToRoute('admin_page');
        }

        return $this->render('admin/page/edit.html.twig', [
            'title' => 'title.pages',
            'cancel_url' => 'admin_page',
            'site' => $this->site($request),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param  Request      $request
     * @param  Page         $page
     * @param  PageService  $pageService
     *
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route(path: '/admin/page/{id<\d+>}/delete', name: 'admin_page_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(
        Request $request,
        Page $page,
        PageService $pageService
    ): Response {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_page');
        }
        $pageService->delete($page);

        return $this->redirectToRoute('admin_page');
    }

}
