# pavlm/ffi-librsvg

PHP binding for `librsvg2`. It allows conversion (rasterisation) of SVG image to PNG, with minimal dependencies.

## Why

Recommended way to convert SVG in PHP is by using the ImageMagick extension. However, its SVG functionality may be limited depending on your system libraries. The actual conversion process is performed by `imagemagick-6.q16`, which has optional SVG support. For full SVG support, proper compilation is required, and in the background, it utilizes `librsvg2`.  
There are alternative conversion methods available, but they require cross-process communication.

## Installation

```
sudo apt install librsvg2-2
composer require pavlm/ffi-librsvg
```

## Usage

```php
<?php
use pavlm\Rsvg\Rsvg;

require 'vendor/autoload.php';

$svgData = '<svg viewBox="0 0 100 100">  <rect x="10" y="10" width="80" height="80" fill="green" />  </svg>';

print Rsvg::convertSvg2Png($svgData);

```

Conversion via command line utility rsvg-cli.php

```
curl https://upload.wikimedia.org/wikipedia/commons/f/fd/Ghostscript_Tiger.svg | \
 tee /tmp/tiger.svg | \
 php rsvg-cli.php | \
 tee /tmp/tiger.png | \
 display
```
