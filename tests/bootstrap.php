<?php

// autoloader
require_once(__DIR__.'/../vendor/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php');

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Mandango\Mondator'       => __DIR__.'/../src',
    'Mandango\Mondator\Tests' => __DIR__,
));
$loader->registerPrefixes(array(
    'Twig_' => __DIR__.'/../vendor/twig/lib',
));
$loader->register();
