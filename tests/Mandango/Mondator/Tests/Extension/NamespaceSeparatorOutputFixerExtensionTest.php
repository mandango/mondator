<?php

/*
 * This file is part of Mandango.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mandango\Mondator\Tests\Extension;

use Mandango\Mondator\Extension\NamespaceSeparatorOutputFixerExtension;
use Mandango\Mondator\Output;
use Mandango\Mondator\Definition;
use Mandango\Mondator\Container;

class NamespaceSeparatorOutputFixerExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testFixesOutputForFullClass()
    {
        $this->checkFix('My\Full\Class', '/dir', '/dir/My/Full');
    }

    public function testDoesNotFixForSimpleClass($value='')
    {
        $this->checkFix('MyClass', '/dir', '/dir');
    }

    private function checkFix($class, $originalDir, $fixedDir)
    {
        foreach (array('Class', 'Global') as $containerType) {
            $this->checkFixForContainerType($containerType, $class, $originalDir, $fixedDir);
        }
    }

    private function checkFixForContainerType($containerType, $class, $originalDir, $fixedDir)
    {
        $output = new Output($originalDir);

        $method = 'checkFixFor'.$containerType.'Container';
        $this->$method($this->createContainer($class, $output));

        $this->assertSame($fixedDir, $output->getDir());
    }

    private function createContainer($class, $output)
    {
        $container = new Container();
        $container['test'] = $this->createDefinition($class, $output);

        return $container;
    }

    private function createDefinition($class, $output)
    {
        return new Definition($class, $output);
    }

    private function checkFixForClassContainer($container)
    {
        $class = 'Foo';
        $configClasses = new \ArrayObject(array($class => new \ArrayObject()));

        $this->createExtension()->classProcess($class, $configClasses, $container);
    }

    private function checkFixForGlobalContainer($container)
    {
        $this->createExtension()->postGlobalProcess(new \ArrayObject(), $container);
    }

    private function createExtension()
    {
        return new NamespaceSeparatorOutputFixerExtension();
    }
}
