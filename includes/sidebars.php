<?php
/**
 *
 * Sidebars
 *
 */

register_sidebar( array(
    'name' => __( 'Sidebar', 'TEXTDOMAIN' ),
    'id' => 'sidebar',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>'
) );
