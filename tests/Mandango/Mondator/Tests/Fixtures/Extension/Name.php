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

class Name extends Extension
{
    protected function doClassProcess()
    {
        $this->definitions['name'] = new Definition($this->configClass['name'], new Output(sys_get_temp_dir()));
    }
}
