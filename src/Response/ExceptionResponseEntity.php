<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Response;

/**
 * Class ExceptionResponseEntity
 *
 * @package DebitNoteBundle\ResponseEntity
 */
class ExceptionResponseEntity
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $data;

    /**
     * ExceptionResponseEntity constructor.
     *
     * @param string     $message
     * @param array|null $data
     */
    public function __construct(string $message, array $data = null)
    {
        $this->message = $message;
        $this->data    = $data;
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
     * @return $this
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

}
