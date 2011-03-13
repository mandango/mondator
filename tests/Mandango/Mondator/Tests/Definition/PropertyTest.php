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

    public function testIsStatic()
    {
        $property = new Property('protected', 'visibilities', array('public', 'protected'));

        $this->assertFalse($property->getIsStatic());
        $property->setIsStatic(true);
        $this->assertTrue($property->getIsStatic());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetIsStaticNotBoolean()
    {
        $property = new Property('protected', 'visibilities', array('public', 'protected'));
        $property->setIsStatic(1);
    }

    public function testDocComment()
    {
        $property = new Property('protected', 'visibilities', array('public', 'protected'));

        $property->setDocComment('myDoc');
        $this->assertSame('myDoc', $property->getDocComment());
    }
}
