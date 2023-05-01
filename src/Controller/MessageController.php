<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
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
            'title' => 'title.dashboard',
            'site' => $this->site($request),
            'messages' => $messageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_message_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MessageRepository $messageRepository): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageRepository->save($message, true);

            return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message/new.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    #[Route('/thread/{id}', name: 'app_message_show_thread', methods: ['GET'])]
    public function showMessages(
        $id,
        Request $request,
        MessageRepository $messageRepository,
    ): Response {

        $messages = $messageRepository->findBy(['thread' => $id]);

        return $this->render('message/index.html.twig', [
            'title' => 'title.dashboard',
            'site' => $this->site($request),
            'messages' => $messages,
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
            'message' => $message,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_message_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Message $message, MessageRepository $messageRepository): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageRepository->save($message, true);

            return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message/edit.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_message_delete', methods: ['POST'])]
    public function delete(Request $request, Message $message, MessageRepository $messageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $messageRepository->remove($message, true);
        }

        return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
    }
}
