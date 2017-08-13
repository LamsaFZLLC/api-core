<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\ResponseEntity;

use Lamsa\ApiCore\Response\ErrorResponseInterface;

/**
 * Class ErrorResponseEntity
 *
 * @package Lamsa\ApiCore\ResponseEntity
 */
class ErrorResponseEntity implements ErrorResponseInterface
{
    /**
     * @var string
     */
    private $message = '';

    /**
     * @var array
     */
    private $errors = [];

    /**
     * ErrorResponseEntity constructor.
     *
     * @param string $message
     * @param array  $errors
     */
    public function __construct(string $message, array $errors = [])
    {
        $this->message = $message;
        $this->errors  = $errors;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return ErrorResponseInterface
     */
    public function setMessage(string $message): ErrorResponseInterface
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     *
     * @return ErrorResponseInterface
     */
    public function setErrors(array $errors): ErrorResponseInterface
    {
        $this->errors = $errors;
    }

}
