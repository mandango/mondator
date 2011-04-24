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

class ProcessOthersFromArray extends Extension
{
    protected function doNewClassExtensionsProcess()
    {
        if (isset($this->configClass['extensions'])) {
            foreach ($this->configClass['extensions'] as $extension) {
                $this->newClassExtensions[] = $this->createClassExtensionFromArray($extension);
            }
        }
    }
}
