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

namespace Mandango\Mondator\Tests\Definition;

use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;

class DefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $definition = new Definition('Namespace\\Class1');
        $this->assertSame('Namespace\\Class1', $definition->getClass());
    }

    public function testClass()
    {
        $definition = new Definition('Namespace\\Class1');
        $this->assertSame('Namespace\\Class1', $definition->getClass());
        $definition->setClass('My\\Other\\Namespace\\MyOtherClass');
        $this->assertSame('My\\Other\\Namespace\\MyOtherClass', $definition->getClass());
    }

    public function testNamespace()
    {
        $definition = new Definition('Namespace\\Class1');
        $this->assertSame('Namespace', $definition->getNamespace());
    }

    public function testClassName()
    {
        $definition = new Definition('Namespace\\Class1');
        $this->assertSame('Class1', $definition->getClassName());
    }

    public function testParentClass()
    {
        $definition = new Definition('Class1');
        $definition->setParentClass('ParentFooBar');
        $this->assertSame('ParentFooBar', $definition->getParentClass());
    }

    public function testInterfaces()
    {
        $definition = new Definition('Class1');
        $definition->addInterface('\ArrayAccess');
        $definition->addInterface('\Countable');
        $this->assertSame(array('\ArrayAccess', '\Countable'), $definition->getInterfaces());

        $definition->setInterfaces($interfaces = array('\ArrayObject', '\InfiniteIterador'));
        $this->assertSame($interfaces, $definition->getInterfaces());
    }

    public function testIsFinal()
    {
        $definition = new Definition('Class1');
        $this->assertFalse($definition->getIsFinal());
        $definition->setIsFinal(true);
        $this->assertTrue($definition->getIsFinal());
    }

    public function testIsAbstract()
    {
        $definition = new Definition('Class1');
        $this->assertFalse($definition->getIsAbstract());
        $definition->setIsAbstract(true);
        $this->assertTrue($definition->getIsAbstract());
    }

    public function testProperties()
    {
        $properties = array();

        $properties[1] = new Property('public', 'property1', true);
        $properties[2] = new Property('public', 'property2', true);
        $properties[3] = new Property('public', 'property3', true);
        $properties[4] = new Property('public', 'property4', true);

        $definition = new Definition('Class1');

        // addProperty
        $definition->addProperty($properties[1]);
        $definition->addProperty($properties[2]);
        $this->assertSame(array($properties[1], $properties[2]), $definition->getProperties());

        // setProperties
        $definition->setProperties(array($properties[3], $properties[4]));
        $this->assertSame(array($properties[3], $properties[4]), $definition->getProperties());

        // hasPropertyByName
        $this->assertTrue($definition->hasPropertyByName('property3'));
        $this->assertFalse($definition->hasPropertyByName('property1'));

        // getPropertyByName
        $this->assertSame($properties[3], $definition->getPropertyByName('property3'));
        $this->assertSame($properties[4], $definition->getPropertyByName('property4'));

        // removePropertyByName
        $definition->setProperties($properties);
        $definition->removePropertyByName('property2');
        $this->assertFalse($definition->hasPropertyByName('property2'));
        $this->assertTrue($definition->hasPropertyByName('property1'));
        $this->assertTrue($definition->hasPropertyByName('property3'));
        $this->assertTrue($definition->hasPropertyByName('property4'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetPropertyByNameNotExists()
    {
        $definition = new Definition('Class1');
        $definition->getPropertyByName('propertyName');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRemovePropertyByNameNotExists()
    {
        $definition = new Definition('Class1');
        $definition->removePropertyByName('propertyName');
    }

    public function testMethods()
    {
        $methods = array();

        $methods[1] = new Method('public', 'method1', '', '');
        $methods[2] = new Method('public', 'method2', '', '');
        $methods[3] = new Method('public', 'method3', '', '');
        $methods[4] = new Method('public', 'method4', '', '');

        $definition = new Definition('Class1');

        // addMethod
        $definition->addMethod($methods[1]);
        $definition->addMethod($methods[2]);
        $this->assertSame(array($methods[1], $methods[2]), $definition->getMethods());

        // setMethods
        $definition->setMethods(array($methods[3], $methods[4]));
        $this->assertSame(array($methods[3], $methods[4]), $definition->getMethods());

        // hasMethodByName
        $this->assertTrue($definition->hasMethodByName('method3'));
        $this->assertFalse($definition->hasMethodByName('method1'));

        // getMethodByName
        $this->assertSame($methods[3], $definition->getMethodByName('method3'));
        $this->assertSame($methods[4], $definition->getMethodByName('method4'));

        // removeMethodByName
        $definition->setMethods($methods);
        $definition->removeMethodByName('method2');
        $this->assertFalse($definition->hasMethodByName('method2'));
        $this->assertTrue($definition->hasMethodByName('method1'));
        $this->assertTrue($definition->hasMethodByName('method3'));
        $this->assertTrue($definition->hasMethodByName('method4'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetMethodByNameNotExists()
    {
        $definition = new Definition('Class1');
        $definition->getMethodByName('methodName');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRemoveMethodByNameNotExists()
    {
        $definition = new Definition('Class1');
        $definition->removeMethodByName('methodName');
    }

    public function testDocComment()
    {
        $definition = new Definition('Class1');
        $definition->setDocComment('myDoc');
        $this->assertSame('myDoc', $definition->getDocComment());
    }
}
