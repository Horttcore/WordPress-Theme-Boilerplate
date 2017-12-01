<?php
/**
 * Menus
 *
 * @package Horttcore\WP_SLUG
 */
namespace Horttcore\WP_SLUG;

class Menus
{

    /**
     * Class Constructor
     *
     * @param array $menus Menus
     * @return void
     */
    public function __construct(array $menus = [])
    {
        $this->menus = $menus;

        add_action( 'after_setup_theme', [ $this, 'registerMenus'] );
    }


    /**
     * Register menus
     *
     * @return void
     */
    public function registerMenus()
    {

        foreach ($this->menus as $location => $name) :
            register_nav_menu( $location, $name);
        endforeach;
    }
}
