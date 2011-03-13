<?php

// autoloader
require_once(__DIR__.'/../vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php');

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Mandango\Mondator'       => __DIR__.'/../src',
    'Mandango\Mondator\Tests' => __DIR__,
));
$loader->register();
