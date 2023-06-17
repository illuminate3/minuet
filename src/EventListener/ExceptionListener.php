<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Security\Csrf\Exception\TokenNotFoundException;

final class ExceptionListener
{

    /**
     * @param  ExceptionEvent  $event
     *
     * @return void
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof TokenNotFoundException) {
            $customResponse = new JsonResponse([
                'status' => 'fail',
                'message' => $exception->getMessage(),
            ], 419);
            $event->setResponse($customResponse);
        }
    }

}
