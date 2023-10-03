<?php
/**
 * api-core - PlaceHolderExceptionInterface.php
 *
 * Date: 12/19/18
 * Time: 11:21 AM
 * @author    Abdelhameed Alasbahi <abdkwa92@gmail.com>
 * @copyright Copyright (c) 2018 LamsaWorld (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Exception;

/**
 * Interface PlaceHolderExceptionInterface
 * @package Lamsa\ApiCore\Exception
 */
interface PlaceHolderExceptionInterface
{
    /**
     * @return array
     */
    public function getPlaceHolders();
}