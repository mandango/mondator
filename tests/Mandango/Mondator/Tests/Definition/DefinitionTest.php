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

    public function testFinal()
    {
        $definition = new Definition('Class1');
        $this->assertFalse($definition->isFinal());
        $definition->setFinal(true);
        $this->assertTrue($definition->isFinal());
    }

    public function testAbstract()
    {
        $definition = new Definition('Class1');
        $this->assertFalse($definition->isAbstract());
        $definition->setAbstract(true);
        $this->assertTrue($definition->isAbstract());
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
