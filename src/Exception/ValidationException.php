<?php
/**
 * api-core
 *
 *  @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 *  @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Exception;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ValidationException
 *
 * @package Lamsa\ApiCore\Exception
 */
class ValidationException extends Exception implements HttpExceptionInterface
{
    /**
     * @var string
     */
    const MESSAGE = 'error.validation';

    /**
     * @var ConstraintViolationListInterface
     */
    private $constraintViolationList;

    /**
     * ValidateException constructor.
     *
     * @param ConstraintViolationListInterface $constraintViolationList
     */
    public function __construct(ConstraintViolationListInterface $constraintViolationList)
    {
        parent::__construct(static::MESSAGE);
        $this->constraintViolationList = $constraintViolationList;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode()
    {
        return Response::HTTP_BAD_REQUEST;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return [];
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getConstraintViolationList(): ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}
