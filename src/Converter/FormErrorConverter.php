<?php
/**
 * api-core
 *
 *  @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 *  @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Converter;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

/**
 * Class FormErrorConverter
 *
 * @package Lamsa\ApiCore\Converter
 */
class FormErrorConverter implements FormErrorConverterInterface
{
    /**
     * {@inheritdoc}
     */
    public function toArray(FormInterface $form)
    {
        $errors = [];

        foreach ($form->getErrors() as $key => $error) {
            /** @var FormError $error */
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors = array_merge($errors, $this->toArray($child));
            }
        }

        return $errors;
    }

}
