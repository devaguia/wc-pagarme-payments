<?php

namespace WPP\Helpers;

/**
 * Name: Utils
 * Has the statics methods
 * @package Helpers
 * @since 1.0.0
 */
class Utils
{
    /**
     * Parse constroller file name to view
     * @param string $controller
     * @return string
     */
    public static function parse_view( $controller )
    {

        $split = str_split( $controller );
        $view = '';
        $count = 0;

        foreach ( $split as $letter ) {
            if ( ctype_upper($letter) ) {
                if ( $count == 0 ) {
                    $view .= strtolower($letter);

                } else {
                    $view .= "_" . strtolower($letter);
                }

            } else {
                $view .= $letter;
            }
            $count++;
        }
        return $view;
    }

    /**
     * Render HTML files
     * @param string $file
     * @param array $data
     * @return string
     */
    public static function render( $file, $data )
    {
        extract($data);
        ob_start();

        $template = get_template_directory() . "/wctp-templates/$file";
        
        if ( ! file_exists( $template ) ) {
            $template = Config::__views( $file );
        }

        if ( file_exists( $template ) ) require $template;
        
        $html = ob_get_clean();
        
        ob_end_clean($html);

        return $html;
    }

    public static function active_payment_methods()
    {
        $gateways = WC()->payment_gateways->get_available_payment_gateways();
        $methods  = [];

        foreach ( $gateways as $key => $gateway ) {
            array_push( $methods, $key );
        }

        return $methods;
    }
}