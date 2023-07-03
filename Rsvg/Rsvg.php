<?php
namespace pavlm\Rsvg;

use pavlm\Rsvg\ffi\librsvg;
use pavlm\Rsvg\ffi\libcairo;

class Rsvg
{
    /**
     * SVG to PNG conversion
     *
     * @param string $svgData
     * @return \boolean|string
     */
    public static function convertSvg2Png($svgData)
    {
        $rsvg = librsvg::rsvg_handle_new_from_data($svgData, strlen($svgData), null); // deadlock point
        if (!$rsvg || !$rsvg[0]) {
            return false;
        }
        
        $dimension = librsvg::ffi()->new('RsvgDimensionData');
        
        librsvg::rsvg_handle_get_dimensions($rsvg, \FFI::addr($dimension));
        if (!$dimension->width && !$dimension->height) {
            return false;
        }
        
        $surface = libcairo::cairo_image_surface_create(0, $dimension->width, $dimension->height);
        $cairo = libcairo::cairo_create($surface);
        librsvg::rsvg_handle_render_cairo($rsvg, $cairo);
        
        $pngDataArray = [];
        $cairoWriteFunc = function($closure, $data, $length) use (&$pngDataArray) {
            $str = \FFI::string($data, $length);
            $pngDataArray[] = $str;
            return libcairo::CAIRO_STATUS_SUCCESS;
        };
        
        libcairo::cairo_surface_write_to_png_stream($surface, $cairoWriteFunc, null);
        
        librsvg::rsvg_handle_free($rsvg);
        librsvg::rsvg_cleanup();
        
        libcairo::cairo_destroy($cairo);
        libcairo::cairo_surface_destroy($surface);
        
        return implode('', $pngDataArray);
    }
    
    /**
     * Gets dimension of SVG 
     * 
     * @param string $svgData
     * @return boolean|array
     */
    public static function getDimension($svgData)
    {
        $rsvg = librsvg::rsvg_handle_new_from_data($svgData, strlen($svgData), null);
        if (!$rsvg || !$rsvg[0]) {
            return false;
        }
        
        $dimension = librsvg::ffi()->new('RsvgDimensionData');
        
        librsvg::rsvg_handle_get_dimensions($rsvg, \FFI::addr($dimension));
        
        return [
            'width' => $dimension->width,
            'height' => $dimension->height,
        ];
    }
    
}