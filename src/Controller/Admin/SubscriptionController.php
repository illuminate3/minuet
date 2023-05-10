<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Subscription;
use App\Form\Type\SubscriptionType;
use App\Repository\SubscriptionRepository;
use App\Service\Admin\SubscriptionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/subscription')]
class SubscriptionController extends BaseController
{
    #[Route('/', name: 'admin_subscription', methods: ['GET'])]
    public function index(
        Request $request,
        SubscriptionRepository $subscriptionRepository,
    ): Response {
        // Get pages
        $subscriptions = $subscriptionRepository->findAll();

        return $this->render('admin/subscription/index.html.twig', [
            'title' => 'title.subscription',
            'action_delete_url' => 'admin_subscription_delete',
            'action_edit_url' => 'admin_subscription_edit',
            'cancel_url' => 'admin_subscription',
            'new_url' => 'admin_subscription_new',
            'site' => $this->site($request),
            'subscriptions' => $subscriptions,
        ]);
    }

    #[Route('/new', name: 'admin_subscription_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SubscriptionService $subscriptionService,
    ): Response {
        $subscription = new Subscription();
        $form = $this->createForm(SubscriptionType::class, $subscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subscriptionService->create($subscription);
            $this->addFlash('success', 'message.created');

            return $this->redirectToRoute('admin_subscription');
        }

        return $this->render('admin/subscription/new.html.twig', [
            'title' => 'title.subscription',
            'cancel_url' => 'admin_subscription',
            'site' => $this->site($request),
            'subscription' => $subscription,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_subscription_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Subscription $subscription,
        EntityManagerInterface $entityManager,
        SubscriptionService $subscriptionService,
    ): Response {
        $form = $this->createForm(SubscriptionType::class, $subscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subscriptionService->edit($subscription);
            $this->addFlash('success', 'message.updated');

            return $this->redirectToRoute('admin_subscription');
        }

        return $this->render('admin/subscription/edit.html.twig', [
            'title' => 'title.subscription',
            'cancel_url' => 'admin_subscription',
            'site' => $this->site($request),
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_subscription_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Subscription $subscription,
        EntityManagerInterface $entityManager,
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $subscription->getId(), $request->request->get('_token'))) {
            $subscriptionService->delete($subscription);
        }

        return $this->redirectToRoute('admin_subscription');
    }
}
