<?php

namespace App\Presentation\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getException();
        $response = new JsonResponse([
            'error' => $exception->getMessage()],
            $exception->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR
        );

        $this->logger->error($exception);
        $event->setResponse($response);
    }
}
