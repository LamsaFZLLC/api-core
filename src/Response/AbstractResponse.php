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
    protected $code;

    /**
     * AbstractResponse constructor.
     *
     * @param int $code
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * @return View
     */
    public function getView()
    {
        return new View($this, $this->code);
    }

    /**
     * @param string $code
     *
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

}
