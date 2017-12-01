<?php
/**
 * Sidebars
 *
 * @package Horttcore\WP_SLUG
 */
namespace Horttcore\WP_SLUG;

class Sidebars
{

    /**
     * Class Constructor
     *
     * @param array $sidebars Sidebars
     * @return void
     */
    public function __construct(array $sidebars = [])
    {
        $this->sidebars = $sidebars;

        add_action( 'after_setup_theme', [ $this, 'registerSidebars'] );
    }


    /**
     * Register sidebars
     *
     * @return void
     */
    public function registerSidebars()
    {

        foreach ($this->sidebars as $name) :
            register_sidebar( array(
                'name' => $name,
                'id' => sanitize_title( $name ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>'
            ) );
        endforeach;
    }
}
