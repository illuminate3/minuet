<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SitemapController extends AbstractController
{
    private const DEFAULTS = ['_format' => 'xml'];

    /**
     * @return Response
     */
    #[Route(path: '/sitemap.xml', name: 'sitemap', defaults: self::DEFAULTS)]
    public function siteMap(): Response
    {
        return $this->render('sitemap/sitemap.xml.twig');
    }

    /**
     * @param  Request         $request
     * @param  PageRepository  $pageRepository
     *
     * @return Response
     */
    #[Route(path: '/sitemap/pages.xml', name: 'pages_sitemap', defaults: self::DEFAULTS)]
    public function pages(
        Request $request,
        PageRepository $pageRepository
    ): Response {
// $locale = $request->getLocale();
        $pages = $pageRepository->findLatest($request);

        return $this->render('sitemap/pages.xml.twig', [
            'pages' => $pages,
        ]);
    }

}
