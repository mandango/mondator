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

use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Dumper;

class DumperTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $definition = new Definition('Class1');

        $dumper = new Dumper($definition);
        $this->assertSame($definition, $dumper->getDefinition());
    }

    public function testDefinition()
    {
        $definition1 = new Definition('Class1');
        $definition2 = new Definition('Class2');

        $dumper = new Dumper($definition1);
        $dumper->setDefinition($definition2);
        $this->assertSame($definition2, $dumper->getDefinition());
    }
}
