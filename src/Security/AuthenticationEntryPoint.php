<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function start(Request $request, AuthenticationException $authException = null): RedirectResponse
    {
        // add a custom flash message and redirect to the login page
        $request->getSession()->getFlashBag()->add('notice', 'You have to login in order to access this page.');


//        if ($this->getUser()) {
//            $session = $request->getSession();
//            $session->getFlashBag()->set('verify_email_error', 'YOU ARE LOGGED IN DUH');
//        }

        return new RedirectResponse($this->urlGenerator->generate('auth_login'));
//        return $this->redirectToRoute('auth_login');

    }
}