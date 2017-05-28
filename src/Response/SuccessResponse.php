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
 * Class SuccessResponse
 *
 * @package DebitNoteBundle\Response
 */
class SuccessResponse extends AbstractResponse
{
    /**
     * @var object
     */
    private $data;

    /**
     * @var array<string,string>
     */
    private $links;

    /**
     * SuccessResponse constructor.
     *
     * @param object $data
     * @param int    $statusCode
     */
    public function __construct($data, $statusCode)
    {
        $this->links = [];
        $this->data  = $data;
        parent::__construct($statusCode);
    }

    /**
     * @return View
     */
    public function getView()
    {
        return new View($this, $this->code);
    }

    /**
     * @param string $name
     * @param string $link
     *
     * @return $this
     */
    public function addLink($name, $link)
    {
        $this->links[$name] = $link;

        return $this;
    }

}
