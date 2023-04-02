<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Repository\SettingsRepository;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class SettingsService extends AbstractService
{
    private SettingsRepository $repository;

    public function __construct(
        CsrfTokenManagerInterface $tokenManager,
        RequestStack $requestStack,
        SettingsRepository $repository,
    ) {
        parent::__construct($tokenManager, $requestStack);
        $this->repository = $repository;
    }

    /**
     * Update settings in database.
     */
    public function updateSettings(array $formData): void
    {
        $this->repository->updateSettings($formData);
        $this->addFlash('success', 'message.updated');
    }
}
