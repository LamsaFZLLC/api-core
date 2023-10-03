<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Tests\Lamsa\ApiCore\Subscriber;

use Bugsnag\Client;
use Exception;
use Lamsa\ApiCore\Subscriber\BugsnagExceptionSubscriber;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class BugsnagExceptionSubscriberTest
 *
 * @package Tests\Lamsa\ApiCore\Subscriber
 */
class BugsnagExceptionSubscriberTest extends TestCase
{
    /**
     * @var Client|MockObject
     */
    private $clientMock;

    /**
     * @var InputInterface|MockObject
     */
    private $inputMock;

    /**
     * @var OutputInterface|MockObject
     */
    private $outputMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->inputMock = $this->getMockBuilder(InputInterface::class)
            ->getMock();

        $this->outputMock = $this->getMockBuilder(OutputInterface::class)
            ->getMock();
    }

    /**
     * @covers BugsnagExceptionSubscriber::onKernelException()
     */
    public function testKernelException()
    {
        $this->clientMock
            ->expects($this->once())
            ->method('notifyException');

        $bugsnagExceptionHandler = new BugsnagExceptionSubscriber($this->clientMock);

        /** @var ExceptionEvent|MockObject $event */
        $kernel = $this->createMock(HttpKernelInterface::class); // Mocking the HttpKernelInterface
        $exception = new \Exception(); // Or any other exception/thrown error you want
        $request = new Request();
        $event = new ExceptionEvent($kernel, $request, HttpKernelInterface::MAIN_REQUEST, $exception);

        $bugsnagExceptionHandler->onKernelException($event);
    }

    /**
     * @covers BugsnagExceptionSubscriber::onConsoleError()
     */
    public function testConsoleError()
    {
        $this->clientMock
            ->expects($this->once())
            ->method('notifyException');

        $bugsnagExceptionHandler = new BugsnagExceptionSubscriber($this->clientMock);

        $consoleErrorEvent = new ConsoleErrorEvent($this->inputMock, $this->outputMock, new Exception('message'), null);

        $bugsnagExceptionHandler->onConsoleError($consoleErrorEvent);
    }

}
