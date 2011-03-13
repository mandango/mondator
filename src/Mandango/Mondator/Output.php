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

namespace Mandango\Mondator;

/**
 * Represents a output for a definition.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class Output
{
    protected $dir;
    protected $override;

    /**
     * Constructor.
     *
     * @param string $dir      The dir.
     * @param bool   $override The override. It indicate if override files (optional, false by default).
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
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
    }

    /**
     * Returns the dir.
     *
     * @return string The dir.
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * Set the override. It indicate if override files.
     *
     * @param bool $override The override.
     */
    public function setOverride($override)
    {
        $this->override = (bool) $override;
    }

    /**
     * Returns the override.
     *
     * @return bool The override.
     */
    public function getOverride()
    {
        return $this->override;
    }
}
