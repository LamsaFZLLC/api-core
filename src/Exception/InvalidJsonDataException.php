<?php
/**
 * api-core - InvalidJsonDataException.php
 *
 * Date: 3/12/20
 * Time: 1:04 PM
 * @author    Abdelhameed Alasbahi <abdkwa92@gmail.com>
 * @copyright Copyright (c) 2020 LamsaWorld (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

/**
 * Class InvalidJsonDataException
 * @package Lamsa\ApiCore\Exception
 */
class InvalidJsonDataException extends \Exception implements HttpExceptionInterface
{
    /**
     * @var string
     */
    const MESSAGE = 'error.validation';

    /**
     * @var ConstraintViolationListInterface $constraintViolationList
     */
    private $constraintViolationList;

    public function __construct(ConstraintViolationListInterface $constraintViolationList,string $message = self::MESSAGE, int $code = Response::HTTP_BAD_REQUEST, Throwable $previous = null)
    {
        $this->constraintViolationList = $constraintViolationList;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getConstraintViolationList()
    {
        return $this->constraintViolationList;
    }

    /**
     * Returns the status code.
     *
     * @return int An HTTP response status code
     */
    public function getStatusCode(): int
    {
        return $this->getCode();
    }

    /**
     * Returns response headers.
     *
     * @return array Response headers
     */
    public function getHeaders(): array
    {
        return [];
    }
}