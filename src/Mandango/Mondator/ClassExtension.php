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

use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;

/**
 * ClassExtension is the base class for class extensions.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
abstract class ClassExtension
{
    protected $options         = array();
    protected $requiredOptions = array();

    protected $definitions;

    protected $class;
    protected $configClasses;
    protected $configClass;

    protected $newClassExtensions;
    protected $newConfigClasses;

    protected $twig;
    protected $twigTempDir;

    /**
     * Constructor.
     *
     * @param array $options An array of options.
     */
    public function __construct(array $options = array())
    {
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
     */
    protected function setUp()
    {
    }

    /**
     * Add an option.
     *
     * @param string $name         The option name.
     * @param mixed  $defaultValue The default value (optional, null by default).
     */
    protected function addOption($name, $defaultValue = null)
    {
        $this->options[$name] = $defaultValue;
    }

    /**
     * Add options.
     *
     * @param array $options An array with options (name as key and default value as value).
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
     */
    protected function doNewConfigClassesProcess()
    {
    }

    /**
     * Process the config class.
     *
     * @param string       $class         The class.
     * @param \ArrayObject $configClasses The config classes.
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
     */
    protected function doClassProcess()
    {
    }

    /**
     * Twig.
     */
    protected function processTemplate(Definition $definition, $name, array $variables = array())
    {
        $twig = $this->getTwig();

        $variables['options'] = $this->options;
        $variables['class'] = $this->class;
        $variables['config_class'] = $this->configClass;
        $variables['config_classes'] = $this->configClasses;

        $result = $twig->loadTemplate($name)->render($variables);

        // properties
        $expression = '/
            (?P<docComment>\ \ \ \ \/\*\*\n[\s\S]*\ \ \ \ \ \*\/)?\n?
             \ \ \ \ (?P<static>static\ )?
            (?P<visibility>public|protected|private)
            \s
            \$
            (?P<name>[a-zA-Z0-9_]+)
            ;
        /xU';
        preg_match_all($expression, $result, $matches);

        for ($i = 0; $i <= count($matches[0]) - 1; $i++) {
            $property = new Property($matches['visibility'][$i], $matches['name'][$i], null);
            if ($matches['static'][$i]) {
                $property->setIsStatic(true);
            }
            if ($matches['docComment'][$i]) {
                $property->setDocComment($matches['docComment'][$i]);
            }
            $definition->addProperty($property);
        }

        // methods
        $expression = '/
            (?P<docComment>\ \ \ \ \/\*\*\n[\s\S]*\ \ \ \ \ \*\/)?\n
            \ \ \ \ (?P<static>static\ )?
            (?P<visibility>public|protected|private)
            \s
            function
            \s
            (?P<name>[a-zA-Z0-9_]+)
            \((?P<arguments>[$a-zA-Z0-9_\\=, ]*)\)
            \n
            \ \ \ \ \{
                (?P<code>[\s\S]*)
            \n\ \ \ \ \}
        /xU';
        preg_match_all($expression, $result, $matches);

        for ($i = 0; $i <= count($matches[0]) - 1; $i++) {
            $code = trim($matches['code'][$i], "\n");
            $method = new Method($matches['visibility'][$i], $matches['name'][$i], $matches['arguments'][$i], $code);
            if ($matches['static'][$i]) {
                $method->setIsStatic(true);
            }
            if ($matches['docComment'][$i]) {
                $method->setDocComment($matches['docComment'][$i]);
            }
            $definition->addMethod($method);
        }
    }

    public function getTwig()
    {
        if (null === $this->twig) {
            if (!class_exists('Twig_Environment')) {
                throw new \RuntimeException('Twig is required to use templates.');
            }

            $templateDirs = array();
            $ref = new \ReflectionClass($this);
            $templateDirs = dirname($ref->getFileName()).'/templates';

            $loader = new \Twig_Loader_Filesystem($templateDirs);
            $twig = new \Twig_Environment($loader, array(
                'autoescape'       => false,
                'strict_variables' => true,
                'debug'            => true,
                'cache'            => $this->twigTempDir = sys_get_temp_dir().'Mondator/'.mt_rand(111111, 999999),
            ));

            $this->configureTwig($twig);

            $this->twig = $twig;
        }

        return $this->twig;
    }

    protected function configureTwig(\Twig_Environment $twig)
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

    private function removeDir($target)
    {
        $fp = opendir($target);
        while (false !== $file = readdir($fp)) {
            if (in_array($file, array('.', '..'))) {
                continue;
            }

            if (is_dir($target.'/'.$file)) {
                self::removeDir($target.'/'.$file);
            } else {
                unlink($target.'/'.$file);
            }
        }
        closedir($fp);
        rmdir($target);
    }

    public function __destruct()
    {
        if ($this->twigTempDir && is_dir($this->twigTempDir)) {
            $this->removeDir($this->twigTempDir);
        }
    }
}
