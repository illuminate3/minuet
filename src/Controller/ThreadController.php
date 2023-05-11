<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Thread;
use App\Form\ThreadType;
use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use App\Repository\ProductRepository;
use App\Repository\ThreadRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/thread')]
class ThreadController extends BaseController
{
    #[Route('/', name: 'app_thread_index', methods: ['GET'])]
    public function index(
        Request $request,
        Security $security,
        ProductRepository $productRepository,
        AccountRepository $accountRepository,
        AccountUserRepository $accountUserRepository,
    ): Response {
        // get the account information the user is registered to
        $user = $security->getUser();
        $accountUser = $accountUserRepository->findOneBy(['user' => $user->getId()]);
        // get the account information
        $account = $accountRepository->findOneBy(['id' => $accountUser->getAccount()]);
        $account_id = $account->getId();

        $products = $productRepository->findAllThreadsByAccount($account_id);

        return $this->render('thread/index.html.twig', [
            //            'title' => 'title.dashboard',
            'title' => $account_id,
            'site' => $this->site($request),
            'products' => $products,
        ]);
    }

    #[Route('/new', name: 'app_thread_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ThreadRepository $threadRepository): Response
    {
        $thread = new Thread();
        $form = $this->createForm(ThreadType::class, $thread);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $threadRepository->save($thread, true);

            return $this->redirectToRoute('app_thread_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('thread/new.html.twig', [
            'thread' => $thread,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_thread_show', methods: ['GET'])]
    public function show(Thread $thread): Response
    {
        return $this->render('thread/show.html.twig', [
            'thread' => $thread,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_thread_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Thread $thread, ThreadRepository $threadRepository): Response
    {
        $form = $this->createForm(ThreadType::class, $thread);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $threadRepository->save($thread, true);

            return $this->redirectToRoute('app_thread_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('thread/edit.html.twig', [
            'thread' => $thread,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_thread_delete', methods: ['POST'])]
    public function delete(Request $request, Thread $thread, ThreadRepository $threadRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $thread->getId(), $request->request->get('_token'))) {
            $threadRepository->remove($thread, true);
        }

        return $this->redirectToRoute('app_thread_index', [], Response::HTTP_SEE_OTHER);
    }
}
