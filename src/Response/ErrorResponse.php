<?php
/**
 * api-core
 *
 *  @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 *  @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Response;

/**
 * Class ErrorResponse
 *
 * @package DebitNoteBundle\Response
 */
class ErrorResponse extends AbstractResponse
{
    /**
     * @var object
     */
    private $error;

    /**
     * ErrorResponse constructor.
     *
     * @param object $error
     * @param int    $statusCode
     */
    public function __construct($error, $statusCode)
    {
        $this->error = $error;
        parent::__construct($statusCode);
    }

}
