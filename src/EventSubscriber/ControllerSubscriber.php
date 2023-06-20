<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Controller\API\AjaxController;
use App\Controller\Auth\AuthController;
use App\Middleware\ThrottleRequests;
use App\Middleware\VerifyCsrfToken;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

use function is_array;

final class ControllerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly VerifyCsrfToken $verifyCsrfToken,
        private readonly ThrottleRequests $throttleRequests
    ) {
    }


    /**
     * @param  ControllerEvent  $event
     *
     * @return void
     */
    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();
        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof AjaxController) {
            $this->verifyCsrfToken->handle($event->getRequest());
        } elseif ($controller instanceof AuthController) {
            $this->throttleRequests->handle($event->getRequest());
        }
    }


    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

}
