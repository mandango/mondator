<?php

set_time_limit(0);

if (!is_dir($vendorDir = __DIR__.'/vendor')) {
    mkdir($vendorDir, 0777, true);
}

$deps = array(
    array('symfony', 'git://github.com/symfony/symfony', 'origin/master'),
    array('twig', 'git://github.com/fabpot/Twig', 'origin/master'),
);

foreach ($deps as $dep) {
    if (3 === count($dep)) {
        list($name, $url, $rev) = $dep;
        $installDir = $vendorDir.'/'.$name;
    } else {
        list($name, $url, $rev, $target) = $dep;
        $installDir = $vendorDir.'/'.$target;
    }

    $install = false;
    if (!is_dir($installDir)) {
        $install = true;
        echo "> Installing $name\n";

        system(sprintf('git clone -q %s %s', escapeshellarg($url), escapeshellarg($installDir)));
    }

    if (!$install) {
        echo "> Updating $name\n";
    }

    system(sprintf('cd %s && git fetch origin && git reset --hard %s', escapeshellarg($installDir), escapeshellarg($rev)));
}