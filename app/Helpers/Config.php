<?php 

namespace WCPT\Helpers;

/**
 * Name: Config
 * Create configuration methods
 * @package Helper
 * @since 1.0.0
 */
class Config {

    /**
     * Get dist URL
     * @since 1.0.0
     * @param string @relative
     * @return string
     */
    public static function __dist( $relative = "" )
    {
        return plugins_url() . "/". self::__folder() ."/dist/$relative";
    }

    /**
     * Get images path
     * @since 1.0.0
     * @param string @relative
     * @return string
     */
    public static function __images( $relative = "" )
    {
        return plugins_url() . "/". self::__folder() ."/resources/images/$relative";
    }

     /**
     * Get resources path
     * @since 1.0.0
     * @param string @relative
     * @return string
     */
    public static function _resources( $relative = "" )
    {
        return plugins_url() . "/". self::__folder() ."/resources/$relative";
    }

    /**
     * Get view path
     * @since 1.0.0
     * @param string @relative
     * @return string
     */
    public static function __views( $relative = "" )
    {
        return self::__dir() . "/app/Views/$relative";
    }

    /**
     * Get dir path
     * @since 1.0.0
     * @param string $dir
     * @param int $level
     * @return string
     */
    public static function __dir( $dir = __DIR__, $level = 2 )
    {
        return dirname( $dir, $level );
    }


    /**
     * Get main file dir path
     * @since 1.0.0
     * @return string
     */
    public static function __main()
    {
        return self::__dir() . "/" . WCPT_PLUGIN_SLUG . ".php";
    }


    /**
     * Get base file
     * @since 1.0.0
     * @return string
     */
    public static function __base()
    {
        return self::__folder() . "/" . WCPT_PLUGIN_SLUG . ".php";
    }

    /**
     * Get plugin base folder
     * @since 1.0.0
     * @return string
     */
    public static function __folder()
    {
        $dir = explode( "/", self::__dir() ); 
        return $dir[ count( $dir ) - 1 ];
    }

    /**
     * Get plugin WC payment methods
     * @since 1.0.0
     * @return string
     */
    public static function _payment_methods()
    {
        return [
            'wc-plugin-template'
        ];
    }
}