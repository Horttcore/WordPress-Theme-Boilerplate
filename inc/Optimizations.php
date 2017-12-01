<?php
/**
 * Optimize WordPress
 *
 * @package Horttcore\WP_SLUG
 */
namespace Horttcore\WP_SLUG;

class Optimizations
{


    /**
     * Init
     *
     */
    function __construct()
    {
        add_action( 'after_setup_theme', [$this, 'header'] );
        add_action( 'after_setup_theme', [$this, 'emoji'] );
        add_action( 'after_setup_theme', [$this, 'login'] );
    }


    /**
     * Remove emoji support
     *
     * @return void
     */
    public function emoji()
    {
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        add_filter( 'tiny_mce_plugins', function () {
            return ( is_array( $plugins ) ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
        } );
    }


    /**
     * Clean header
     *
     * @return void
     */
    public function header()
    {
        remove_action( 'wp_head', 'wp_generator' );
        remove_action ('wp_head', 'rsd_link');
        remove_action( 'wp_head', 'wlwmanifest_link');
        remove_action( 'wp_head', 'wp_shortlink_wp_head');
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head');
        remove_action( 'wp_head', 'rest_output_link_wp_head');
        add_filter( 'the_generator', '__return_null' );
    }


    /**
     * Login
     *
     * @return void
     */
    public function login()
    {
        add_filter( 'login_headerurl', function () {
            return get_bloginfo( 'wpurl' );
        } );
    }


}
