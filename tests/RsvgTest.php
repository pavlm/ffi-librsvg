<?php

use pavlm\Rsvg\Rsvg;

class RsvgTest extends \PHPUnit\Framework\TestCase
{
    
    const PNG_SIGNATURE = "\x89PNG"; 
    
    public function test_getDimension()
    {
        $size = Rsvg::getDimension('<svg viewBox="0 0 10 20"></svg>');
        $this->assertNotFalse($size, 'size error');
        ['width' => $width, 'height' => $height] = $size;
        $this->assertEquals(10, $width);
        $this->assertEquals(20, $height);
    }
    
    public function test_convert()
    {
        $svgData = '<svg viewBox="0 0 100 100">  <rect x="10" y="10" width="80" height="80" fill="green" />  </svg>';
        $png = Rsvg::convertSvg2Png($svgData);
        $this->assertNotEmpty($png, 'png data');
        $this->assertStringStartsWith(self::PNG_SIGNATURE, $png);
    }
}