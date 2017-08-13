<?php
/**
 * api-core
 *
 *  @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 *  @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Converter;


use Symfony\Component\Form\FormInterface;

/**
 * Interface FormErrorConverterInterface
 *
 * @package Lamsa\ApiCore\Converter
 */
interface FormErrorConverterInterface
{
    /**
     * @param FormInterface $form
     *
     * @return array
     */
    public function toArray(FormInterface $form);

}
