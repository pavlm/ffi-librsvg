<?php

use pavlm\Rsvg\Rsvg;

$autoloads = [
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../../autoload.php',
];
$autoload = array_values(array_filter($autoloads, fn($path) => file_exists($path)))[0] ?? false;
if (!$autoload) {
    throw new Exception("no autoloader found");
}
require $autoload;

$svgData = file_get_contents("php://stdin");

$png = Rsvg::convertSvg2Png($svgData);

if (!$png) {
    fprintf(STDERR, "svg conversion error\n");
    exit(1);
}

print $png;
