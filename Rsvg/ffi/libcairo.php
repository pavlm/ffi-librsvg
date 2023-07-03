<?php
namespace pavlm\Rsvg\ffi;

use \FFI\CData;

/**
 * FFI wrapper
 *
 * @method static CData cairo_image_surface_create(int $format, int $width, int $height)
 * @method static CData cairo_create(CData $target)
 * @method static cairo_surface_write_to_png(CData $surface, string $file)
 * @method static cairo_surface_write_to_png_stream(CData $surface, callable $write_func, $closure)
 * @method static cairo_destroy(CData $cr)
 * @method static cairo_surface_destroy(CData $surface)
 */
class libcairo
{
   
    const CAIRO_STATUS_SUCCESS = 0;
    
    private static $ffi;
    
    public static function ffi()
    {
        return self::$ffi ?: self::initFFI();
    }

    private static function isPreloaded()
    {
        $preloader = __DIR__ . '/preload.php';
        $status = opcache_get_status();
        return !!($status['scripts'][$preloader] ?? false);
    }

    private static function initFFI()
    {
        return self::$ffi = self::isPreloaded() ? 
            \FFI::scope('rsvg') : 
            \FFI::load(__DIR__ . '/libcairo.h');
    }
    
    public static function __callStatic($name, $arguments)
    {
        if (!self::$ffi) {
            self::initFFI();
        }
        return call_user_func_array([self::$ffi, $name], $arguments);
    }
    
}
