<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Subscriber;

use Exception;
use Lamsa\ApiCore\Converter\FormErrorConverterInterface;
use Lamsa\ApiCore\Exception\InvalidFormException;
use Lamsa\ApiCore\Exception\InvalidJsonDataException;
use Lamsa\ApiCore\Exception\PlaceHolderExceptionInterface;
use Lamsa\ApiCore\Response\ErrorResponse;
use Lamsa\ApiCore\ResponseEntity\ErrorResponseEntity;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

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
     *
     * @param ViewHandlerInterface        $viewHandler
     * @param FormErrorConverterInterface $formErrorConverter
     * @param TranslatorInterface         $translator
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
     * @param ExceptionEvent $event
     */
    public function onApiException(ExceptionEvent $event)
    {
        /** @var Exception $exception */
        $exception = $event->getThrowable();

        if (false === ($exception instanceof HttpExceptionInterface)) {
            return;
        }
        if ($exception instanceof PlaceHolderExceptionInterface) {
            $exceptionMessage = $this->translator->trans(
                $exception->getMessage(),
                $exception->getPlaceHolders(),null,$event->getRequest()->getLocale()
            );
        }
        else {
            $exceptionMessage = $this->translator->trans($exception->getMessage());
        }
        switch (true) {
            case $exception instanceof InvalidFormException:
                $formErrors          = $this->formErrorConverter->toArray($exception->getForm());
                $formErrors          = $this->translateArrayErrors($formErrors);
                $errorResponseEntity = new ErrorResponseEntity(
                    $exceptionMessage,
                    $formErrors);
                break;
            case $exception instanceof InvalidJsonDataException:
                $errors              = $this->formErrorConverter->constraintsToArray($exception->getConstraintViolationList());
                $errors              = $this->translateArrayErrors($errors);
                $errorResponseEntity = new ErrorResponseEntity(
                    $exceptionMessage,
                    $errors);
                break;
            default:
                $errorResponseEntity = new ErrorResponseEntity($exceptionMessage);
        }

        $response = new ErrorResponse($errorResponseEntity, $exception->getStatusCode());

        $event->setResponse($this->viewHandler->handle($response->getView()));
    }

    /**
     * @param array $errors
     *
     * @return array
     */
    private function translateArrayErrors(array $errors): array
    {
        $translatedErrors = [];
        foreach ($errors as $message) {
            $translatedErrors[] = $this->translator->trans($message);
        }

        return $translatedErrors;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onApiException',
        ];
    }
}
