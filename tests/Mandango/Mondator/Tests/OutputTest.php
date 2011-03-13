<?php

/*
 * Copyright 2010 Pablo Díez <pablodip@gmail.com>
 *
 * This file is part of Mandango.
 *
 * Mandango is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Mandango is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Mandango. If not, see <http://www.gnu.org/licenses/>.
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
