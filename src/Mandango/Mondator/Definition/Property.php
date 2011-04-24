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
