<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

final class URLService
{
    public function __construct(private RouterInterface $router)
    {
    }

//    // Check slugs.
//    public function isCanonical(Property $property, Request $request): bool
//    {
//        $citySlug = $request->attributes->get('citySlug', '');
//        $slug = $request->attributes->get('slug', '');
//
//        if ($property->getCity()->getSlug() !== $citySlug || $property->getSlug() !== $slug) {
//            return false;
//        }
//
//        return true;
//    }

//    // Generate correct canonical URL.
//    public function generateCanonical(Property $property): string
//    {
//        return $this->router->generate('property_show', [
//            'id' => $property->getId(),
//            'citySlug' => $property->getCity()->getSlug(),
//            'slug' => $property->getSlug(),
//        ], UrlGeneratorInterface::ABSOLUTE_URL);
//    }

    /**
     *
     * Check referer host.
     *
     * @param  Request  $request
     *
     * @return bool
     */
    public function isRefererFromCurrentHost(Request $request): bool
    {
        if (preg_match('/' . $request->getHost() . '/', $request->server->getHeaders()['REFERER'] ?? '')) {
            return true;
        }

        return false;
    }

}
