<?php
/**
 * api-core
 *
 *  @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 *  @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class InvalidFormException
 *
 * @package CoreApi\Exception
 */
class InvalidFormException extends \Exception implements HttpExceptionInterface
{
    /**
     * @var array
     */
    private $errors;

    public function __construct($message, array $errors, $code = 422, \Exception $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Returns the status code.
     *
     * @return int An HTTP response status code
     */
    public function getStatusCode()
    {
        $this->getCode();
    }

    /**
     * Returns response headers.
     *
     * @return array Response headers
     */
    public function getHeaders()
    {
        return [];
    }
}