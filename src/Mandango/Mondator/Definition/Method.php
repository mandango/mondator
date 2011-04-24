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
 * Represents a method of a class.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class Method
{
    protected $visibility;
    protected $name;
    protected $arguments;
    protected $code;
    protected $isFinal = false;
    protected $isStatic = false;
    protected $isAbstract = false;
    protected $docComment;

    /**
     * Constructor.
     *
     * @param string $visibility The visibility.
     * @param string $name       The name.
     * @param string $arguments  The arguments (as string).
     * @param string $code       The code.
     */
    public function __construct($visibility, $name, $arguments, $code)
    {
        $this->setVisibility($visibility);
        $this->setName($name);
        $this->setArguments($arguments);
        $this->setCode($code);
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
     * Set the arguments.
     *
     * Example: "$argument1, &$argument2"
     *
     * @param string $arguments The arguments (as string).
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * Returns the arguments.
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Set the code.
     *
     * @param string $code.
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Returns the code.
     *
     * @return string The code.
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set if the method is final.
     *
     * @param bool $isFinal If the method is final.
     */
    public function setIsFinal($isFinal)
    {
        $this->isFinal = (bool) $isFinal;
    }

    /**
     * Returns if the method is final.
     *
     * @return bool If the method is final.
     */
    public function getIsFinal()
    {
        return $this->isFinal;
    }

    /**
     * Set if the method is static.
     *
     * @param bool $isStatic If the method is static.
     */
    public function setIsStatic($isStatic)
    {
        $this->isStatic = (bool) $isStatic;
    }

    /**
     * Return if the method is static.
     *
     * @return bool Returns if the method is static.
     */
    public function getIsStatic()
    {
        return $this->isStatic;
    }

    /**
     * Set if the method is abstract.
     *
     * @param bool $isAbstract If the method is abstract.
     */
    public function setIsAbstract($isAbstract)
    {
        $this->isAbstract = (bool) $isAbstract;
    }

    /**
     * Return if the method is abstract.
     *
     * @return bool Returns if the method is abstract.
     */
    public function getIsAbstract()
    {
        return $this->isAbstract;
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
