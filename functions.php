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
$autoloader = __DIR__ . '/vendor/autoload.php';

if (is_readable($autoloader)) {
    include $autoloader;
}

if (! defined('WPINC')) {
    return;
}

/**
 * ------------------------------------------------------------------------------
 * Setup theme
 * ------------------------------------------------------------------------------
 */
add_action('after_setup_theme', function (): void {
    /**
     * ------------------------------------------------------------------------------
     * Setup theme support features
     *
     * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/
     * @see https://developer.wordpress.org/reference/functions/add_theme_support/
     * ------------------------------------------------------------------------------
     */
    load_theme_textdomain('TEXTDOMAIN', __DIR__ . '/languages');
    add_editor_style('build/css/editor.scss.css');

    /**
     * ------------------------------------------------------------------------------
     * Assets management
     *
     * @see https://github.com/Horttcore/wp-assets
     * ------------------------------------------------------------------------------
     */
    (new Script('theme', get_template_directory_uri() . '/build/js/app.ts.js', [], true))->register();
    (new Style('theme', get_template_directory_uri() . '/build/css/app.scss.css', []))->register();

    /**
     * ------------------------------------------------------------------------------
     * Define custom image sizes
     *
     * @see https://github.com/Horttcore/wp-image-sizes
     * ------------------------------------------------------------------------------
     */
    // (new ImageSize('name', __('Label', 'TEXTDOMAIN'), 50, 50, true))->register();


});

/**
 * ------------------------------------------------------------------------------
 * Put project specific code in functions.custom.php
 * ------------------------------------------------------------------------------
 */
