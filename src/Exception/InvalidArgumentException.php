<?php
/**
 * api-core
 *
 *  @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 *  @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Exception;

/**
 * Class InvalidArgumentException
 *
 * @package Lamsa\ApiCore\Exception
 */
class InvalidArgumentException extends Exception
{
    /**
     * @var  string
     */
    const MESSAGE = '%s must be of type %s.';

    /**
     * InvalidArgumentException constructor.
     *
     * @param string          $parameter
     * @param string          $type
     * @param int             $code
     * @param \Throwable|null $previousException
     */
    public function __construct(string $parameter, string $type, int $code = 0, \Throwable $previousException = null)
    {
        parent::__construct(sprintf(static::MESSAGE, $parameter, $type), $code, $previousException);
    }

}
