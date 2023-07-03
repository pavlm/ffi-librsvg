<?php
namespace pavlm\Rsvg\ffi;

use \FFI\CData;

/**
 * FFI wrapper
 * 
 * @method static CData rsvg_handle_new_from_data(string $data, int $data_len, $error)
 * @method static rsvg_handle_free(CData $rsvg)
 * @method static rsvg_handle_get_dimensions(CData $rsvg, CData $dimension_data)
 * @method static CData rsvg_handle_render_cairo(CData $rsvg, CData $cairo)
 * @method static rsvg_cleanup()
 */
class librsvg
{
    
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
            \FFI::load(__DIR__ . '/librsvg-2.h');
    }
    
    public static function __callStatic($name, $arguments)
    {
        if (!self::$ffi) {
            self::initFFI();
        }
        return call_user_func_array([self::$ffi, $name], $arguments);
    }
    
}
