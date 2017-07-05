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
     * @var object|ArrayIterator|Collection
     */
    private $data;

    /**
     * @var array<string,string>
     */
    private $links = [];

    /**
     * SuccessResponse constructor.
     *
     * @param object $data
     * @param int    $code
     *
     * @throws InvalidArgumentException
     */
    public function __construct($data, int $code)
    {
        switch (true) {
            case false === is_object($data):
                throw new InvalidArgumentException('$data', 'object');
        }

        $this->links = [];
        $this->data  = $data;
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

    /**
     * @param string $name
     * @param string $link
     *
     * @return SuccessResponse
     */
    public function addLink(string $name, string $link): SuccessResponse
    {
        $this->links[$name] = $link;

        return $this;
    }

}
