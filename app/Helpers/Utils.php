<?php

namespace WPP\Helpers;

/**
 * Has the statics methods
 * 
 * @package Helpers
 * @since 1.0.0
 */
class Utils
{
    public static function parse_view( string $controller ): string
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


    public static function render( string $file, array $data ): string
    {
        extract($data);
        ob_start();

        $template = get_template_directory() . "/pagarme-templates/$file";
        
        if ( ! file_exists( $template ) ) {
            $template = Config::__views( $file );
        }

        if ( file_exists( $template ) ) require $template;
        
        $html = ob_get_clean();

        return $html;
    }

    public static function active_payment_methods(): array
    {
        $gateways = WC()->payment_gateways->get_available_payment_gateways();
        $methods  = [];

        foreach ( $gateways as $key => $gateway ) {
            array_push( $methods, $key );
        }

        return $methods;
    }
}