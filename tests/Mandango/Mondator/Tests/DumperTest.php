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
