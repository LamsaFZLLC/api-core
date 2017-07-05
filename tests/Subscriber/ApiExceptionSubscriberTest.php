<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Tests\Lamsa\ApiCore\Subscriber;

use FOS\RestBundle\View\ViewHandlerInterface;
use Lamsa\ApiCore\Converter\FormErrorConverter;
use Lamsa\ApiCore\Converter\FormErrorConverterInterface;
use Lamsa\ApiCore\Exception\InvalidFormException;
use Lamsa\ApiCore\Subscriber\ApiExceptionSubscriber;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormConfigInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class ApiExceptionSubscriberTest
 *
 * @package Tests\Lamsa\ApiCore\Subscriber
 */
class ApiExceptionSubscriberTest extends TestCase
{
    /**
     * @var ViewHandlerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $viewHandlerMock;

    /**
     * @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $loggerMock;

    /**
     * @var HttpKernelInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $httpKernelMock;

    /**
     * @var FormErrorConverterInterface
     */
    private $formErrorConverter;

    /**
     * @var FormConfigInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $formConfigMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->viewHandlerMock = $this->getMockBuilder(ViewHandlerInterface::class)
            ->getMock();

        $this->loggerMock     = $this->getMockBuilder(LoggerInterface::class)
            ->getMock();
        $this->httpKernelMock = $this->getMockBuilder(HttpKernelInterface::class)
            ->getMock();

        $this->formErrorConverter = new FormErrorConverter();

        $this->formConfigMock = $this->getMockBuilder(FormConfigInterface::class)
            ->getMock();
    }

    /**
     * @covers ApiExceptionSubscriber::onApiException()
     */
    public function testOnApiException()
    {
        $response = new Response('sss');

        $this->viewHandlerMock
            ->expects($this->once())
            ->method('handle')
            ->willReturn($response);

        $ApiExceptionSubscriber = new ApiExceptionSubscriber($this->viewHandlerMock, $this->loggerMock, $this->formErrorConverter);
        $exception              = new  InvalidFormException('test', new Form($this->formConfigMock));

        $event = new GetResponseForExceptionEvent($this->httpKernelMock, new Request(), 'json', $exception);
        $ApiExceptionSubscriber->onApiException($event);

        $this->assertEquals($exception, $event->getException());
        $this->assertEquals($response, $event->getResponse());
    }

    /**
     * @covers ApiExceptionSubscriber::onApiException()
     */
    public function testOnApiExceptionWithoutHttpException()
    {
        $ApiExceptionSubscriber = new ApiExceptionSubscriber($this->viewHandlerMock, $this->loggerMock, $this->formErrorConverter);
        $exception              = new  \Exception('test');

        $event = new GetResponseForExceptionEvent($this->httpKernelMock, new Request(), 'json', $exception);
        $ApiExceptionSubscriber->onApiException($event);

        $this->assertEquals($exception, $event->getException());
        $this->assertNull($event->getResponse());
    }

}