<?php
/**
 * api-core
 *
 *  @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 *  @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCoreTest\Subscriber;

use Bugsnag\Client;
use Lamsa\ApiCore\Subscriber\BugsnagExceptionSubscriber;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class BugsnagExceptionSubscriberTest
 *
 * @package Tests\AppBundle\EventListener
 */
class BugsnagExceptionSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client|\PHPUnit_Framework_MockObject_MockObject
     */
    private $clientMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
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

        $event = $this->getMockBuilder(GetResponseForExceptionEvent::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event
            ->method('getException')
            ->willReturn(null);

        $bugsnagExceptionHandler->onKernelException($event);
    }

    /**
     * @covers BugsnagExceptionSubscriber::onConsoleException()
     */
    public function testConsoleException()
    {
        $this->clientMock
            ->expects($this->once())
            ->method('notifyException');

        $bugsnagExceptionHandler = new BugsnagExceptionSubscriber($this->clientMock);

        $event = $this->getMockBuilder(ConsoleExceptionEvent::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event
            ->expects($this->once())
            ->method('getCommand')
            ->willReturn(new Command('koko'));

        $event
            ->expects($this->once())
            ->method('getExitCode')
            ->willReturn(123);

        $event
            ->expects($this->once())
            ->method('getException')
            ->willReturn(null);

        $bugsnagExceptionHandler->onConsoleException($event);
    }

}