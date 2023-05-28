<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Controller\BaseController;
use App\Repository\SettingsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

final class MessageController extends BaseController
{
    private array $settings;

    public function __construct(
        ManagerRegistry $doctrine,
        RequestStack $requestStack,
        SettingsRepository $settingsRepository
    ) {
        parent::__construct($settingsRepository, $doctrine);
        $this->settings = $this->site($requestStack->getCurrentRequest());
    }

    /**
     * Generic Message Page.
     */
    public function authMessages(
        $title,
        $message,
        $link = null,
        $linkTitle = null,
    ): ?Response {
        return $this->render('auth/message.html.twig', [
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'link_title' => $linkTitle,
            'site' => $this->settings,
        ]);
    }

}
