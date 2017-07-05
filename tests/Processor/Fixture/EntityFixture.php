<?php
/**
 * api-core
 *
 *  @author    Zaid Sasa <zaidsa3sa3@gmail.com>
 *  @copyright Copyright (c) 2017 Lamsa World (http://www.lamsaworld.com/)
 */

namespace Tests\Lamsa\ApiCore\Processor\Fixture;

/**
 * Class EntityTest
 *
 * @package Tests\Lamsa\ApiCore\Processor\Fixture
 */
class EntityFixture
{
    /**
     * @var string
     */
    private $name = '';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

}