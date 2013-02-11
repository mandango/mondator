<?php

/*
 * This file is part of Mandango.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mandango\Mondator\Tests\Fixtures\Extension;

use Mandango\Mondator\Extension;
use Mandango\Mondator\Definition;
use Mandango\Mondator\Output;

class InitDefinition extends Extension
{
    protected function setUp()
    {
        $this->addRequiredOptions(array(
            'definition_name',
            'class_name',
        ));

        $this->addOption('output_dir', sys_get_temp_dir());
    }

    protected function doClassProcess()
    {
        $this->definitions[$this->getOption('definition_name')] = $this->createDefinition();
    }

    private function createDefinition()
    {
        return new Definition($this->getOption('class_name'), $this->createOutput());
    }

    private function createOutput()
    {
        return new Output($this->getOption('output_dir'));
    }
}