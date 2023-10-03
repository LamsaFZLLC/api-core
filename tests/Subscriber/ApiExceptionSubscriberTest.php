<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Tests\Lamsa\ApiCore\Subscriber;

use FOS\RestBundle\View\ViewHandlerInterface;
use PHPUnit\Framework\MockObject\MockObject;
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
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class ApiExceptionSubscriberTest
 *
 * @package Tests\Lamsa\ApiCore\Subscriber
 */
class ApiExceptionSubscriberTest extends TestCase
{
    /**
     * @var ViewHandlerInterface|MockObject
     */
    private $viewHandlerMock;

    /**
     * @var LoggerInterface|MockObject
     */
    private $loggerMock;

    /**
     * @var HttpKernelInterface|MockObject
     */
    private $httpKernelMock;

    /**
     * @var FormErrorConverterInterface
     */
    private $formErrorConverter;

    /**
     * @var FormConfigInterface|MockObject
     */
    private $formConfigMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
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
        $exception              = new  InvalidFormException(new Form($this->formConfigMock));

        $event = new ExceptionEvent($this->httpKernelMock, new Request(), HttpKernelInterface::MAIN_REQUEST, $exception);
        $ApiExceptionSubscriber->onApiException($event);

        $this->assertEquals($exception, $event->getThrowable());
        $this->assertEquals($response, $event->getResponse());
    }

    /**
     * @covers ApiExceptionSubscriber::onApiException()
     */
    public function testOnApiExceptionWithoutHttpException()
    {
        $ApiExceptionSubscriber = new ApiExceptionSubscriber($this->viewHandlerMock, $this->loggerMock, $this->formErrorConverter);
        $exception              = new  \Exception('test');

        $event = new ExceptionEvent($this->httpKernelMock, new Request(), HttpKernelInterface::MAIN_REQUEST, $exception);
        $ApiExceptionSubscriber->onApiException($event);

        $this->assertEquals($exception, $event->getThrowable());
        $this->assertNull($event->getResponse());
    }

}
