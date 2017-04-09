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
 * @package DebitNoteBundle\Response
 */
abstract class AbstractResponse
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * AbstractResponse constructor.
     *
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return View
     */
    public function getView()
    {
        return new View($this, $this->statusCode);
    }

    /**
     * @param string $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

}
