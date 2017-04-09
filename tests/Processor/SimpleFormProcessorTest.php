<?php
/**
 * api-core
 *
 *  @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 *  @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCoreTest\Processor;

use Lamsa\ApiCore\Converter\FormErrorConverter;
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
     * @covers SimpleFormProcessor::execute()
     */
    public function testExecute(){
        $expectedData = [
            'name' => 'test'
        ];

        $formMock = $this->getMockBuilder(FormInterface::class)
            ->getMock();
        $formMock
            ->expects($this->once())
            ->method('isValid')
            ->willReturn(true);

        $formFactoryMock = $this->getMockBuilder(FormFactoryInterface::class)
            ->getMock();
        $formFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($formMock);

        $formErrorConverterMock = $this->getMockBuilder(FormErrorConverter::class)
            ->getMock();

        $simpleFormProcessor = new SimpleFormProcessor($formFactoryMock , $formErrorConverterMock);
        $entityFixture = new EntityFixture();
        $entityFixture->setName('test');

        $this->assertEquals($entityFixture, $simpleFormProcessor->execute($entityFixture, $formMock, $expectedData));
    }

    /**
     * @covers SimpleFormProcessor::execute()
     */
    public function testExecuteWithInvalidForm(){
        $expectedData = [
            'name' => 'test'
        ];

        $expectedError = [
            'name' => 'should be atleast 6 characters'
        ];

        $formMock = $this->getMockBuilder(FormInterface::class)
            ->getMock();
        $formMock
            ->expects($this->once())
            ->method('isValid')
            ->willReturn(false);

        $formFactoryMock = $this->getMockBuilder(FormFactoryInterface::class)
            ->getMock();
        $formFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($formMock);
        $formErrorConverterMock = $this->getMockBuilder(FormErrorConverter::class)
            ->getMock();
        $formErrorConverterMock
            ->method('toArray')
            ->willReturn($expectedError);
        $simpleFormProcessor = new SimpleFormProcessor($formFactoryMock, $formErrorConverterMock);
        $entityFixture = new EntityFixture();
        $entityFixture->setName('test');

        $this->expectException(InvalidFormException::class);
        $simpleFormProcessor->execute($entityFixture, $formMock, $expectedData);
    }

}