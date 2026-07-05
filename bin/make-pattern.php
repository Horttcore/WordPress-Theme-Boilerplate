#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/helpers.php';

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\multisearch;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;

// Get the pattern title using Laravel Prompts
$title = text('Enter pattern title', 'e.g. My Custom Pattern', '', true);

// Convert title to kebab case for filename
$slug = mb_strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', mb_trim($title)));
$slug = mb_trim($slug, '-');

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
        return array_values(array_filter(
            $categories,
            fn ($category): bool => str_contains(mb_strtolower($category), mb_strtolower($value))
        ));
    },
    'Start typing to search categories...'
);

// Keywords for better searchability
$keywordsInput = text('Enter keywords (comma-separated, optional)', 'keyword1, keyword2, keyword3');
$keywords = [];
if (! empty($keywordsInput)) {
    $keywords = array_map('trim', explode(',', $keywordsInput));
    $keywords = array_filter($keywords); // Remove empty values
}

// Block types (optional) - dynamically fetch from WordPress
$blockTypes = getRegisteredBlockTypes();

// Allow multiple selection with searchable interface for blocks
$supportedBlocks = multisearch(
    'Select block types this pattern supports (optional)',
    function (string $value) use ($blockTypes) {
        return array_values(array_filter(
            $blockTypes,
            fn ($block): bool => is_string($block) && str_contains(mb_strtolower($block), mb_strtolower($value))
        ));
    },
    'Start typing to search blocks...'
);

// Post types (optional) - dynamically fetch from WordPress
$postTypes = ct_get_registered_post_types();

// Allow multiple selection with autocomplete for post types
$selectedPostTypes = [];
$addMore = true;
while ($addMore && count($selectedPostTypes) < 10) {
    $postTypeHint = count($selectedPostTypes) === 0
        ? 'Enter a post type (optional, press Enter to skip)'
        : 'Add another post type (optional, press Enter to finish)';

    $selectedPostType = suggest(
        $postTypeHint,
        $postTypes,
        'Start typing to search post types or enter custom post type...'
    );

    if (empty($selectedPostType)) {
        break;
    }

    if (! in_array($selectedPostType, $selectedPostTypes, true)) {
        $selectedPostTypes[] = $selectedPostType;
    }

    if (count($selectedPostTypes) >= 10) {
        info('Maximum of 10 post types reached.');
        break;
    }

    $addMore = confirm('Add another post type?', false);
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
        return array_values(array_filter(
            $templateTypeOptions,
            fn ($templateType): bool => str_contains(mb_strtolower($templateType), mb_strtolower($value))
        ));
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
$targetFile = __DIR__.'/../patterns/'.$slug.'.php';

// Check if file already exists
if (file_exists($targetFile)) {
    $overwrite = confirm("Pattern file '$slug.php' already exists. Overwrite?", false);
    if (! $overwrite) {
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
    $content .= ' * Title: '.$title."\n";
    $content .= ' * Slug: '.ct_get_current_theme_textdomain().'/'.mb_strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', mb_trim($title)))."\n";
    $content .= ' * Description: '.$description."\n";
    $content .= ' * Categories: '.(! empty($selectedCategories) ? implode(', ', $selectedCategories) : '')."\n";

    if (! empty($keywords)) {
        $content .= ' * Keywords: '.implode(', ', $keywords)."\n";
    }

    if (! empty($supportedBlocks)) {
        $content .= ' * Block Types: '.implode(', ', $supportedBlocks)."\n";
    }

    if (! empty($supportedPostTypes)) {
        $content .= ' * Post Types: '.implode(', ', $supportedPostTypes)."\n";
    }

    if (! empty($supportedTemplateTypes)) {
        $content .= ' * Template Types: '.implode(', ', $supportedTemplateTypes)."\n";
    }

    if (! $inserter) {
        $content .= ' * Inserter: false'."\n";
    }

    if (! empty($source)) {
        $content .= ' * Source: '.$source."\n";
    }

    $content .= " */\n";
    $content .= "?>\n\n";

    // Add a basic pattern structure
    $content .= "<!-- wp:group -->\n";
    $content .= "<div class=\"wp-block-group\">\n";
    $content .= "\t<!-- wp:heading -->\n";
    $content .= "\t<h2 class=\"wp-block-heading\">".$title."</h2>\n";
    $content .= "\t<!-- /wp:heading -->\n\n";
    $content .= "\t<!-- wp:paragraph -->\n";
    $content .= "\t<p>".$description."</p>\n";
    $content .= "\t<!-- /wp:paragraph -->\n";
    $content .= "</div>\n";
    $content .= "<!-- /wp:group -->\n";

    return $content;
}

/**
 * Get registered block types from WordPress
 */
function getRegisteredBlockTypes()
{
    $coreBlocks = ct_get_core_blocks_from_wordpress();

    // Fallback blocks in case WordPress functions are not available
    $fallbackBlocks = ct_get_fallback_core_blocks();

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

    if (! empty($coreBlocks)) {
        $coreBlocks[] = 'custom-block';

        return $coreBlocks;
    }

    // Add option for custom block to fallback
    $fallbackBlocks[] = 'custom-block';

    return $fallbackBlocks;
}
