<?php

/*
 * This file is part of Mandango.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mandango\Mondator\Extension;

use Mandango\Mondator\Extension;

/**
 * Extension for fixing outputs according to the namespace separator.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class NamespaceSeparatorOutputFixerExtension extends Extension
{
    protected function doClassProcess()
    {
        $this->fixDefinitions();
    }
    protected function doPostGlobalProcess()
    {
        $this->fixDefinitions();
    }

    private function fixDefinitions()
    {
        foreach ($this->definitions as $definition) {
            $this->fixDefinition($definition);
        }
    }

    private function fixDefinition($definition)
    {
        $output = $definition->getOutput();
        $class = $definition->getClass();

        if ($this->outputNeedFixForClass($output, $class)) {
            $this->fixOutputForClass($output, $class);
        }
    }

    private function outputNeedFixForClass($output, $class)
    {
        return !strrpos($output->getDir(), $this->relativeDirForClass($class));
    }

    private function fixOutputForClass($output, $class)
    {
        return $output->setDir($this->dirForClass($output->getDir(), $class));
    }

    private function dirForClass($baseDir, $class)
    {
        return $baseDir.$this->relativeDirForClass($class);
    }

    private function relativeDirForClass($class)
    {
        $relativeDir = str_replace('\\', DIRECTORY_SEPARATOR, $this->classNamespace($class));

        return $relativeDir ? DIRECTORY_SEPARATOR.$relativeDir : '';
    }

    private function classNamespace($class)
    {
        if (false !== $pos = strrpos($class, '\\')) {
            return substr($class, 0, $pos);
        }
    }
}