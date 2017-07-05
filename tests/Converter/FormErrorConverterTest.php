<?php
/**
 * api-core
 *
 *  @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 *  @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Tests\Lamsa\ApiCore\Converter;

use Lamsa\ApiCore\Converter\FormErrorConverter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormConfigInterface;
use Symfony\Component\Form\FormError;

/**
 * Class FormErrorConverterTest
 *
 * @package Tests\Lamsa\ApiCore\Converter
 */
class FormErrorConverterTest extends TestCase
{
    /**
     * @var FormConfigInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $formConfigMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->formConfigMock = $this->getMockBuilder(FormConfigInterface::class)
            ->getMock();
    }

    /**
     * @covers FormErrorConverter::toArray()
     */
    public function testToArray()
    {
        $form = new Form($this->formConfigMock);

        $formErrorConverter = new FormErrorConverter();
        $this->assertEmpty($formErrorConverter->toArray($form));
        $this->assertCount(0, $formErrorConverter->toArray($form));
    }

    /**
     * @covers FormErrorConverter::toArray()
     */
    public function testToArrayWithErrors()
    {
        $expectedArray = [
            'this an error',
        ];

        $form = new Form($this->formConfigMock);

        $form->addError(new FormError('this an error'));
        $formErrorConverter = new FormErrorConverter();
        $this->assertEquals($expectedArray, $formErrorConverter->toArray($form));
        $this->assertCount(1, $formErrorConverter->toArray($form));
    }

}