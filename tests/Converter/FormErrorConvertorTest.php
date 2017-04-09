<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCoreTest\Converter;

use Lamsa\ApiCore\Converter\FormErrorConverter;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

/**
 * Class FormErrorConverterTest
 *
 * @package Lamsa\ApiCoreTest\Converter
 */
class FormErrorConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers FormErrorConverter::toArray()
     */
    public function testToArray()
    {
        $expectedErrorArray = [
            'level1' => [
                'message'  => 'missing test',
                'children' => [
                    'level2' => [
                        'message' => 'missing test level 2',
                    ],
                ],
            ],
        ];


        $formErrorConverter = new FormErrorConverter();

        $formChildLevel2Mock = $this->getMockBuilder(FormInterface::class)
            ->getMock();
        $formChildLevel2Mock
            ->expects($this->once())
            ->method('getErrors')
            ->willReturn([
                'anything' => new FormError('missing test level 2'),
            ]);

        $formChildMock = $this->getMockBuilder(FormInterface::class)
            ->getMock();
        $formChildMock
            ->expects($this->once())
            ->method('getErrors')
            ->willReturn([
                'x' => new FormError('missing test'),
            ]);

        $formChildMock
            ->expects($this->exactly(2))
            ->method('all')
            ->willReturn([
                'level2' => $formChildLevel2Mock,
            ]);

        $form = $this->getMockBuilder(FormInterface::class)
            ->getMock();
        $form
            ->expects($this->once())
            ->method('all')
            ->willReturn([
                'level1' => $formChildMock,
            ]);
        $this->assertEquals($expectedErrorArray, $formErrorConverter->toArray($form));
    }

}