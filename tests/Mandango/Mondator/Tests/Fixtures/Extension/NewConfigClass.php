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

use Mandango\Mondator\ClassExtension;

class NewConfigClass extends ClassExtension
{
    protected function setUp()
    {
        $this->addRequiredOptions(array(
            'suffix',
            'name',
        ));

        $this->addOptions(array(
            'multiple'        => false,
            'multiple_suffix' => null,
            'multiple_name'   => null,
        ));
    }

    protected function doNewConfigClassesProcess()
    {
        $newClassName = $this->class.$this->getOption('suffix');

        $configClass = array(
            'name' => $this->getOption('name'),
        );

        if ($this->getOption('multiple')) {
            $configClass['extensions'][] = array(
                'class'   => 'Mandango\Mondator\Tests\Fixtures\Extension\NewConfigClass',
                'options' => array(
                    'suffix' => $this->getOption('multiple_suffix'),
                    'name'   => $this->getOption('multiple_name'),
                ),
            );
        }

        $this->newConfigClasses[$newClassName] = $configClass;
    }
}
