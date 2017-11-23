<?php
/**
 * Init widgets
 *
 * @since v1.0.12
 * @author Ralf Hortt
 **/
if (!function_exists( 'theme_widgets_init' )) :
    function theme_widgets_init()
    {

        $widgets = array(
            'WP_Widget_Contact' => 'widget.contact.php',
        );

        if (empty( $widgets )) :
            return;
        endif;

        foreach ($widgets as $widget_id => $widget_file) :
            require( $widget_file );
            register_widget( $widget_id );
        endforeach;
    }
endif;
add_action( 'widgets_init', 'theme_widgets_init' );
