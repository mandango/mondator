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

namespace Mandango\Mondator\Definition;

/**
 * Represents a definition of a class.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class Definition
{
    protected $class;
    protected $parentClass;
    protected $interfaces = array();
    protected $isFinal = false;
    protected $isAbstract = false;
    protected $properties = array();
    protected $methods = array();
    protected $docComment;

    /**
     * Constructor.
     *
     * @param string $class The class.
     */
    public function __construct($class)
    {
        $this->setClass($class);
    }

    /**
     * Set the class.
     *
     * @param string $class The class.
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * Returns the class.
     *
     * @return string The class.
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Returns the namespace.
     *
     * @return string|null The namespace.
     */
    public function getNamespace()
    {
        if (false !== $pos = strrpos($this->class, '\\')) {
            return substr($this->class, 0, $pos);
        }

        return null;
    }

    /**
     * Returns the class name.
     *
     * @return string|null The class name.
     */
    public function getClassName()
    {
        if (false !== $pos = strrpos($this->class, '\\')) {
            return substr($this->class, $pos + 1);
        }

        return $this->class;
    }

    /**
     * Set the parent class.
     *
     * @param string $parentClass The parent class.
     */
    public function setParentClass($parentClass)
    {
        $this->parentClass = $parentClass;
    }

    /**
     * Returns the parent class.
     *
     * @return string The parent class.
     */
    public function getParentClass()
    {
        return $this->parentClass;
    }

    /**
     * Add an interface.
     *
     * @param string $interface The interface.
     */
    public function addInterface($interface)
    {
        $this->interfaces[] = $interface;
    }

    /**
     * Set the interfaces.
     *
     * @param array $interfaces The interfaces.
     */
    public function setInterfaces(array $interfaces)
    {
        $this->interfaces = array();
        foreach ($interfaces as $interface) {
            $this->addInterface($interface);
        }
    }

    /**
     * Returns the interfaces.
     *
     * @return array The interfaces.
     */
    public function getInterfaces()
    {
        return $this->interfaces;
    }

    /**
     * Set if the class is final.
     *
     * @param bool $isFinal If the class is final.
     */
    public function setIsFinal($isFinal)
    {
        $this->isFinal = (bool) $isFinal;
    }

    /**
     * Returns if the class is final.
     *
     * @return bool Returns if the class is final.
     */
    public function getIsFinal()
    {
        return $this->isFinal;
    }

    /**
     * Set if the class is abstract.
     *
     * @param bool $isAbstract If the class is abstract.
     */
    public function setIsAbstract($isAbstract)
    {
        $this->isAbstract = (bool) $isAbstract;
    }

    /**
     * Returns if the class is abstract.
     *
     * @return bool If the class is abstract.
     */
    public function getIsAbstract()
    {
        return $this->isAbstract;
    }

    /**
     * Add a property.
     *
     * @param Mandango\Mondator\Definition\Property $property The property.
     */
    public function addProperty(Property $property)
    {
        $this->properties[] = $property;
    }

    /**
     * Set the properties.
     *
     * @param array $properties An array of properties.
     */
    public function setProperties(array $properties)
    {
        $this->properties = array();
        foreach ($properties as $name => $property) {
            $this->addProperty($property);
        }
    }

    /**
     * Returns the properties.
     *
     * @return array The properties.
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Returns if a property exists by name.
     *
     * @param string $name The property name.
     *
     * @return bool If the property exists.
     */
    public function hasPropertyByName($name)
    {
        foreach ($this->properties as $property) {
            if ($property->getName() == $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns a property by name.
     *
     * @param string $name The property name.
     *
     * @return Mandango\Mondator\Definition\Property The property.
     *
     * @throws \InvalidArgumentException If the property does not exists.
     */
    public function getPropertyByName($name)
    {
        foreach ($this->properties as $property) {
            if ($property->getName() == $name) {
                return $property;
            }
        }

        throw new \InvalidArgumentException(sprintf('The property "%s" does not exists.', $name));
    }

    /**
     * Remove property by name.
     *
     * @param string $name The property name.
     *
     * @throws \InvalidArgumentException If the property does not exists.
     */
    public function removePropertyByName($name)
    {
        foreach ($this->properties as $key => $property) {
            if ($property->getName() == $name) {
                unset($this->properties[$key]);
                return;
            }
        }

        throw new \InvalidArgumentException(sprintf('The property "%s" does not exists.', $name));
    }

    /**
     * Add a method.
     *
     * @param Mandango\Mondator\Definition\Method $method The method.
     */
    public function addMethod(Method $method)
    {
        $this->methods[] = $method;
    }

    /**
     * Set the methods.
     *
     * @param array $methods An array of methods.
     */
    public function setMethods(array $methods)
    {
        $this->methods = array();
        foreach ($methods as $name => $method) {
            $this->addMethod($method);
        }
    }

    /**
     * Returns the methods.
     *
     * @return array The methods.
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Returns if exists a method by name.
     *
     * @param string $name The method name.
     *
     * @return bool If the method exists.
     */
    public function hasMethodByName($name)
    {
        foreach ($this->methods as $method) {
            if ($method->getName() == $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return a method by name.
     *
     * @param string $name The method name.
     *
     * @return Mandango\Mondator\Definition\Method The method.
     *
     * @throws \InvalidArgumentException If the method does not exists.
     */
    public function getMethodByName($name)
    {
        foreach ($this->methods as $method) {
            if ($method->getName() == $name) {
                return $method;
            }
        }

        throw new \InvalidArgumentException(sprintf('The method "%s" does not exists.', $name));
    }

    /**
     * Remove a method by name.
     *
     * @param string $name The method name.
     *
     * @throws \InvalidArgumentException If the method does not exists.
     */
    public function removeMethodByName($name)
    {
        foreach ($this->methods as $key => $method) {
            if ($method->getName() == $name) {
                unset($this->methods[$key]);
                return;
            }
        }

        throw new \InvalidArgumentException(sprintf('The method "%s" does not exists.', $name));
    }

    /**
     * Set the doc comment.
     *
     * @param string|null $docComment The doc comment.
     */
    public function setDocComment($docComment)
    {
        $this->docComment = $docComment;
    }

    /**
     * Returns the doc comment.
     *
     * @return string|null The doc comment.
     */
    public function getDocComment()
    {
        return $this->docComment;
    }
}
