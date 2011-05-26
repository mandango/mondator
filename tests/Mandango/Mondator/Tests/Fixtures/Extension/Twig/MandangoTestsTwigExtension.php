<?php

/*
 * This file is part of Mandango.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mandango\Mondator\Tests\Fixtures\Extension\Twig;

use Mandango\Mondator\Extension;
use Mandango\Mondator\Definition;
use Mandango\Mondator\Output;

class MandangoTestsTwigExtension extends Extension
{
    protected function doClassProcess()
    {
        $this->definitions['document'] = new Definition($this->class, new Output(sys_get_temp_dir()));

        $this->processTemplate($this->definitions['document'], file_get_contents(__DIR__.'/templates/defining.php'));
    }
}
