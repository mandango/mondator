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

use Mandango\Mondator\Definition\Property;

class PropertyTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $property = new Property('protected', 'visibilities', array('public', 'protected'));

        $this->assertSame('protected', $property->getVisibility());
        $this->assertSame('visibilities', $property->getName());
        $this->assertSame(array('public', 'protected'), $property->getValue());
    }

    public function testVisibility()
    {
        $property = new Property('protected', 'visibilities', array('public', 'protected'));

        $property->setVisibility('public');
        $this->assertSame('public', $property->getVisibility());
    }

    public function testName()
    {
        $property = new Property('protected', 'visibilities', array('public', 'protected'));

        $property->setName('vs');
        $this->assertSame('vs', $property->getName());
    }

    public function testValue()
    {
        $property = new Property('protected', 'visibilities', array('public', 'protected'));

        $property->setValue('public;protected;private');
        $this->assertSame('public;protected;private', $property->getValue());
    }

    public function testStatic()
    {
        $property = new Property('protected', 'visibilities', array('public', 'protected'));

        $this->assertFalse($property->isStatic());
        $property->setStatic(true);
        $this->assertTrue($property->isStatic());
    }

    public function testDocComment()
    {
        $property = new Property('protected', 'visibilities', array('public', 'protected'));

        $property->setDocComment('myDoc');
        $this->assertSame('myDoc', $property->getDocComment());
    }
}
