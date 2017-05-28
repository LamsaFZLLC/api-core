<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Exception;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class InvalidFormException
 *
 * @package CoreApi\Exception
 */
class InvalidFormException extends \Exception implements HttpExceptionInterface
{
    /**
     * @var FormInterface
     */
    private $form;

    public function __construct(string $message, FormInterface $form, int $code = 422, \Exception $previous = null)
    {
        $this->form = $form;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return FormInterface
     */
    public function getForm(): FormInterface
    {
        return $this->form;
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