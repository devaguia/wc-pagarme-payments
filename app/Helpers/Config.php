<?php 

namespace WPP\Helpers;

/**
 * Name: Config
 * Create configuration methods
 * @package Helper
 * @since 1.0.0
 */
class Config 
{
    public static function __dist( string $relative = "" ): string
    {
        return plugins_url() . "/". self::__folder() ."/dist/$relative";
    }


    public static function __images( string $relative = "" ): string
    {
        return plugins_url() . "/". self::__folder() ."/resources/images/$relative";
    }


    public static function _resources( string $relative = "" ): string
    {
        return plugins_url() . "/". self::__folder() ."/resources/$relative";
    }


    public static function __views( string $relative = "" ): string
    {
        return self::__dir() . "/app/Views/$relative";
    }


    public static function __dir( string $dir = __DIR__, int $level = 2 ):string
    {
        return dirname( $dir, $level );
    }


    public static function __main(): string 
    {
        return self::__dir() . "/" . WPP_PLUGIN_SLUG . ".php";
    }


    public static function __base(): string
    {
        return self::__folder() . "/" . WPP_PLUGIN_SLUG . ".php";
    }


    public static function __folder(): string
    {
        $dir = explode( "/", self::__dir() ); 
        return $dir[ count( $dir ) - 1 ];
    }


    public static function _payment_methods(): string
    {
        return [
            'wc-pagarme-payments'
        ];
    }
}