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

use Mandango\Mondator\Definition;
use Mandango\Mondator\Output;

class DefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $output = new Output('foo', true);
        $definition = new Definition('Model\User', $output);

        $this->assertSame('Model\User', $definition->getClass());
        $this->assertSame($output, $definition->getOutput());
    }

    public function testSetGetOutput()
    {
        $output1 = new Output('foo');
        $output2 = new Output('bar');

        $definition = new Definition('User', $output1);

        $this->assertSame($output1, $definition->getOutput());
        $definition->setOutput($output2);
        $this->assertSame($output2, $definition->getOutput());
    }
}
