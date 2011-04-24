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
