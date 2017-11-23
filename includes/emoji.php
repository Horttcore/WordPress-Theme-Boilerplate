<?php
/**
 * Emoji
 *
 * @package WordPress Theme Boilerplate
 * @author Ralf Hortt <hello@horttcore.de>
 **/



/**
 * Disable emoji support
 *
 * @return void
 * @author Ralf Hortt <hello@horttcore.de>
 **/
function disable_wp_emojicons()
{

    // all actions related to emojis
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

    // filter to remove TinyMCE emojis
    add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );



/**
 * Disable emoji support
 *
 * @return void
 * @author Ralf Hortt <hello@horttcore.de>
 **/
function disable_emojicons_tinymce($plugins)
{

    return ( is_array( $plugins ) ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
}
