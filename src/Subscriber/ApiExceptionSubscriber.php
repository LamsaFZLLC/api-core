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
use Lamsa\ApiCore\ResponseEntity\ErrorResponseEntity;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\Translation\TranslatorInterface;

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
     * @var FormErrorConverterInterface
     */
    private $formErrorConverter;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * ApiExceptionSubscriber constructor.
     * @param ViewHandlerInterface $viewHandler
     * @param FormErrorConverterInterface $formErrorConverter
     * @param TranslatorInterface $translator
     */
    public function __construct(ViewHandlerInterface $viewHandler,
                                FormErrorConverterInterface $formErrorConverter,
                                TranslatorInterface $translator)
    {
        $this->viewHandler        = $viewHandler;
        $this->formErrorConverter = $formErrorConverter;
        $this->translator         = $translator;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onApiException(GetResponseForExceptionEvent $event)
    {
        /** @var \Exception $exception */
        $exception = $event->getException();

        if (false === ($exception instanceof HttpExceptionInterface)) {
            return;
        }

        $this->translator->setLocale($event->getRequest()->getLocale());
        $exceptionMessage = $this->translator->trans($exception->getMessage());
        switch (true) {
            case $exception instanceof InvalidFormException:
                $formErrors = $this->formErrorConverter->toArray($exception->getForm());
                $formErrors = $this->translateArrayErrors($formErrors);
                $errorResponseEntity = new ErrorResponseEntity(
                    $exceptionMessage,
                    $formErrors);
                break;
            default:
                $errorResponseEntity = new ErrorResponseEntity($exceptionMessage);
        }

        $response = new ErrorResponse($errorResponseEntity, $exception->getStatusCode());

        $event->setResponse($this->viewHandler->handle($response->getView()));
    }

    /**
     * @param array $errors
     * @return array
     */
    private function translateArrayErrors(array $errors) {
        $translatedErrors = [];
        foreach ($errors as $message) {
            $translatedErrors[] = $this->translator->trans($message);
        }
        return $translatedErrors;
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
