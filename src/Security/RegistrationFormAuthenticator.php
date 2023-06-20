<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

final class RegistrationFormAuthenticator extends AbstractAuthenticator
{

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param  Request  $request
     *
     * @return Passport
     */
    public function authenticate(Request $request): Passport
    {
        $formData = $request->request->all('registration_form');
        $request->getSession()->set(Security::LAST_USERNAME, $formData['username']);

        return new Passport(
            new UserBadge($formData['username']),
            new PasswordCredentials($formData['password']),
            [
                new CsrfTokenBadge('authenticate', $formData['_token']),
            ]
        );
    }

    /**
     * @param  Request         $request
     * @param  TokenInterface  $token
     * @param  string          $firewallName
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->urlGenerator->generate('app_dash'));
    }

    /**
     * @param  Request  $request
     *
     * @return bool|null
     */
    public function supports(Request $request): ?bool
    {
        return false;
    }

    /**
     * @param  Request                  $request
     * @param  AuthenticationException  $exception
     *
     * @return Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new RedirectResponse($this->urlGenerator->generate('security_login'));
    }

}
