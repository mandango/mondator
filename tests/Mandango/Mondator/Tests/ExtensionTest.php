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

use Mandango\Mondator\Mondator;
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

    public function testTwigSupport()
    {
        $mondator = new Mondator();
        $mondator->setConfigClasses(array(
            'Model\Article' => array(
                'fields' => array(
                    'title'   => array(),
                    'content' => array(),
                ),
            ),
        ));
        $mondator->addExtension(new \Mandango\Mondator\Tests\Fixtures\Extension\Twig\MandangoTestsTwigExtension());

        $containers = $mondator->generateContainers();
        $article = $containers['Model\Article']->getDefinition('document');

        // properties
        $this->assertTrue($article->hasPropertyByName('publicProperty'));
        $this->assertSame('public', $article->getPropertyByName('publicProperty')->getVisibility());

        $this->assertTrue($article->hasPropertyByName('protectedProperty'));
        $this->assertSame('protected', $article->getPropertyByName('protectedProperty')->getVisibility());

        $this->assertTrue($article->hasPropertyByName('privateProperty'));
        $this->assertSame('private', $article->getPropertyByName('privateProperty')->getVisibility());

        $this->assertTrue($article->hasPropertyByName('staticProperty'));
        $this->assertTrue($article->getPropertyByName('staticProperty')->getIsStatic());

        // methods
        $this->assertTrue($article->hasMethodByName('publicMethod'));
        $this->assertSame('public', $article->getMethodbyName('publicMethod')->getVisibility());

        $this->assertTrue($article->hasMethodByName('protectedMethod'));
        $this->assertSame('protected', $article->getMethodbyName('protectedMethod')->getVisibility());

        $this->assertTrue($article->hasMethodByName('privateMethod'));
        $this->assertSame('private', $article->getMethodbyName('privateMethod')->getVisibility());

        $this->assertTrue($article->hasMethodByName('methodWithPhpDoc'));
        $this->assertSame(<<<EOF
    /**
     * phpDoc
     */
EOF
        , $article->getMethodbyName('methodWithPhpDoc')->getDocComment());

        $this->assertTrue($article->hasMethodByName('methodWithArguments'));
        $this->assertSame('$name, $value', $article->getMethodbyName('methodWithArguments')->getArguments());

        $this->assertTrue($article->hasMethodByName('methodWithCode'));
        $this->assertTrue($article->hasMethodByName('methodWithCode'));
        $this->assertSame(<<<EOF
        return null;
EOF
        , $article->getMethodbyName('methodWithCode')->getCode());

        $this->assertTrue($article->hasMethodByName('staticMethod'));
        $this->assertTrue($article->getMethodByName('staticMethod')->getIsStatic());
    }
}
