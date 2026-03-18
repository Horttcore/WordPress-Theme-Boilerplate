<?php

declare(strict_types=1);

/**
 * ------------------------------------------------------------------------------
 * Theme configuration
 *
 * - Composer autoloader
 * - Register assets
 * - Optimize WordPress output
 * ------------------------------------------------------------------------------
 */

use RalfHortt\Assets\Script;
use RalfHortt\Assets\Style;
use RalfHortt\WPBlock\BlockManifest;

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
    add_editor_style('build/assets/editor-styles.scss.css');

    /**
     * ------------------------------------------------------------------------------
     * Assets management
     *
     * @see https://github.com/Horttcore/wp-assets
     * ------------------------------------------------------------------------------
     */
    (new Script('theme', get_template_directory_uri().'/build/assets/app.ts.js', [], true))->register();
    (new Style('theme', get_template_directory_uri().'/build/assets/app.scss.css', []))->register();

    /**
     * ------------------------------------------------------------------------------
     * Register blocks from a manifest file
     *
     * @see https://github.com/Horttcore/wp-block
     * ------------------------------------------------------------------------------
     */
    // (new BlockManifest(__DIR__.'/build/blocks/blocks-manifest.php'))->register();
});

/**
 * Register per-block custom styles from manifest
 */
require_once get_template_directory().'/inc/blocks/block-styles-registration.php';

/**
 * ------------------------------------------------------------------------------
 * Put project specific code in functions.custom.php
 * ------------------------------------------------------------------------------
 */
