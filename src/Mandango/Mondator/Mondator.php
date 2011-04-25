<?php

/*
 * This file is part of Mandango.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mandango\Mondator;

/**
 * Mondator.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 *
 * @api
 */
class Mondator
{
    private $configClasses;
    private $extensions;
    private $outputs;

    /**
     * Constructor.
     *
     * @api
     */
    public function __construct()
    {
        $this->configClasses = array();
        $this->extensions = array();
        $this->options = array();
    }

    /**
     * Set a config class.
     *
     * @param string $class       The class.
     * @param array  $configClass The config class.
     *
     * @api
     */
    public function setConfigClass($class, array $configClass)
    {
        $this->configClasses[$class] = $configClass;
    }

    /**
     * Set the config classes.
     *
     * @param array $configClasses An array of config classes (class as key and config class as value).
     *
     * @api
     */
    public function setConfigClasses(array $configClasses)
    {
        $this->configClasses = array();
        foreach ($configClasses as $class => $configClass) {
            $this->setConfigClass($class, $configClass);
        }
    }

    /**
     * Returns if a config class exists.
     *
     * @param string $class The class.
     *
     * @return bool Returns if the config class exists.
     *
     * @api
     */
    public function hasConfigClass($class)
    {
        return array_key_exists($class, $this->configClasses);
    }

    /**
     * Returns the config classes.
     *
     * @return array The config classes.
     *
     * @api
     */
    public function getConfigClasses()
    {
        return $this->configClasses;
    }

    /**
     * Returns a config class.
     *
     * @param string $class The class.
     *
     * @return array The config class.
     *
     * @throws \InvalidArgumentException If the config class does not exists.
     *
     * @api
     */
    public function getConfigClass($class)
    {
        if (!$this->hasConfigClass($class)) {
            throw new \InvalidArgumentException(sprintf('The config class "%s" does not exists.', $class));
        }

        return $this->configClasses[$class];
    }

    /**
     * Add a extension.
     *
     * @param Mandango\Mondator\Extension $extension The extension.
     *
     * @api
     */
    public function addExtension(Extension $extension)
    {
        $this->extensions[] = $extension;
    }

    /**
     * Set the extensions.
     *
     * @param array $extensions An array of extensions.
     *
     * @api
     */
    public function setExtensions(array $extensions)
    {
        $this->extensions = array();
        foreach ($extensions as $extension) {
            $this->addExtension($extension);
        }
    }

    /**
     * Returns the extensions.
     *
     * @return array The extensions.
     *
     * @api
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * Generate the containers.
     *
     * @return array The containers.
     *
     * @api
     */
    public function generateContainers()
    {
        $containers = array();
        $containers['_global'] = new Container();

        // global extensions
        $globalExtensions = $this->getExtensions();

        // configClasses
        $configClasses = new \ArrayObject();
        foreach ($this->getConfigClasses() as $class => $configClass) {
            $configClasses[$class] = new \ArrayObject($configClass);
        }

        // classes extensions
        $classesExtensions = new \ArrayObject();
        $this->generateContainersClassesExtensions($globalExtensions, $classesExtensions, $configClasses);

        // config class process
        foreach ($classesExtensions as $class => $classExtensions) {
            foreach ($classExtensions as $classExtension) {
                $classExtension->configClassProcess($class, $configClasses);
            }
        }

        // pre global process
        foreach ($globalExtensions as $globalExtension) {
            $globalExtension->preGlobalProcess($configClasses, $containers['_global']);
        }

        // class process
        foreach ($classesExtensions as $class => $classExtensions) {
            $containers[$class] = $container = new Container();
            foreach ($classExtensions as $classExtension) {
                $classExtension->classProcess($class, $configClasses, $container);
            }
        }

        // post global process
        foreach ($globalExtensions as $globalExtension) {
            $globalExtension->postGlobalProcess($configClasses, $containers['_global']);
        }

        return $containers;
    }

    private function generateContainersClassesExtensions($globalExtensions, $classesExtensions, $configClasses)
    {
        foreach ($configClasses as $class => $configClass) {
            if (isset($classesExtensions[$class])) {
                continue;
            }

            $classesExtensions[$class] = $classExtensions = new \ArrayObject($globalExtensions);
            $this->generateContainersNewClassExtensions($class, $classExtensions, $configClasses);

            foreach ($classExtensions as $classExtension) {
                $newConfigClasses = new \ArrayObject();
                $classExtension->newConfigClassesProcess($class, $configClasses, $newConfigClasses);

                foreach ($newConfigClasses as $newClass => $newConfigClass) {
                    if (isset($classesExtensions[$newClass])) {
                        throw new \RuntimeException(sprintf('The class "%s" has several config classes.', $class));
                    }
                    $configClasses[$newClass] = new \ArrayObject($newConfigClass);
                }

                $this->generateContainersClassesExtensions($globalExtensions, $classesExtensions, $configClasses);
            }
        }
    }

    private function generateContainersNewClassExtensions($class, $classExtensions, $configClasses, $extensions = null)
    {
        if (null === $extensions) {
            $extensions = $classExtensions;
        }

        foreach ($extensions as $extension) {
            $newClassExtensions = new \ArrayObject();
            $extension->newClassExtensionsProcess($class, $configClasses, $newClassExtensions);

            foreach ($newClassExtensions as $newClassExtension) {
                if (!$newClassExtension instanceof ClassExtension) {
                    throw new \RuntimeException(sprintf('Some class extension of the class "%s" in the extension "%s" is not an instance of ClassExtension.', $class, get_class($extension)));
                }
                if ($newClassExtension instanceof Extension) {
                    throw new \RuntimeException(sprintf('Some class extension of the class "%s" in the extension "%s" is a instance of Extension, and it can be only a instance of ClassExtension.', $class, get_class($extension)));
                }

                $classExtensions[] = $newClassExtension;
                $this->generateContainersNewClassExtensions($class, $classExtensions, $configClasses, $newClassExtension);
            }
        }
    }

    /**
     * Dump containers.
     *
     * @param array $containers An array of containers.
     *
     * @api
     */
    public function dumpContainers(array $containers)
    {
        // directories
        foreach ($containers as $container) {
            foreach ($container->getDefinitions() as $name => $definition) {
                $output = $definition->getOutput();
                $dir    = $output->getDir();

                if (!file_exists($dir) && false === @mkdir($dir, 0777, true)) {
                    throw new \RuntimeException(sprintf('Unable to create the %s directory (%s).', $name, $dir));
                }

                if (!is_writable($dir)) {
                    throw new \RuntimeException(sprintf('Unable to write in the %s directory (%s).', $name, $dir));
                }
            }
        }

        // output
        foreach ($containers as $container) {
            foreach ($container->getDefinitions() as $name => $definition) {
                $output = $definition->getOutput($name);
                $dir    = $output->getDir();

                $file = $dir.DIRECTORY_SEPARATOR.$definition->getClassName().'.php';

                if (!file_exists($file) || $output->getOverride()) {
                    $dumper  = new Dumper($definition);
                    $content = $dumper->dump();

                    $tmpFile = tempnam(dirname($file), basename($file));
                    if (false === @file_put_contents($tmpFile, $content) || !@rename($tmpFile, $file)) {
                        throw new \RuntimeException(sprintf('Failed to write the file "%s".', $file));
                    }
                    chmod($file, 0644);
                }
            }
        }
    }

    /**
     * Generate and dump the containers.
     *
     * @api
     */
    public function process()
    {
        $this->dumpContainers($this->generateContainers());
    }
}
