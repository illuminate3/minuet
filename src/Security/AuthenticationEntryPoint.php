<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param  Request                       $request
     * @param  AuthenticationException|null  $authException
     *
     * @return RedirectResponse
     */
    public function start(
        Request $request,
        AuthenticationException $authException = null
    ): RedirectResponse {
        // add a custom flash message and redirect to the login page
        $request->getSession()->getFlashBag()->add(
            'danger',
            'You have to login in order to access this page 6666666666666666.');

        return new RedirectResponse(
            $this->urlGenerator->generate('security_login'));
    }

}
