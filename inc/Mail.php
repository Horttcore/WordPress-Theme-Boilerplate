<?php
/**
 * Change WordPress mail headers
 *
 * @package Horttcore\WP_SLUG
 */
add_action( 'wp_mail_from', function () {
    return get_option( 'admin_email' );
} );

add_action( 'wp_mail_from_name', function () {
    return get_option( 'name' );
} );
