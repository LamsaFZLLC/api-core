<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Subscriber;

use Bugsnag\Client;
use Bugsnag\Report;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class BugsnagExceptionSubscriber
 *
 * @package LegalOne\CounselBundle\EventListener
 */
class BugsnagExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var string
     */
    const EMPTY_COMMAND_NAME = 'No command was specified';

    /**
     * @var Client
     */
    private $client;

    /**
     * BugsnagExceptionHandler constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        //skip all exceptions that are thrown by us(of type HttpExceptionInterface)
        if(true === ($exception instanceof HttpExceptionInterface)) {
            return ;
        }

        $this->client->notifyException($exception);
    }

    /**
     * @param ConsoleErrorEvent $event
     */
    public function onConsoleError(ConsoleErrorEvent $event): void
    {
        $error = $event->getError();

        $commandName = null === $event->getCommand() ? static::EMPTY_COMMAND_NAME : $event->getCommand()->getName();

        $meta = [
            'command' => [
                'name'   => $commandName,
                'status' => $event->getExitCode(),
            ],
        ];

        $this->client->notifyException($error, function (Report $report) use ($meta) {
            $report->setMetaData($meta);
        });
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION  => [
                'onKernelException',
                100,
            ],
            ConsoleEvents::ERROR => [
                'onConsoleError',
                100,
            ],
        ];
    }

}
