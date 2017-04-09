<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCoreTest\Subscriber;

use FOS\RestBundle\View\ViewHandlerInterface;
use Lamsa\ApiCore\Exception\InvalidFormException;
use Lamsa\ApiCore\Subscriber\ApiExceptionSubscriber;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class ApiExceptionSubscriberTest
 *
 * @package Lamsa\ApiCoreTest\Subscriber
 */
class ApiExceptionSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ApiExceptionSubscriber::onApiException()
     */
    public function testOnApiException()
    {
        $response               = new Response('sss');
        $viewHandlerMock        = $this->getMockBuilder(ViewHandlerInterface::class)
            ->getMock();
        $viewHandlerMock
            ->expects($this->once())
            ->method('handle')
            ->willReturn($response);
        $loggerMock             = $this->getMockBuilder(LoggerInterface::class)
            ->getMock();
        $httpKernel             = $this->getMockBuilder(HttpKernelInterface::class)
            ->getMock();
        $ApiExceptionSubscriber = new ApiExceptionSubscriber($viewHandlerMock, $loggerMock);
        $exception              = new  InvalidFormException('koko', []);

        $event = new GetResponseForExceptionEvent($httpKernel, new Request(), 'json', $exception);
        $ApiExceptionSubscriber->onApiException($event);

        $this->assertEquals($exception, $event->getException());
        $this->assertEquals($response, $event->getResponse());
    }

    /**
     * @covers ApiExceptionSubscriber::onApiException()
     */
    public function testOnApiExceptionWithoutHttpException()
    {
        $response               = new Response('sss');
        $viewHandlerMock        = $this->getMockBuilder(ViewHandlerInterface::class)
            ->getMock();
        $loggerMock             = $this->getMockBuilder(LoggerInterface::class)
            ->getMock();
        $httpKernel             = $this->getMockBuilder(HttpKernelInterface::class)
            ->getMock();
        $ApiExceptionSubscriber = new ApiExceptionSubscriber($viewHandlerMock, $loggerMock);
        $exception              = new  \Exception('koko');

        $event = new GetResponseForExceptionEvent($httpKernel, new Request(), 'json', $exception);
        $ApiExceptionSubscriber->onApiException($event);

        $this->assertEquals($exception, $event->getException());
        $this->assertNull($event->getResponse());
    }

}