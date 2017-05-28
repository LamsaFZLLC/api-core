<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Subscriber;

use Lamsa\ApiCore\Converter\FormErrorConverterInterface;
use Lamsa\ApiCore\Exception\InvalidFormException;
use Lamsa\ApiCore\Response\ErrorResponse;
use Lamsa\ApiCore\Response\ExceptionResponseEntity;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use FOS\RestBundle\View\ViewHandlerInterface;

/**
 * Class ApiExceptionSubscriber
 *
 * @package Lamsa\ApiCore\Subscriber
 */
class ApiExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var ViewHandlerInterface
     */
    private $viewHandler;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var FormErrorConverterInterface
     */
    private $formErrorConverter;

    /**
     * ApiExceptionSubscriber constructor.
     *
     * @param ViewHandlerInterface        $viewHandler
     * @param LoggerInterface             $logger
     * @param FormErrorConverterInterface $formErrorConverter
     */
    public function __construct(ViewHandlerInterface $viewHandler, LoggerInterface $logger, FormErrorConverterInterface $formErrorConverter)
    {
        $this->viewHandler        = $viewHandler;
        $this->logger             = $logger;
        $this->formErrorConverter = $formErrorConverter;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onApiException(GetResponseForExceptionEvent $event)
    {
        /** @var Exception $exception */
        $exception = $event->getException();

        if (!($exception instanceof HttpExceptionInterface)) {
            return;
        }

        $this->logger->error($exception->getMessage(), [
            'exception' => $exception,
        ]);

        switch (true) {
            case $exception instanceof InvalidFormException:
                $exceptionResponseEntity = new ExceptionResponseEntity(
                    $exception->getMessage(),
                    $this->formErrorConverter->toArray($exception->getForm())
                );
                break;
            default:
                $exceptionResponseEntity = new ExceptionResponseEntity(
                    $exception->getMessage()
                );
        }

        $response = new ErrorResponse($exceptionResponseEntity, $exception->getStatusCode());
        $event->setResponse($this->viewHandler->handle($response->getView()));
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onApiException',
        ];
    }

}