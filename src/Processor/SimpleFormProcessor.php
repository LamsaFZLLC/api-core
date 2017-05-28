<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Processor;

use Lamsa\ApiCore\Converter\FormErrorConverter;
use Lamsa\ApiCore\Converter\FormErrorConverterInterface;
use Lamsa\ApiCore\Exception\InvalidFormException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class SimpleFormProcessor
 *
 * @package Lamsa\ApiCore\Processor
 */
class SimpleFormProcessor
{
    /**
     * @var string
     */
    const MSG_INVALID_SUBMITTED_DATA = 'Invalid submitted data';

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * SimpleFormProcessor constructor.
     *
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param Object        $entity
     * @param FormInterface $form
     * @param array         $data
     *
     * @return Object
     * @throws InvalidFormException
     */
    public function execute($entity, FormInterface $form, array $data)
    {
        $form = $this->formFactory->create($form, $entity);
        $form->submit($data);

        if ($form->isValid()) {
            return $entity;
        }

        throw new InvalidFormException(static::MSG_INVALID_SUBMITTED_DATA, $form);
    }

}