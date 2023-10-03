<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Tests\Lamsa\ApiCore\Processor;

use Lamsa\ApiCore\Exception\InvalidFormException;
use Lamsa\ApiCore\Processor\SimpleFormProcessor;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Lamsa\ApiCore\Processor\Fixture\EntityFixture;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class SimpleFormProcessorTest
 *
 * @package Tests\Lamsa\ApiCore\Processor
 */
class SimpleFormProcessorTest extends TestCase
{
    /**
     * @var FormInterface|MockObject
     */
    private $formMock;

    /**
     * @var FormFactoryInterface|MockObject
     */
    private $formFactoryMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->formMock        = $this->getMockBuilder(FormInterface::class)
            ->getMock();
        $this->formFactoryMock = $this->getMockBuilder(FormFactoryInterface::class)
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

        $this->formMock
            ->expects($this->once())
            ->method('isSubmitted')
            ->willReturn(true);

        $this->formFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->formMock);

        $simpleFormProcessor = new SimpleFormProcessor($this->formFactoryMock);

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

        $this->formMock
            ->expects($this->once())
            ->method('isValid')
            ->willReturn(false);

        $this->formMock
            ->expects($this->once())
            ->method('isSubmitted')
            ->willReturn(true);

        $this->formFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->formMock);

        $simpleFormProcessor = new SimpleFormProcessor($this->formFactoryMock);
        $entityFixture       = new EntityFixture();
        $entityFixture->setName('test');

        $this->expectException(InvalidFormException::class);

        /** @var object $entityFixture */
        $simpleFormProcessor->execute($entityFixture, $this->formMock, $expectedData);
    }

}
