<?php

/*
 * This file is part of Mandango.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mandango\Mondator\Tests\Definition;

use Mandango\Mondator\Definition\Method;

class MethodTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $method = new Method('public', 'setVisibility', '$visibility', '$this->visibility = $visibility;');

        $this->assertSame('public',  $method->getVisibility());
        $this->assertSame('setVisibility', $method->getName());
        $this->assertSame('$visibility', $method->getArguments());
        $this->assertSame('$this->visibility = $visibility;', $method->getCode());
    }

    public function testVisibility()
    {
        $method = new Method('public', 'setVisibility', '$visibility', '$this->visibility = $visibility;');

        $method->setVisibility('protected');
        $this->assertSame('protected', $method->getVisibility());
    }

    public function testName()
    {
        $method = new Method('public', 'setVisibility', '$visibility', '$this->visibility = $visibility;');

        $method->setName('setV');
        $this->assertSame('setV', $method->getName());
    }

    public function testArguments()
    {
        $method = new Method('public', 'setVisibility', '$visibility', '$this->visibility = $visibility;');

        $method->setArguments('$v');
        $this->assertSame('$v', $method->getArguments());
    }

    public function testCode()
    {
        $method = new Method('public', 'setVisibility', '$visibility', '$this->visibility = $visibility;');

        $method->setCode('$this->visibility = $v;');
        $this->assertSame('$this->visibility = $v;', $method->getCode());
    }

    public function testIsFinal()
    {
        $method = new Method('public', 'setVisibility', '$visibility', '$this->visibility = $visibility;');

        $this->assertFalse($method->getIsFinal());
        $method->setIsFinal(true);
        $this->assertTrue($method->getIsFinal());
    }

    public function testIsStatic()
    {
        $method = new Method('public', 'setVisibility', '$visibility', '$this->visibility = $visibility;');

        $this->assertFalse($method->getIsStatic());
        $method->setIsStatic(true);
        $this->assertTrue($method->getIsStatic());
    }

    public function testIsAbstract()
    {
        $method = new Method('public', 'setVisibility', '$visibility', '$this->visibility = $visibility;');

        $this->assertFalse($method->getIsAbstract());
        $method->setIsAbstract(true);
        $this->assertTrue($method->getIsAbstract());
    }

    public function testDocComment()
    {
        $method = new Method('public', 'setVisibility', '$visibility', '$this->visibility = $visibility;');

        $method->setDocComment('myDoc');
        $this->assertSame('myDoc', $method->getDocComment());
    }
}
