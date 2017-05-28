<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCoreTest\Processor;

use Lamsa\ApiCore\Converter\FormErrorConverterInterface;
use Lamsa\ApiCore\Exception\InvalidFormException;
use Lamsa\ApiCore\Processor\SimpleFormProcessor;
use Lamsa\ApiCoreTest\Processor\Fixture\EntityFixture;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class SimpleFormProcessorTest
 *
 * @package Lamsa\ApiCoreTest\Processor
 */
class SimpleFormProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FormInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $formMock;

    /**
     * @var FormFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $formFactoryMock;

    /**
     * @var FormErrorConverterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $formErrorConverterMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->formMock               = $this->getMockBuilder(FormInterface::class)
            ->getMock();
        $this->formFactoryMock        = $this->getMockBuilder(FormFactoryInterface::class)
            ->getMock();
        $this->formErrorConverterMock = $this->getMockBuilder(FormErrorConverterInterface::class)
            ->getMock();
    }

    /**
     * @covers SimpleFormProcessor::execute()
     */
    public function testExecute()
    {
        $expectedData = [
            'name' => 'test',
        ];

        $this->formMock
            ->expects($this->once())
            ->method('isValid')
            ->willReturn(true);

        $this->formFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->formMock);

        $simpleFormProcessor = new SimpleFormProcessor($this->formFactoryMock, $this->formErrorConverterMock);

        /** @var object $entityFixture */
        $entityFixture = new EntityFixture();
        $entityFixture->setName('test');

        $this->assertEquals($entityFixture, $simpleFormProcessor->execute($entityFixture, $this->formMock, $expectedData));
    }

    /**
     * @covers SimpleFormProcessor::execute()
     */
    public function testExecuteWithInvalidForm()
    {
        $expectedData = [
            'name' => 'test',
        ];

        $expectedError = [
            'name' => 'should be atleast 6 characters',
        ];

        $this->formMock
            ->expects($this->once())
            ->method('isValid')
            ->willReturn(false);

        $this->formFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->formMock);

        $this->formErrorConverterMock
            ->method('toArray')
            ->willReturn($expectedError);
        $simpleFormProcessor = new SimpleFormProcessor($this->formFactoryMock, $this->formErrorConverterMock);
        $entityFixture       = new EntityFixture();
        $entityFixture->setName('test');

        $this->expectException(InvalidFormException::class);

        /** @var object $entityFixture */
        $simpleFormProcessor->execute($entityFixture, $this->formMock, $expectedData);
    }

}