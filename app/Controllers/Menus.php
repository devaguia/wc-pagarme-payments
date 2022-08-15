<?php 

namespace WCPT\Controllers;

use WCPT\Helpers\Utils;

/**
 * Name: Menus
 * Creating submenus
 * @package Controller
 * @since 1.0.0
 */
class Menus 
{
    
    public function __construct()
    {
        $this->init();
    }

    /**
     * Set visible menus
     * @since 1.0.0
     * @param array
     */
    private function menus() {
        return [
            [ 'Service', __( 'Payment Service', WCPT_PLUGIN_SLUG ) ]
        ];
    }

    /**
     * Get the menu controllers
     * @since 1.0.0
     * @return array
     */
    private function init() 
    {

        $controllers = $this->menus();
        $menus = [];

        foreach ( $controllers as $key => $controller ) {

            $slug     = Utils::parse_view( $controller[0] );
            $function = WCPT_PLUGIN_NAMESPACE . "\\Controllers\\Menus\\$controller[0]";
            $menu     = [
                'title'    => $controller[1],
                'slug'     => $slug,
                'function' => [ new $function, 'request' ],
                'position' => $key
            ];

            array_push( $menus, $menu );
        }
        
        return $this->create( $menus );
    }

    /**
     * Create the submenus
     * @param array $menus
     * @return void
     */
    private function create( $menus ) {
        foreach ( $menus as $menu ) {
            add_submenu_page( 'woocommerce', $menu['title'], $menu['title'], 'manage_woocommerce', $menu['slug'], $menu['function'] );
        }
    }
}