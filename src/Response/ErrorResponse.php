<?php
/**
 * api-core
 *
 * @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 * @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Response;

use Lamsa\ApiCore\Response\AbstractResponse;
use Lamsa\ApiCore\Response\ErrorResponseInterface;


/**
 * Class ErrorResponse
 *
 * @package Lamsa\ApiCore\Response
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
     * @param ErrorResponseInterface $error
     * @param int                    $code
     */
    public function __construct(ErrorResponseInterface $error, int $code)
    {
        $this->error = $error;
        parent::__construct($code);
    }

}
