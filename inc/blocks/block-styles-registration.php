<?php

declare(strict_types=1);

/**
 * Block Styles Registration
 *
 * Auto-register per-block styles from manifest cache file.
 * Handles both frontend (style.css) and editor (editor.css) stylesheets.
 */

/**
 * Load manifest and get block styles configuration
 */
function get_block_styles_manifest()
{
    $manifest_path = get_template_directory().'/build/manifest.php';

    if (! file_exists($manifest_path)) {
        return null;
    }

    try {
        return require $manifest_path;
    } catch (Throwable $e) {
        error_log('Failed to load block styles manifest: '.$e->getMessage());

        return null;
    }
}

/**
 * Register frontend block styles
 *
 * Enqueues style.css for each core block that has custom styles.
 * Uses build hash for cache busting.
 */
function register_block_frontend_styles()
{
    $manifest = get_block_styles_manifest();

    if (empty($manifest['blocks'])) {
        return;
    }

    $blocks = $manifest['blocks'];
    $build_hash = $manifest['build_hash'] ?? '';

    foreach ($blocks as $block_name => $files) {
        if (empty($files['exists_style'])) {
            continue;
        }

        $handle = "wp-block-core-{$block_name}-custom";
        $css_url = get_template_directory_uri()."/build/blocks/{$block_name}/style.css";

        // Enqueue with build hash for cache busting
        wp_enqueue_style(
            $handle,
            $css_url,
            [],
            $build_hash ?: filemtime(get_template_directory()."/build/blocks/{$block_name}/style.css")
        );
    }
}

/**
 * Register editor block styles
 *
 * Adds editor.css for each core block that has editor-specific styles.
 * These are only loaded in the WordPress block editor.
 */
function register_block_editor_styles()
{
    $manifest = get_block_styles_manifest();

    if (empty($manifest['blocks'])) {
        return;
    }

    $blocks = $manifest['blocks'];

    foreach ($blocks as $block_name => $files) {
        if (empty($files['exists_editor'])) {
            continue;
        }

        // add_editor_style() loads from theme root, so use relative path
        add_editor_style("build/blocks/{$block_name}/editor.css");
    }
}

/**
 * Check if a block has custom styles available
 *
 * Helper function to check if a specific block has frontend or editor styles.
 *
 * @param  string  $block_name  Block name (e.g., 'button', 'heading')
 * @param  string  $type  Optional. Type of style ('style' or 'editor'). If empty, checks both.
 * @return bool True if block has the specified style(s)
 */
function has_block_custom_styles($block_name, $type = '')
{
    $manifest = get_block_styles_manifest();

    if (empty($manifest['blocks'][$block_name])) {
        return false;
    }

    $files = $manifest['blocks'][$block_name];

    if (empty($type)) {
        return $files['exists_style'] || $files['exists_editor'];
    }

    $key = "exists_{$type}";

    return $files[$key] ?? false;
}

// Register hooks
add_action('wp_enqueue_scripts', 'register_block_frontend_styles', 99);
add_action('enqueue_block_editor_assets', 'register_block_editor_styles', 99);
