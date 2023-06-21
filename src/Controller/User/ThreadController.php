<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use App\Entity\Thread;
use App\Form\Type\ThreadType;
use App\Repository\AccountUserRepository;
use App\Repository\ProductRepository;
use App\Repository\ThreadRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/thread')]
class ThreadController extends BaseController
{

    /**
     * @param  Request                $request
     * @param  Security               $security
     * @param  ProductRepository      $productRepository
     * @param  AccountUserRepository  $accountUserRepository
     * @param  ThreadRepository       $threadRepository
     *
     * @return Response
     */
    #[Route('/', name: 'app_thread_index', methods: ['GET'])]
    public function index(
        Request $request,
        Security $security,
        ProductRepository $productRepository,
        AccountUserRepository $accountUserRepository,
        ThreadRepository $threadRepository,
    ): Response {
        // get the account information the user is registered to
        $user = $security->getUser();
        $threads = $threadRepository->findBy(['user' => $user->getId()]);

//        $account = $accountUserRepository->findOneBy(['user' => $user->getId()]);

        $products = [];

//        if (!empty($account)) {
//            $accountID = $account->getAccount()->getId();
//            $products = $productRepository->findAllThreadsByAccount($accountID);
//
//        }

        return $this->render('user/thread/index.html.twig', [
            'title' => 'title.message',
            'back_url' => 'app_dash',
            'site' => $this->site($request),
            'products' => $products,
            'threads' => $threads,
        ]);
    }

    /**
     * @param  Request           $request
     * @param  ThreadRepository  $threadRepository
     *
     * @return Response
     */
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

        return $this->render('user/thread/new.html.twig', [
            'thread' => $thread,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param  Thread  $thread
     *
     * @return Response
     */
    #[Route('/{id}', name: 'app_thread_show', methods: ['GET'])]
    public function show(Thread $thread): Response
    {
        return $this->render('user/thread/show.html.twig', [
            'thread' => $thread,
        ]);
    }

    /**
     * @param  Request           $request
     * @param  Thread            $thread
     * @param  ThreadRepository  $threadRepository
     *
     * @return Response
     */
    #[Route('/{id}/edit', name: 'app_thread_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Thread $thread, ThreadRepository $threadRepository): Response
    {
        $form = $this->createForm(ThreadType::class, $thread);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $threadRepository->save($thread, true);

            return $this->redirectToRoute('app_thread_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/thread/edit.html.twig', [
            'thread' => $thread,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param  Request           $request
     * @param  Thread            $thread
     * @param  ThreadRepository  $threadRepository
     *
     * @return Response
     */
    #[Route('/{id}', name: 'app_thread_delete', methods: ['POST'])]
    public function delete(Request $request, Thread $thread, ThreadRepository $threadRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $thread->getId(), $request->request->get('_token'))) {
            $threadRepository->remove($thread, true);
        }

        return $this->redirectToRoute('app_thread_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @param  Request           $request
     * @param  ThreadRepository  $threadRepository
     *
     * @return JsonResponse
     */
    #[Route('/{id}/update_pin_status', name: 'is_pin', methods: ['POST'])]
    public function isPin(Request $request, ThreadRepository $threadRepository): JsonResponse
    {
        $id= $request->request->get('id');
        $pinValue= $request->request->get('ispin');

        $threadRepository->updatePinStatus((int)$id, (bool) $pinValue);

        return new JsonResponse(['status' => 'success', 'data' => (bool) $pinValue, 'id' => (int) $id]);
    }

    /**
     * @param  Request           $request
     * @param  ThreadRepository  $threadRepository
     *
     * @return JsonResponse
     */
    #[Route('/{id}/update_close_status', name: 'is_close', methods: ['POST'])]
    public function isClose(Request $request, ThreadRepository $threadRepository): JsonResponse
    {
        $id= $request->request->get('id');
        $closeValue= $request->request->get('ispin');

        $threadRepository->updateCloseStatus((int)$id, (bool) $closeValue);

        return new JsonResponse(['status' => 'success', 'data' => (bool) $closeValue, 'id' => (int) $id]);
    }

}
