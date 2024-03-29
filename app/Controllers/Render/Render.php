<?php


namespace WPP\Controllers\Render;

use WPP\Helpers\Config;
use WPP\Helpers\Utils;

/**
 * Name: Render HTML
 * Create the method that renders views
 * @package Controller
 * @since 1.0.0
 */
abstract class Render implements InterfaceRender
{

    /**
     * Enqueue page/menu scripts
     * @param array $scripts
     * @return void
     */
    protected function enqueue_scripts( $script )
    {
        $link = isset( $script['external'] ) ? $script['external'] : Config::__dist( $script['file'] );
        wp_enqueue_script( $script['name'], $link );
    }

    /**
     * Enqueue page/menu styles
     * @param array $styles
     * @return void
     */
    protected function enqueue_styles( $style )
    {
        $link = isset( $style['external'] ) ? $style['external'] : Config::__dist( $style['file'] );
        wp_enqueue_style( $style['name'], $link );
    }

    /**
     * Call enqueue default
     * @return void
     */
    private function enqueue_default()
    {
        $this->enqueue_styles( [ 'name' => 'fontawesome', 'external' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css' ] );
        $this->enqueue_styles( [ 'name' => 'global', 'file' => 'styles/global/index.css' ] );
    }


    /**
     * Render HTML files
     * @param string $file
     * @param array $dados
     * @return void
     */
    public function render( $file, $data )
    {
        $this->enqueue_default();
        echo Utils::render( $file, $data );
    }
}