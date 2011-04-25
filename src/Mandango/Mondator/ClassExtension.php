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
 * ClassExtension is the base class for class extensions.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 *
 * @api
 */
abstract class ClassExtension
{
    private $options;
    private $requiredOptions;

    protected $definitions;

    protected $class;
    protected $configClasses;
    protected $configClass;

    protected $newClassExtensions;
    protected $newConfigClasses;

    /**
     * Constructor.
     *
     * @param array $options An array of options.
     *
     * @api
     */
    public function __construct(array $options = array())
    {
        $this->options = array();
        $this->requiredOptions = array();

        $this->setUp();

        foreach ($options as $name => $value) {
            $this->setOption($name, $value);
        }

        // required options
        if ($diff = array_diff($this->requiredOptions, array_keys($options))) {
            throw new \RuntimeException(sprintf('%s requires the options: "%s".', get_class($this), implode(', ', $diff)));
        }
    }

    /**
     * Set up the extension.
     *
     * @api
     */
    protected function setUp()
    {
    }

    /**
     * Add an option.
     *
     * @param string $name         The option name.
     * @param mixed  $defaultValue The default value (optional, null by default).
     *
     * @api
     */
    protected function addOption($name, $defaultValue = null)
    {
        $this->options[$name] = $defaultValue;
    }

    /**
     * Add options.
     *
     * @param array $options An array with options (name as key and default value as value).
     *
     * @api
     */
    protected function addOptions(array $options)
    {
        foreach ($options as $name => $defaultValue) {
            $this->addOption($name, $defaultValue);
        }
    }

    /**
     * Add a required option.
     *
     * @param string $name The option name.
     *
     * @api
     */
    protected function addRequiredOption($name)
    {
        $this->addOption($name);

        $this->requiredOptions[] = $name;
    }

    /**
     * Add required options.
     *
     * @param array $options An array with the name of the required option as value.
     *
     * @api
     */
    protected function addRequiredOptions(array $options)
    {
        foreach ($options as $name) {
            $this->addRequiredOption($name);
        }
    }

    /**
     * Returns if exists an option.
     *
     * @param string $name The name.
     *
     * @return bool Returns true if the option exists, false otherwise.
     *
     * @api
     */
    public function hasOption($name)
    {
        return array_key_exists($name, $this->options);
    }

    /**
     * Set an option.
     *
     * @param string $name  The name.
     * @param mixed  $value The value.
     *
     * @throws \InvalidArgumentException If the option does not exists.
     *
     * @api
     */
    public function setOption($name, $value)
    {
        if (!$this->hasOption($name)) {
            throw new \InvalidArgumentException(sprintf('The option "%s" does not exists.', $name));
        }

        $this->options[$name] = $value;
    }

    /**
     * Returns the options.
     *
     * @return array The options.
     *
     * @api
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Return an option.
     *
     * @param string $name The name.
     *
     * @return mixed The value of the option.
     *
     * @throws \InvalidArgumentException If the options does not exists.
     *
     * @api
     */
    public function getOption($name)
    {
        if (!$this->hasOption($name)) {
            throw new \InvalidArgumentException(sprintf('The option "%s" does not exists.', $name));
        }

        return $this->options[$name];
    }

    /**
     * New class extensions process.
     *
     * @param string       $class              The class.
     * @param \ArrayObject $configClasses      The config classes.
     * @param \ArrayObject $newClassExtensions The new class extensions.
     *
     * @api
     */
    public function newClassExtensionsProcess($class, \ArrayObject $configClasses, \ArrayObject $newClassExtensions)
    {
        $this->class = $class;
        $this->configClasses = $configClasses;
        $this->configClass = $configClasses[$class];
        $this->newClassExtensions = $newClassExtensions;

        $this->doNewClassExtensionsProcess();

        $this->class = null;
        $this->configClasses = null;
        $this->configClass = null;
        $this->newClassExtensions = null;
    }

    /**
     * Do the new class extensions process.
     *
     * Here you can add new class extensions.
     *
     * @api
     */
    protected function doNewClassExtensionsProcess()
    {
    }

    /**
     * New config classes process.
     *
     * @param string       $class            The class.
     * @param \ArrayObject $configClasses    The config classes.
     * @param \ArrayObject $newConfigClasses The new config classes.
     *
     * @api
     */
    public function newConfigClassesProcess($class, \ArrayObject $configClasses, \ArrayObject $newConfigClasses)
    {
        $this->class = $class;
        $this->configClasses = $configClasses;
        $this->configClass = $configClasses[$class];
        $this->newConfigClasses = $newConfigClasses;

        $this->doNewConfigClassesProcess();

        $this->class = null;
        $this->configClasses = null;
        $this->configClass = null;
        $this->newConfigClasses = null;
    }

    /**
     * Do the new config classes process.
     *
     * Here you can add new config classes, and change the config classes
     * if it is necessary to build the new config classes.
     *
     * @api
     */
    protected function doNewConfigClassesProcess()
    {
    }

    /**
     * Process the config class.
     *
     * @param string       $class         The class.
     * @param \ArrayObject $configClasses The config classes.
     *
     * @api
     */
    public function configClassProcess($class, \ArrayObject $configClasses)
    {
        $this->class = $class;
        $this->configClasses = $configClasses;
        $this->configClass = $configClasses[$class];

        $this->doConfigClassProcess();

        $this->class = null;
        $this->configClasses = null;
        $this->configClass = null;
    }

    /**
     * Do the config class process.
     *
     * Here you can modify the config class.
     *
     * @api
     */
    protected function doConfigClassProcess()
    {
    }


    /**
     * Process the class.
     *
     * @param string                      $class         The class.
     * @param \ArrayObject                $configClasses The config classes.
     * @param Mandango\Mondator\Container $container     The container.
     *
     * @api
     */
    public function classProcess($class, \ArrayObject $configClasses, Container $container)
    {
        $this->class = $class;
        $this->configClasses = $configClasses;
        $this->configClass = $configClasses[$class];
        $this->definitions = $container;

        $this->doClassProcess();

        $this->class = null;
        $this->configClasses = null;
        $this->configClass = null;
        $this->definitions = null;
    }

    /**
     * Do the class process.
     *
     * @api
     */
    protected function doClassProcess()
    {
    }

    /*
     * Tools.
     */
    protected function createClassExtensionFromArray(array $data)
    {
        if (!isset($data['class'])) {
            throw new \InvalidArgumentException(sprintf('The extension does not have class.'));
        }

        return new $data['class'](isset($data['options']) ? $data['options'] : array());
    }
}
