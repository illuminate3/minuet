<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\SettingsType;
use App\Repository\SettingsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SettingsController extends BaseController
{

    /**
     * @var array
     */
    private array $settings;

    public function __construct(
        protected SettingsRepository $repository,
        ManagerRegistry $doctrine,
    ) {
        parent::__construct($repository, $doctrine);
        $this->settings = $this->repository->findAllAsArray();
    }

    #[Route(path: '/admin/settings', name: 'admin_settings')]
    public function index(
        Request $request,
    ): Response {
        return $this->render('settings/index.html.twig', [
            'title' => 'title.settings',
            'edit_url' => 'admin_settings_edit',
            'site' => $this->site($request),
            'settings' => $this->settings,
        ]);
    }

    #[Route(path: '/admin/settings/edit', name: 'admin_settings_edit')]
    public function settings(
        Request $request,
    ): Response {
        $form = $this->createForm(SettingsType::class, $this->settings);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->doctrine->getManager();
            $em->persist((object) $this->settings);
            $em->flush();

            $this->addFlash('success', 'message.updated');

            return $this->redirectToRoute('admin_settings');
        }

        return $this->render('settings/edit.html.twig', [
            'title' => 'title.settings',
            'cancel_url' => 'admin_settings',
            'site' => $this->site($request),
            'form' => $form->createView(),
        ]);
    }
}
