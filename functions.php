<?php

declare(strict_types=1);

/**
 * ------------------------------------------------------------------------------
 * Theme configuration
 *
 * - Composer autoloader
 * - Register assets
 * - Register image sizes
 * - Optimize WordPress output
 * ------------------------------------------------------------------------------
 */

use RalfHortt\Assets\Script;
use RalfHortt\Assets\Style;

/**
 * ------------------------------------------------------------------------------
 * Autoloader
 *
 * Load composer autoloader file
 * ------------------------------------------------------------------------------
 */
$autoloader = __DIR__.'/vendor/autoload.php';

if (is_readable($autoloader)) {
    include $autoloader;
}

if (! defined('WPINC')) {
    exit;
}

/**
 * ------------------------------------------------------------------------------
 * Setup theme
 * ------------------------------------------------------------------------------
 */
add_action('after_setup_theme', function () {
    /**
     * ------------------------------------------------------------------------------
     * Setup theme support features
     *
     * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/
     * @see https://developer.wordpress.org/reference/functions/add_theme_support/
     * ------------------------------------------------------------------------------
     */
    load_theme_textdomain('TEXTDOMAIN', sprintf('%s/languages', get_stylesheet_directory()));
    add_editor_style('dist/css/editor-styles.css');

    /**
     * ------------------------------------------------------------------------------
     * Assets management
     *
     * @see https://github.com/Horttcore/wp-assets
     * ------------------------------------------------------------------------------
     */
    (new Script('theme', get_template_directory_uri().'/build/js/app.ts.js', [], true, true))->register();
    (new Style('theme', get_template_directory_uri().'/build/css/app.scss.css', []))->register();

    /**
     * ------------------------------------------------------------------------------
     * Define custom image sizes
     *
     * @see https://github.com/Horttcore/wp-image-sizes
     * ------------------------------------------------------------------------------
     */
    // (new ImageSize('name', __('Label', 'TEXTDOMAIN'), 50, 50, true))->register();

    /**
     * ------------------------------------------------------------------------------
     * Optimizations
     * ------------------------------------------------------------------------------
     */
    remove_theme_support('core-block-patterns');
    remove_action('admin_print_styles', 'print_emoji_styles'); // Emoji
    remove_action('wp_head', 'print_emoji_detection_script', 7); // Emoji
    remove_action('admin_print_scripts', 'print_emoji_detection_script'); // Emoji
    remove_action('wp_print_styles', 'print_emoji_styles'); // Emoji
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email'); // Emoji
    remove_filter('the_content_feed', 'wp_staticize_emoji'); // Emoji
    remove_filter('comment_text_rss', 'wp_staticize_emoji'); // Emoji
    remove_action('wp_head', 'wp_generator'); // Remove WordPress generator meta tag
    remove_action('wp_head', 'rsd_link'); // Remove RSD link meta tag
    remove_action('wp_head', 'wlwmanifest_link'); // Remove WLW manifest link meta tag
    remove_action('wp_head', 'wp_shortlink_wp_head'); // Remove shortlink meta tag
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head'); // Remove adjacent posts link meta tags
    remove_action('wp_head', 'rest_output_link_wp_head'); // Remove REST output link meta tag
    add_filter('the_generator', '__return_null'); // Remove generator output
    add_filter('login_headerurl', 'home_url'); // Replace the login logo link with home url
    add_filter('wp_mail_from', function ($from) {
        if (mb_strpos($from, 'wordpress@') !== false) {
            return $from;
        }

        return get_option('admin_email');
    }); // Replace mail from with current admin email
    // Replace mail from name with site name
    add_filter(
        'wp_mail_from_name',
        function () {
            return get_bloginfo('name');
        }
    );
});

/**
 * ------------------------------------------------------------------------------
 * Put project specific code in functions.custom.php
 * ------------------------------------------------------------------------------
 */
