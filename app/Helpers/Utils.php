<?php

namespace WCPT\Helpers;

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
}