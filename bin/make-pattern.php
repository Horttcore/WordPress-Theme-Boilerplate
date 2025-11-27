#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\multisearch;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;

// Get the pattern title using Laravel Prompts
$title = text('Enter pattern title', 'e.g. My Custom Pattern', '', true);

// Convert title to kebab case for filename
$slug = mb_strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', trim($title)));
$slug = trim($slug, '-');

// Get pattern description
$description = text('Enter pattern description (optional)', 'A brief description of what this pattern does', '');

// Category selection with predefined options
$categories = [
    'banner',
    'buttons',
    'columns',
    'gallery',
    'header',
    'text',
    'query',
    'featured',
    'call-to-action',
    'testimonials',
    'portfolio',
    'contact',
    'about',
    'services',
    'team',
];

$selectedCategories = multisearch(
    'Select pattern categories',
    function (string $value) use ($categories) {
        return array_filter(
            $categories,
            fn($category) => str_contains(mb_strtolower($category), mb_strtolower($value))
        );
    },
    'Start typing to search categories...'
);

// Keywords for better searchability
$keywordsInput = text('Enter keywords (comma-separated, optional)', 'keyword1, keyword2, keyword3');
$keywords = [];
if (!empty($keywordsInput)) {
    $keywords = array_map('trim', explode(',', $keywordsInput));
    $keywords = array_filter($keywords); // Remove empty values
}

// Block types (optional) - dynamically fetch from WordPress
$blockTypes = getRegisteredBlockTypes();

// Allow multiple selection with searchable interface for blocks
$supportedBlocks = multisearch(
    'Select block types this pattern supports (optional)',
    function (string $value) use ($blockTypes) {
        return array_filter(
            $blockTypes,
            fn($block) => str_contains(mb_strtolower($block), mb_strtolower($value))
        );
    },
    'Start typing to search blocks...'
);

// Post types (optional) - dynamically fetch from WordPress
$postTypes = getRegisteredPostTypes();

// Allow multiple selection with autocomplete for post types
$selectedPostTypes = [];
$addMore = true;
while ($addMore && count($selectedPostTypes) < 10) {
    $postTypeHint = count($selectedPostTypes) === 0 ? 'Enter a post type (optional, press Enter to skip)' : 'Add another post type (optional, press Enter to finish)';
    $selectedPostType = suggest(
        $postTypeHint,
        $postTypes,
        'Start typing to search post types or enter custom post type...'
    );

    if (!empty($selectedPostType)) {
        if (!in_array($selectedPostType, $selectedPostTypes)) {
            $selectedPostTypes[] = $selectedPostType;
        }
        $addMore = false;
    } else {
        $addMore = false;
    }
}
$supportedPostTypes = $selectedPostTypes;

// Template types (optional)
$templateTypeOptions = [
    '404',
    'archive',
    'author',
    'category',
    'date',
    'front-page',
    'home',
    'index',
    'page',
    'search',
    'single',
    'single-post',
    'tag',
    'taxonomy',
];

$supportedTemplateTypes = multisearch(
    'Select template types (optional)',
    function (string $value) use ($templateTypeOptions) {
        return array_filter(
            $templateTypeOptions,
            fn($templateType) => str_contains(mb_strtolower($templateType), mb_strtolower($value))
        );
    },
    'Start typing to search template types...'
);

// Inserter visibility (optional)
$inserter = confirm('Show pattern in inserter?', true);

// Source (optional)
$sourceOptions = ['theme', 'plugin'];
$source = suggest(
    'Enter pattern source',
    $sourceOptions,
    'Select theme or plugin...',
);

// Generate the pattern content
$patternContent = generatePatternContent($title, $description, $selectedCategories, $keywords, $supportedBlocks, $supportedPostTypes, $supportedTemplateTypes, $inserter, $source);

// Define target file path
$targetFile = __DIR__ . '/../patterns/' . $slug . '.php';

// Check if file already exists
if (file_exists($targetFile)) {
    $overwrite = confirm("Pattern file '$slug.php' already exists. Overwrite?", false);
    if (!$overwrite) {
        info('Pattern creation cancelled.');
        exit(0);
    }
}

// Write the pattern file
if (file_put_contents($targetFile, $patternContent) !== false) {
    info("✅ Pattern '$slug.php' created successfully!");
    info("📁 Location: patterns/$slug.php");
    info('🎨 You can now edit the pattern content in the WordPress site editor or directly in the HTML file.');
} else {
    error('❌ Failed to create pattern file.');
    exit(1);
}

