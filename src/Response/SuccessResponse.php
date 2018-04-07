<?php
/**
 * api-core
 *
 *  @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 *  @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Response;

use ArrayIterator;
use Doctrine\Common\Collections\Collection;
use FOS\RestBundle\View\View;
use Lamsa\ApiCore\Exception\InvalidArgumentException;

/**
 * Class SuccessResponse
 *
 * @package Lamsa\ApiCore\Response
 */
class SuccessResponse extends AbstractResponse
{
    /**
     * @var object|ArrayIterator|Collection|string
     */
    private $data;

    /**
     * @var string
     */
    private $message;

    /**
     * SuccessResponse constructor.
     *
     * @param object|array|string $data
     * @param int    $code
     *
     * @throws InvalidArgumentException
     */
    public function __construct($data, int $code)
    {
        switch (true) {
            case true === is_object($data) || true === is_array($data):
                $this->data  = $data;
                break;
            case true === is_string($data):
                $this->message= $data;
                break;
            default:
                throw new InvalidArgumentException('$data', 'object, array or string');
        }

        parent::__construct($code);
    }

    /**
     * @return View
     */
    public function getView(): View
    {
        $viewObject = clone $this;

        switch (true) {
            case $viewObject->data instanceof ArrayIterator:
                $viewObject->data = $viewObject->data->getArrayCopy();
                break;
            case $viewObject->data instanceof Collection:
                $viewObject->data = $viewObject->data->toArray();
                break;
        }

        return new View($viewObject, $this->getCode());
    }
}