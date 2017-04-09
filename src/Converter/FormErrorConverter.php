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
 * Class FormErrorConverter
 *
 * @package Lamsa\ApiCore\Converter
 */
class FormErrorConverter
{
    /**
     * @param FormInterface $form
     *
     * @return array
     */
    public function toArray(FormInterface $form)
    {
        $errors = [];
        foreach ($form->all() as $key => $child) {

            foreach ($child->getErrors() as $error) {
                $errors[$key]['message'] = $error->getMessage();
            }

            if (count($child->all()) > 0) {
                $errors[$key]['children'] = $this->toArray($child);
            }
        }

        return $errors;
    }

}