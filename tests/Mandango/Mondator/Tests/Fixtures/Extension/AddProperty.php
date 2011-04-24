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

use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Property;
use Mandango\Mondator\Extension;

class AddProperty extends Extension
{
    protected $options = array(
        'definition' => null,
        'visibility' => null,
        'name'       => null,
        'value'      => null,
    );

    protected function setUp()
    {
        $this->addRequiredOptions(array(
            'definition',
            'visibility',
            'name',
            'value',
        ));
    }

    protected function doClassProcess()
    {
        $property = new Property($this->getOption('visibility'), $this->getOption('name'), $this->getOption('value'));

        $this->definitions[$this->getOption('definition')]->addProperty($property);
    }
}
