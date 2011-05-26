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
 *
 * @api
 */
class Method
{
    private $visibility;
    private $name;
    private $arguments;
    private $code;
    private $final;
    private $static;
    private $abstract;
    private $docComment;

    /**
     * Constructor.
     *
     * @param string $visibility The visibility.
     * @param string $name       The name.
     * @param string $arguments  The arguments (as string).
     * @param string $code       The code.
     *
     * @api
     */
    public function __construct($visibility, $name, $arguments, $code)
    {
        $this->setVisibility($visibility);
        $this->setName($name);
        $this->setArguments($arguments);
        $this->setCode($code);
        $this->final = false;
        $this->static = false;
        $this->abstract = false;
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
     * Set the arguments.
     *
     * Example: "$argument1, &$argument2"
     *
     * @param string $arguments The arguments (as string).
     *
     * @api
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * Returns the arguments.
     *
     * @api
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Set the code.
     *
     * @param string $code.
     *
     * @api
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Returns the code.
     *
     * @return string The code.
     *
     * @api
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set if the method is final.
     *
     * @param bool $final If the method is final.
     *
     * @api
     */
    public function setFinal($final)
    {
        $this->final = (bool) $final;
    }

    /**
     * Returns if the method is final.
     *
     * @return bool If the method is final.
     *
     * @api
     */
    public function isFinal()
    {
        return $this->final;
    }

    /**
     * Set if the method is static.
     *
     * @param bool $static If the method is static.
     *
     * @api
     */
    public function setStatic($static)
    {
        $this->static = (bool) $static;
    }

    /**
     * Return if the method is static.
     *
     * @return bool Returns if the method is static.
     *
     * @api
     */
    public function isStatic()
    {
        return $this->static;
    }

    /**
     * Set if the method is abstract.
     *
     * @param bool $abstract If the method is abstract.
     *
     * @api
     */
    public function setAbstract($abstract)
    {
        $this->abstract = (bool) $abstract;
    }

    /**
     * Return if the method is abstract.
     *
     * @return bool Returns if the method is abstract.
     *
     * @api
     */
    public function isAbstract()
    {
        return $this->abstract;
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
