<?php
/*
* This file is part of Contao.
*
* Copyright (c) 2017 Jan Karai
*
* @license LGPL-3.0+
*/

namespace Dehil\TeaserBundle\Tests;
use Dehil\TeaserBundle\DehilTeaserBundle;
use PHPUnit\Framework\TestCase;
/**
* Tests the DehilTeaserBundle class.
*
* @author Dennis Hilpmann
*/
class DehilTeaserBundleTest extends TestCase {
    /**
    * Tests the object instantiation.
    */
    public function testCanBeInstantiated() {
        $bundle = new DehilTeaserBundle();
        $this->assertInstanceOf('Dehil\TeaserBundle\DehilTeaserBundle', $bundle);
    }
}