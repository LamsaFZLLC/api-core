<?php
/**
 * api-core
 *
 *  @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 *  @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Subscriber;

use Bugsnag\Client;
use Bugsnag\Report;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class BugsnagExceptionSubscriber
 *
 * @package LegalOne\CounselBundle\EventListener
 */
class BugsnagExceptionSubscriber implements EventSubscriberInterface
{
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
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $this->client->notifyException($exception);
    }

    /**
     * @param ConsoleExceptionEvent $event
     */
    public function onConsoleException(ConsoleExceptionEvent $event)
    {
        $exception = $event->getException();

        $meta = [
            'command' => [
                'name'   => $event->getCommand()->getName(),
                'status' => $event->getExitCode(),
            ],
        ];

        $this->client->notifyException($exception, function (Report $report) use ($meta) {
            $report->setMetaData($meta);
        });
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                'onKernelException',
                100,
            ],
            ConsoleEvents::EXCEPTION => [
                'onConsoleException',
                100,
            ],
        ];
    }

}
