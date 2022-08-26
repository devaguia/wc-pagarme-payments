<?php

namespace WPP\Controllers\Menus;

use WPP\Controllers\Render\Render;
use WPP\Helpers\Config;

/**
 * Name: Settings
 * @package Controller 
 * @since 1.0.0
 */
class Settings
{
    /**
     * Call the view render
     * @return void
     */
    public function request()
    {
        return $this->render( 'Admin/credit/installments.php', [] );
    }

    /**
     * Render HTML files
     * @param string $file
     * @param array $dados
     * @return string
     */
    public function render( $file, $dados )
    {
        extract($dados);
        ob_start();

        $template = get_template_directory() . "/wctp-templates/$file";
        
        if ( ! file_exists( $template ) ) {
            $template = Config::__views( $file );
        }
        
        require $template;
        $html = ob_get_clean();

        return $html;
    }
}