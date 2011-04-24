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

use Mandango\Mondator\Container;
use Mandango\Mondator\Extension;

class ExtensionTesting extends Extension
{
    protected function setUp()
    {
        $this->addRequiredOptions(array(
            'required',
        ));

        $this->addOptions(array(
            'optional' => 'default_value',
            'foo'      => null,
            'bar'      => null,
        ));
    }

    protected function doClassProcess()
    {
    }
}

class ExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorOptions()
    {
        $extension = new ExtensionTesting(array('required' => 'value'));
        $this->assertSame(array(
            'required' => 'value',
            'optional' => 'default_value',
            'foo'      => null,
            'bar'      => null,
        ), $extension->getOptions());

        $extension = new ExtensionTesting(array('required' => 'barfoo', 'foo' => 'foobar'));
        $this->assertSame(array(
            'required' => 'barfoo',
            'optional' => 'default_value',
            'foo'      => 'foobar',
            'bar'      => null,
        ), $extension->getOptions());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorOptionNotExists()
    {
        new ExtensionTesting(array('foobar' => 'barfoo'));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructorNotSomeRequiredOption()
    {
        new ExtensionTesting(array('foo' => 'bar'));
    }

    public function testHasOption()
    {
        $extension = new ExtensionTesting(array('required' => 'value'));
        $this->assertTrue($extension->hasOption('foo'));
        $this->assertFalse($extension->hasOption('foobar'));
    }

    public function testSetOption()
    {
        $extension = new ExtensionTesting(array('required' => 'value'));
        $extension->setOption('foo', 'barfoo');
        $this->assertSame('barfoo', $extension->getOption('foo'));
        $this->assertSame('value', $extension->getOption('required'));
        $this->assertSame('default_value', $extension->getOption('optional'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetOptionNotExists()
    {
        $extension = new ExtensionTesting(array('required' => 'value'));
        $extension->setOption('foobar', 'barfoo');
    }

    public function testGetOptions()
    {
        $extension = new ExtensionTesting(array('required' => 'value'));
        $this->assertSame(array(
            'required' => 'value',
            'optional' => 'default_value',
            'foo'      => null,
            'bar'      => null,
        ), $extension->getOptions());
    }

    public function testGetOption()
    {
        $extension = new ExtensionTesting(array('required' => 'value'));
        $this->assertSame('value', $extension->getOption('required'));
        $this->assertSame('default_value', $extension->getOption('optional'));
        $this->assertNull($extension->getOption('bar'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetOptionNotExists()
    {
        $extension = new ExtensionTesting(array('required' => 'value'));
        $extension->getOption('foobar');
    }
}