/**
 * Generate the WordPress block pattern content
 */
function generatePatternContent($title, $description, $selectedCategories, $keywords, $supportedBlocks, $supportedPostTypes, $supportedTemplateTypes, $inserter, $source)
{
    $content = "<?php\n";
    $content .= "/**\n";
    $content .= ' * Title: ' . $title . "\n";
    $content .= ' * Slug: ' . getCurrentThemeTextdomain() . '/' . mb_strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', trim($title))) . "\n";
    $content .= ' * Description: ' . $description . "\n";
    $content .= ' * Categories: ' . (!empty($selectedCategories) ? implode(', ', $selectedCategories) : '') . "\n";

    if (!empty($keywords)) {
        $content .= ' * Keywords: ' . implode(', ', $keywords) . "\n";
    }

    if (!empty($supportedBlocks)) {
        $content .= ' * Block Types: ' . implode(', ', $supportedBlocks) . "\n";
    }

    if (!empty($supportedPostTypes)) {
        $content .= ' * Post Types: ' . implode(', ', $supportedPostTypes) . "\n";
    }

    if (!empty($supportedTemplateTypes)) {
        $content .= ' * Template Types: ' . implode(', ', $supportedTemplateTypes) . "\n";
    }

    if (!$inserter) {
        $content .= ' * Inserter: false' . "\n";
    }

    if (!empty($source)) {
        $content .= ' * Source: ' . $source . "\n";
    }

    $content .= " */\n";
    $content .= "?>\n\n";

    // Add a basic pattern structure
    $content .= "<!-- wp:group -->\n";
    $content .= "<div class=\"wp-block-group\">\n";
    $content .= "\t<!-- wp:heading -->\n";
    $content .= "\t<h2 class=\"wp-block-heading\">" . $title . "</h2>\n";
    $content .= "\t<!-- /wp:heading -->\n\n";
    $content .= "\t<!-- wp:paragraph -->\n";
    $content .= "\t<p>" . $description . "</p>\n";
    $content .= "\t<!-- /wp:paragraph -->\n";
    $content .= "</div>\n";
    $content .= "<!-- /wp:group -->\n";

    return $content;
}

/**
 * Get current theme textdomain from package.json
 */
function getCurrentThemeTextdomain()
{
    $packageJsonPath = __DIR__ . '/../package.json';
    if (file_exists($packageJsonPath)) {
        $packageData = json_decode(file_get_contents($packageJsonPath), true);

        return $packageData['name'] ?? 'theme';
    }

    return 'theme';
}

/**
 * Get registered block types from WordPress
 */
function getRegisteredBlockTypes()
{
    // Fallback blocks in case WordPress functions are not available
    $fallbackBlocks = [
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
        'core/preformatted', 'core/pullquote', 'core/quote', 'core/table', 'core/verse',
    ];

    // Try to get registered blocks from WordPress if running in WordPress context
    if (function_exists('WP_Block_Type_Registry') && class_exists('WP_Block_Type_Registry')) {
        try {
            $registry = WP_Block_Type_Registry::get_instance();
            $registeredBlocks = $registry->get_all_registered();

            $blockTypes = array_keys($registeredBlocks);

            // Filter out blocks that are not suitable for patterns
            $blockTypes = array_filter($blockTypes, function ($blockType) {
                // Exclude theme-specific blocks and some technical blocks
                $excludePatterns = [
                    '/^core\/template/',
                    '/^core\/post-/',
                    '/^core\/site-/',
                    '/^core\/query-/',
                    '/^core\/avatar/',
                    '/^core\/loginout/',
                ];

                foreach ($excludePatterns as $pattern) {
                    if (preg_match($pattern, $blockType)) {
                        return false;
                    }
                }

                return true;
            });

            sort($blockTypes);

            // Add option for custom block
            $blockTypes[] = 'custom-block';

            return $blockTypes;
        } catch (Exception $e) {
            // Fall back to default blocks if there's an error
            return $fallbackBlocks;
        }
    }

    // Add option for custom block to fallback
    $fallbackBlocks[] = 'custom-block';

    return $fallbackBlocks;
}

/**
 * Get registered post types from WordPress
 */
function getRegisteredPostTypes()
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
