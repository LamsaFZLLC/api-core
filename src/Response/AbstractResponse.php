<?php
/**
 * api-core
 *
 *  @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 *  @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Response;

use FOS\RestBundle\View\View;

/**
 * Class AbstractResponse
 *
 * @package Lamsa\ApiCore\Response
 */
abstract class AbstractResponse
{
    /**
     * @var int
     */
    private $code;

    /**
     * AbstractResponse constructor.
     *
     * @param int $code
     */
    public function __construct(int $code)
    {
        $this->code = $code;
    }

    /**
     * @return View
     */
    public function getView(): View
    {
        return new View($this, $this->code);
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     *
     * @return AbstractResponse
     */
    public function setCode(int $code): AbstractResponse
    {
        $this->code = $code;

        return $this;
    }

}
