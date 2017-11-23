<?php
/**
 *
 * Change WordPress mail headers
 *
 */

if (!function_exists( 'theme_wp_mail_from' )) :
/**
 * WordPress mail from email
 *
 * @param  str $wp_mail_from WP mail from email
 * @return str WP mail from email
 * @since v1.0.18
 * @author Ralf Hortt
 **/
    function theme_wp_mail_from($wp_mail_from)
    {
        return get_option( 'admin_email' );
    }
endif;
add_action( 'wp_mail_from', 'theme_wp_mail_from' );



if (!function_exists( 'theme_wp_mail_from_name' )) :
/**
 * WordPress mail from name
 *
 * @param  str $wp_mail_from WP mail from name
 * @return str WP mail from name
 * @since v1.0.18
 * @author Ralf Hortt
 **/
    function theme_wp_mail_from_name($wp_mail_from_name)
    {
        return get_option( 'name' );
    }
endif;
add_action( 'wp_mail_from_name', 'theme_wp_mail_from_name' );
