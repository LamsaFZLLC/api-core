<?php
/**
 * api-core
 *
 *  @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 *  @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Response;

/**
 * Interface ErrorResponseInterface
 *
 * @package Lamsa\ApiCore\ResponseEntity
 */
interface ErrorResponseInterface
{
    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @param string $message
     *
     * @return ErrorResponseInterface
     */
    public function setMessage(string $message): ErrorResponseInterface;

    /**
     * @return array
     */
    public function getErrors(): array;

    /**
     * @param array $errors
     *
     * @return ErrorResponseInterface
     */
    public function setErrors(array $errors): ErrorResponseInterface;

}