<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Processor;

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
        $form = $this->formFactory->create(get_class($form), $entity);
        $form->submit($data);

        if (true === $form->isSubmitted() && true === $form->isValid()) {
            return $entity;
        }

        throw new InvalidFormException($form);
    }

}
