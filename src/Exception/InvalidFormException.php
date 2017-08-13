<?php
/**
 * api-core
 *
 *  @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 *  @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Exception;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class InvalidFormException
 *
 * @package CoreApi\Exception
 */
class InvalidFormException extends \Exception implements HttpExceptionInterface
{
    /**
     * @var string
     */
    const MESSAGE = 'error.validation';

    /**
     * @var FormInterface
     */
    private $form;

    /**
     * InvalidFormException constructor.
     *
     * @param FormInterface   $form
     * @param string          $message
     * @param \Throwable|null $previous
     * @param int             $code
     */
    public function __construct(FormInterface $form, string $message = self::MESSAGE,  \Throwable $previous = null, int $code = Response::HTTP_BAD_REQUEST)
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
