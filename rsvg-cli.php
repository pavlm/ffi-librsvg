<?php

use pavlm\Rsvg\Rsvg;

require 'vendor/autoload.php';

$svgData = file_get_contents("php://stdin");

$png = Rsvg::convertSvg2Png($svgData);

if (!$png) {
    fprintf(STDERR, "svg conversion error\n");
    exit(1);
}

print $png;

