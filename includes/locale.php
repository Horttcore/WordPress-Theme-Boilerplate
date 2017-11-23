<?php
/**
 *
 * Locale
 *
 */

if (!function_exists( 'theme_locale' )) :
/**
 * Load theme textdomain
 *
 * @author Ralf Hortt
 **/
    function theme_locale()
    {
        load_theme_textdomain( 'TEXTDOMAIN', get_template_directory() . '/languages' );
    }
endif;
add_action( 'after_setup_theme', 'theme_locale' );
