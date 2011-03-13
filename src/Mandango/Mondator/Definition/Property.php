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
 * Represents a property of a class.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class Property
{
    protected $visibility;
    protected $name;
    protected $value;
    protected $isStatic = false;
    protected $docComment;

    /**
     * Constructor.
     *
     * @param string $visibility The visibility.
     * @param string $name       The name.
     * @param mixed  $value      The value.
     */
    public function __construct($visibility, $name, $value)
    {
        $this->setVisibility($visibility);
        $this->setName($name);
        $this->setValue($value);
    }

    /**
     * Set the visibility.
     *
     * @param string $visibility The visibility.
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * Returns the visibility.
     *
     * @return string The visibility.
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set the name.
     *
     * @param string $name The name.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the name.
     *
     * @return string The name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value.
     *
     * @param mixed $value The value.
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Returns the value.
     *
     * @return mixed The value.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set if the property is static.
     *
     * @param bool $isStatic If the property is static.
     *
     * @throws \InvalidArgumentException If the $isStatic is not a boolean.
     */
    public function setIsStatic($isStatic)
    {
        if (!is_bool($isStatic)) {
            throw new \InvalidArgumentException('The $isStatic is not a boolean.');
        }

        $this->isStatic = $isStatic;
    }

    /**
     * Return if the property is static.
     *
     * @return bool Returns if the property is static.
     */
    public function getIsStatic()
    {
        return $this->isStatic;
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
