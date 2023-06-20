<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Cache\ClearCache;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

abstract class AbstractService
{
    use ClearCache;

    private SessionInterface $session;
    private CsrfTokenManagerInterface $tokenManager;

    public function __construct(CsrfTokenManagerInterface $tokenManager, RequestStack $requestStack)
    {
        $this->tokenManager = $tokenManager;
        $this->session = $requestStack->getSession();
    }

    /**
     *
     * Checks the validity of a CSRF token.
     *
     * @param  string       $id
     * @param  string|null  $token
     *
     * @return bool
     */
    protected function isCsrfTokenValid(string $id, ?string $token): bool
    {
        return $this->tokenManager->isTokenValid(new CsrfToken($id, $token));
    }

    /**
     *
     * Adds a flash message to the current session for type.
     *
     * @param  string  $type
     * @param  string  $message
     *
     * @return void
     */
    protected function addFlash(string $type, string $message): void
    {
        $this->session->getFlashBag()->add($type, $message);
    }

}
