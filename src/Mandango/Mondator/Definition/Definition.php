<?php

/*
 * This file is part of Mandango.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mandango\Mondator\Definition;

/**
 * Represents a definition of a class.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 *
 * @api
 */
class Definition
{
    private $class;
    private $parentClass;
    private $interfaces;
    private $final;
    private $abstract;
    private $properties;
    private $methods;
    private $docComment;

    /**
     * Constructor.
     *
     * @param string $class The class.
     *
     * @api
     */
    public function __construct($class)
    {
        $this->setClass($class);
        $this->interfaces = array();
        $this->final = false;
        $this->abstract = false;
        $this->properties = array();
        $this->methods = array();
    }

    /**
     * Set the class.
     *
     * @param string $class The class.
     *
     * @api
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * Returns the class.
     *
     * @return string The class.
     *
     * @api
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Returns the namespace.
     *
     * @return string|null The namespace.
     *
     * @api
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
     *
     * @api
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
     *
     * @api
     */
    public function setParentClass($parentClass)
    {
        $this->parentClass = $parentClass;
    }

    /**
     * Returns the parent class.
     *
     * @return string The parent class.
     *
     * @api
     */
    public function getParentClass()
    {
        return $this->parentClass;
    }

    /**
     * Add an interface.
     *
     * @param string $interface The interface.
     *
     * @api
     */
    public function addInterface($interface)
    {
        $this->interfaces[] = $interface;
    }

    /**
     * Set the interfaces.
     *
     * @param array $interfaces The interfaces.
     *
     * @api
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
     *
     * @api
     */
    public function getInterfaces()
    {
        return $this->interfaces;
    }

    /**
     * Set if the class is final.
     *
     * @param bool $final If the class is final.
     *
     * @api
     */
    public function setFinal($final)
    {
        $this->final = (bool) $final;
    }

    /**
     * Returns if the class is final.
     *
     * @return bool Returns if the class is final.
     *
     * @api
     */
    public function isFinal()
    {
        return $this->final;
    }

    /**
     * Set if the class is abstract.
     *
     * @param bool $abstract If the class is abstract.
     *
     * @api
     */
    public function setAbstract($abstract)
    {
        $this->abstract = (bool) $abstract;
    }

    /**
     * Returns if the class is abstract.
     *
     * @return bool If the class is abstract.
     *
     * @api
     */
    public function isAbstract()
    {
        return $this->abstract;
    }

    /**
     * Add a property.
     *
     * @param Mandango\Mondator\Definition\Property $property The property.
     *
     * @api
     */
    public function addProperty(Property $property)
    {
        $this->properties[] = $property;
    }

    /**
     * Set the properties.
     *
     * @param array $properties An array of properties.
     *
     * @api
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
     *
     * @api
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
     *
     * @api
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
     *
     * @api
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
     *
     * @api
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
     *
     * @api
     */
    public function addMethod(Method $method)
    {
        $this->methods[] = $method;
    }

    /**
     * Set the methods.
     *
     * @param array $methods An array of methods.
     *
     * @api
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
     *
     * @api
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
     *
     * @api
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
     *
     * @api
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
     *
     * @api
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
     *
     * @api
     */
    public function setDocComment($docComment)
    {
        $this->docComment = $docComment;
    }

    /**
     * Returns the doc comment.
     *
     * @return string|null The doc comment.
     *
     * @api
     */
    public function getDocComment()
    {
        return $this->docComment;
    }
}
