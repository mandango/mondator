<?php

use Symfony\Component\ClassLoader\UniversalClassLoader;

$vendorDir = __DIR__ . '/../vendor';

// autoloader
if (file_exists($vendorDir . '/.composer/autoload.php')) {
    $loader = require_once $vendorDir . '/.composer/autoload.php';
    /* @var $loader Composer\Autoload\ClassLoader */
    $loader->add('Mandango\Mondator\Tests', __DIR__);
} else {
    require_once $vendorDir . '/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';
    $loader = new UniversalClassLoader();
    $loader->registerNamespaces(array(
        'Mandango\Mondator' => __DIR__ . '/../src',
        'Mandango\Mondator\Tests' => __DIR__,
    ));
    $loader->registerPrefixes(array(
        'Twig_' => __DIR__ . '/../vendor/twig/lib',
    ));
    $loader->register();
}
