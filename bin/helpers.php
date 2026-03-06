<?php

use function Laravel\Prompts\suggest;

/**
 * Get core blocks from local WordPress installation
 */
function ct_get_core_blocks_from_wordpress(): array
{
    $wpBlocksDir = realpath(__DIR__ . '/../../../../wp/wp-includes/blocks');
    if (!$wpBlocksDir || !is_dir($wpBlocksDir)) {
        return [];
    }

    $coreBlocks = [];
    $entries = scandir($wpBlocksDir);
    foreach ($entries as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }

        $blockPath = $wpBlocksDir . '/' . $entry;
        if (!is_dir($blockPath)) {
            continue;
        }

        if (!file_exists($blockPath . '/block.json')) {
            continue;
        }

        $coreBlocks[] = 'core/' . $entry;
    }

    $coreBlocks = array_unique($coreBlocks);
    sort($coreBlocks);

    return $coreBlocks;
}

/**
 * Fallback list of WordPress core blocks
 */
function ct_get_fallback_core_blocks(): array
{
    return [
        'core/avatar', 'core/comment-author-name', 'core/comment-content', 'core/comment-date',
        'core/comment-edit-link', 'core/comment-reply-link', 'core/comments', 'core/comments-pagination',
        'core/comments-pagination-next', 'core/comments-pagination-numbers', 'core/comments-pagination-previous',
        'core/comments-title', 'core/loginout', 'core/navigation', 'core/pattern', 'core/post-author',
        'core/post-author-biography', 'core/post-author-name', 'core/post-comments-form', 'core/post-content',
        'core/post-date', 'core/post-excerpt', 'core/post-featured-image', 'core/post-navigation-link',
        'core/post-template', 'core/post-terms', 'core/post-title', 'core/query', 'core/query-no-results',
        'core/query-pagination', 'core/query-pagination-next', 'core/query-pagination-numbers',
        'core/query-pagination-previous', 'core/query-title', 'core/query-total', 'core/read-more',
        'core/site-logo', 'core/site-tagline', 'core/site-title', 'core/template-part', 'core/term-description',
        'core/archives', 'core/calendar', 'core/categories', 'core/html', 'core/latest-comments',
        'core/latest-posts', 'core/legacy-widget', 'core/page-list', 'core/page-list-item', 'core/rss',
        'core/search', 'core/shortcode', 'core/social-link', 'core/social-links', 'core/tag-cloud',
        'core/widget-group', 'core/button', 'core/buttons', 'core/column', 'core/columns', 'core/comment-template',
        'core/group', 'core/home-link', 'core/more', 'core/navigation-link', 'core/navigation-submenu',
        'core/nextpage', 'core/separator', 'core/spacer', 'core/code', 'core/details', 'core/footnotes',
        'core/freeform', 'core/heading', 'core/list', 'core/list-item', 'core/missing', 'core/paragraph',
        'core/preformatted', 'core/pullquote', 'core/quote', 'core/table', 'core/verse'
    ];
}

/**
 * Get available blocks from the project
 *
 * @return array List of available blocks in namespace/block format
 */
function ct_get_available_blocks(): array
{
    $blocksBaseDir = __DIR__ . '/../src/theme/blocks';
    $blocks = [];

    // Prefer WordPress core blocks if available, otherwise fall back
    $coreBlocks = ct_get_core_blocks_from_wordpress();
    $blocks = array_merge($blocks, !empty($coreBlocks) ? $coreBlocks : ct_get_fallback_core_blocks());

    // Scan local blocks
    if (is_dir($blocksBaseDir)) {
        $namespaces = scandir($blocksBaseDir);
        foreach ($namespaces as $namespace) {
            if ($namespace === '.' || $namespace === '..') {
                continue;
            }

            $namespacePath = $blocksBaseDir . '/' . $namespace;
            if (is_dir($namespacePath)) {
                $blockNames = scandir($namespacePath);
                foreach ($blockNames as $blockName) {
                    if ($blockName === '.' || $blockName === '..') {
                        continue;
                    }

                    $blockPath = $namespacePath . '/' . $blockName;
                    if (is_dir($blockPath)) {
                        $blocks[] = $namespace . '/' . $blockName;
                    }
                }
            }
        }
    }

    // Remove duplicates and sort
    $blocks = array_unique($blocks);
    sort($blocks);

    return $blocks;
}

/**
 * Prompt for namespace/block selection
 */
function ct_prompt_namespace_block(string $label = 'Enter namespace/block'): string
{
    return suggest(
        $label,
        function ($search) {
            $blocks = ct_get_available_blocks();

            // Return all blocks if search is empty
            if (empty($search)) {
                return $blocks;
            }

            // Filter blocks with partial matching (case-insensitive)
            return array_filter(
                $blocks,
                fn($block) => stripos($block, $search) !== false
            );
        },
        'e.g. core/button',
        '',
        5,
        true,
        function ($value) {
            if (!str_contains((string)$value, '/')) {
                return 'Input must be in the format "namespace/block"';
            }
            return null;
        }
    );
}

/**
 * Get current theme textdomain from package.json
 */
function ct_get_current_theme_textdomain(): string
{
    $packageJsonPath = __DIR__ . '/../package.json';
    if (file_exists($packageJsonPath)) {
        $packageData = json_decode(file_get_contents($packageJsonPath), true);

        return $packageData['name'] ?? 'theme';
    }

    return 'theme';
}

/**
 * Get registered post types from WordPress
 */
function ct_get_registered_post_types(): array
{
    // Fallback post types
    $fallbackPostTypes = ['page', 'post'];

    // Try to get registered post types from WordPress if running in WordPress context
    if (function_exists('get_post_types')) {
        try {
            // Get public post types that are not built-in technical types
            $postTypes = get_post_types([
                'public' => true,
                '_builtin' => false,
            ], 'names');

            // Add built-in post types
            $builtInTypes = ['page', 'post'];
            $postTypes = array_merge($builtInTypes, $postTypes);

            // Remove unwanted post types
            $excludeTypes = ['attachment', 'revision', 'nav_menu_item', 'custom_css', 'customize_changeset'];
            $postTypes = array_diff($postTypes, $excludeTypes);

            sort($postTypes);

            return !empty($postTypes) ? $postTypes : $fallbackPostTypes;
        } catch (Exception $e) {
            // Fall back to default post types if there's an error
            return $fallbackPostTypes;
        }
    }

    // Add option for custom post type to fallback
    $fallbackPostTypes[] = 'custom-post-type';

    return $fallbackPostTypes;
}
