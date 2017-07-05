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
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class BugsnagExceptionSubscriberTest
 *
 * @package Tests\Lamsa\ApiCore\Subscriber
 */
class BugsnagExceptionSubscriberTest extends TestCase
{
    /**
     * @var Client|\PHPUnit_Framework_MockObject_MockObject
     */
    private $clientMock;

    /**
     * @var GetResponseForExceptionEvent|\PHPUnit_Framework_MockObject_MockObject
     */
    private $getResponseForExceptionEventMock;

    /**
     * @var InputInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $inputMock;

    /**
     * @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $outputMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->getResponseForExceptionEventMock = $this->getMockBuilder(GetResponseForExceptionEvent::class)
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

        /** @var GetResponseForExceptionEvent|\PHPUnit_Framework_MockObject_MockObject $event */
        $event = $this->getMockBuilder(GetResponseForExceptionEvent::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event
            ->method('getException')
            ->willReturn(null);

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