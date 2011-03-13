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

use Mandango\Mondator\Definition\Definition as BaseDefinition;

/**
 * Definitions to save with the extensions. Allows save the output.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class Definition extends BaseDefinition
{
    protected $output;

    /**
     * Constructor.
     *
     * @param string                   $class  The class.
     * @param Mandango\Mondator\Output $output The output.
     */
    public function __construct($class, Output $output)
    {
        parent::__construct($class);

        $this->setOutput($output);
    }

    /**
     * Set the output.
     *
     * @param Mandango\Mondator\Output $output The output.
     */
    public function setOutput(Output $output)
    {
        $this->output = $output;
    }

    /**
     * Returns the output.
     *
     * @return Mandango\Mondator\Output The output.
     */
    public function getOutput()
    {
        return $this->output;
    }
}
