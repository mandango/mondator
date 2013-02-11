<?php

/*
 * This file is part of Mandango.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mandango\Mondator;

/**
 * Represents a output for a definition.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 *
 * @api
 */
class Output
{
    private $dir;
    private $override;

    /**
     * Constructor.
     *
     * @param string $dir      The dir.
     * @param bool   $override The override. It indicate if override files (optional, false by default).
     *
     * @api
     */
    public function __construct($dir, $override = false)
    {
        $this->setDir($dir);
        $this->setOverride($override);
    }

    /**
     * Set the dir.
     *
     * @param $string $dir The dir.
     *
     * @api
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
    }

    /**
     * Returns the dir.
     *
     * @return string The dir.
     *
     * @api
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * Set the override. It indicate if override files.
     *
     * @param bool $override The override.
     *
     * @api
     */
    public function setOverride($override)
    {
        $this->override = (bool) $override;
    }

    /**
     * Returns the override.
     *
     * @return bool The override.
     *
     * @api
     */
    public function getOverride()
    {
        return $this->override;
    }
}
