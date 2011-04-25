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
 *
 * @api
 */
class Property
{
    private $visibility;
    private $name;
    private $value;
    private $isStatic = false;
    private $docComment;

    /**
     * Constructor.
     *
     * @param string $visibility The visibility.
     * @param string $name       The name.
     * @param mixed  $value      The value.
     *
     * @api
     */
    public function __construct($visibility, $name, $value)
    {
        $this->setVisibility($visibility);
        $this->setName($name);
        $this->setValue($value);
        $this->isStatic = false;
    }

    /**
     * Set the visibility.
     *
     * @param string $visibility The visibility.
     *
     * @api
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * Returns the visibility.
     *
     * @return string The visibility.
     *
     * @api
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set the name.
     *
     * @param string $name The name.
     *
     * @api
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the name.
     *
     * @return string The name.
     *
     * @api
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value.
     *
     * @param mixed $value The value.
     *
     * @api
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Returns the value.
     *
     * @return mixed The value.
     *
     * @api
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
     *
     * @api
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
     *
     * @api
     */
    public function getIsStatic()
    {
        return $this->isStatic;
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
