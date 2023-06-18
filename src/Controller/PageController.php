<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/page')]
final class PageController extends BaseController
{

    /**
     * @param  Request         $request
     * @param  PageRepository  $pageRepository
     *
     * @return Response
     */
    #[Route(path: '/', name: 'page_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route('/rss.xml', name: 'page_rss', defaults: ['page' => '1', '_format' => 'xml'], methods: ['GET'])]
    public function pageIndex(
        Request $request,
        PageRepository $pageRepository
    ): Response {
        $pages = $pageRepository->findPublished($request);

        return $this->render('page/index.html.twig',
            [
                'title' => 'title.pages',
                'site' => $this->site($request),
                'pages' => $pages,
            ]
        );
    }

    /**
     * @param  Request         $request
     * @param  PageRepository  $pageRepository
     *
     * @return Response
     */
    #[Route(path: '/{slug}', name: 'page', methods: ['GET'])]
    public function pageShow(
        Request $request,
        PageRepository $pageRepository
    ): Response {
        $slug = $request->attributes->get('slug');

        if ($slug === null) {
            $pages = $pageRepository->findLatest($request);

            return $this->render('page/index.html.twig',
                [
                    'title' => 'title.pages',
                    'site' => $this->site($request),
                    'pages' => $pages,
                ]
            );
        }

        $page = $pageRepository->findOneBy(['locale' => $request->getLocale(), 'slug' => $slug])
            ?? $pageRepository->findOneBy(['slug' => $slug]);

        return $this->render('page/show.html.twig',
            [
                'title' => 'title.pages',
                'site' => $this->site($request),
                'page' => $page,
            ]
        );
    }

}
