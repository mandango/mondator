<?php

/*
 * This file is part of Mandango.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mandango\Mondator\Tests;

use Mandango\Mondator\Output;

class OutputTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $output = new Output('foo', true);
        $this->assertEquals('foo', $output->getDir());
        $this->assertTrue($output->getOverride());
    }

    public function testDir()
    {
        $output = new Output('foo');
        $this->assertEquals('foo', $output->getDir());
        $output->setDir('bar');
        $this->assertEquals('bar', $output->getDir());
    }

    public function testOverride()
    {
        $output = new Output('foo');
        $this->assertFalse($output->getOverride());
        $output->setOverride(true);
        $this->assertTrue($output->getOverride());
        $output->setOverride(1);
        $this->assertTrue($output->getOverride());
    }
}
