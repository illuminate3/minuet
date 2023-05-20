<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use App\Repository\ThreadRepository;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/message')]
class MessageController extends BaseController
{
    #[Route('/', name: 'app_message_index', methods: ['GET'])]
    public function index(
        Request $request,
        MessageRepository $messageRepository
    ): Response {
        return $this->render('message/index.html.twig', [
            'title' => 'title.message',
            'site' => $this->site($request),
            'messages' => $messageRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_message_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MessageRepository $messageRepository, ThreadRepository $threadRepository, $id): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $thread = $threadRepository->findOneBy(['id' => $id]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $thread = $threadRepository->findOneBy(['id' => $id]);

            if(!isset($thread) && empty($thread))
            {
                $this->addFlash('danger', 'message.not_found');
            }
            else
            {
                $message->setUpdatedBy($user);
                $message->setUser($user);
                $message->setContent($message->getContent());
                $message->setThread($thread);
                $message->setCreatedAt(new DateTimeImmutable('now'));
                $messageRepository->save($message, true);
                $this->addFlash('success', 'message.created');
            }
            return $this->redirectToRoute('app_message_show_thread', ['id' =>  $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message/new.html.twig', [
            'title' => 'title.new.message',
            'messages' => $message,
            'thread' => $thread,
            'action_cancel_url' => 'app_message_show_thread',
            'site' => $this->site($request),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/thread/{id}', name: 'app_message_show_thread', methods: ['GET'])]
    public function showMessages(
        $id,
        Request $request,
        MessageRepository $messageRepository,
        ThreadRepository $threadRepository
    ): Response {

        $messages = $messageRepository->findBy(['thread' => $id]);
        $thread = $threadRepository->findOneBy(['id' => $id]);

        return $this->render('message/index.html.twig', [
            'title' => 'title.message',
            'new_url' => 'app_message_new',
            'site' => $this->site($request),
            'action_cancel_main_url' => 'app_thread_index',
            'messages' => $messages,
            'thread' => $thread,
        ]);
    }

    #[Route('/{id}', name: 'app_message_show', methods: ['GET'])]
    public function show(
        Request $request,
        Message $message,
    ): Response {
        return $this->render('message/show.html.twig', [
            'title' => 'title.dashboard',
            'site' => $this->site($request),
            'action_cancel_url' => 'app_message_show_thread',
            'messages' => $message,
        ]);
    }

    #[Route('/thread/{thread_id}/message/{id}/edit', name: 'app_message_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Message $message, MessageRepository $messageRepository, ThreadRepository $threadRepository, $thread_id, $id): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        $messages = $messageRepository->findBy(['id' => $id]);
        $thread = $threadRepository->findOneBy(['id' => $thread_id]);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $thread = $threadRepository->findOneBy(['id' => $thread_id]);
            if(empty($thread))
            {
                $this->addFlash('danger', 'message.not_found');
                return $this->redirectToRoute('app_message_show_thread', ['id' =>  (int) $thread_id], Response::HTTP_SEE_OTHER);
            }

            $message->setUpdatedBy($user);
            $message->setUser($user);
            $message->setContent($message->getContent());
            $message->setThread($thread);
            $message->setCreatedAt(new DateTimeImmutable('now'));
            $messageRepository->save($message, true);
            $this->addFlash('success', 'message.updated');

            return $this->redirectToRoute('app_message_show_thread', ['id' => (int) $thread_id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message/edit.html.twig', [
            'title' => 'title.edit.message',
            'messages' => $messages,
            'thread' => $thread,
            'action_cancel_url' => 'app_message_show_thread',
            'action_delete_url' => true,
            'site' => $this->site($request),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_message_delete', methods: ['POST'])]
    public function delete(Request $request, Message $message, MessageRepository $messageRepository): JsonResponse
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('csrf_token'))) {
            $messageRepository->remove($message, true);
            // $this->addFlash('success', 'message.deleted');
        }
        return new JsonResponse(['status' => 'success', 'data' => $request->request->get('thread_id')]);

        // return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
    }
}
