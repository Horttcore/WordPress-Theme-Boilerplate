#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/helpers.php';

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;

// Title
$title = text('Enter query loop title', 'e.g. List of posts, 1 column', '', true);

// Slug
$slug = mb_strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', trim($title)));
$slug = trim($slug, '-');
$slug = 'query-loop-' . $slug;

// Description (optional)
$description = text('Enter description (optional)', 'A short description for this query loop pattern', '');

// Post type
$postTypes = ct_get_registered_post_types();
$postType = suggest(
    'Select post type',
    $postTypes,
    'Start typing to search post types...'
);
if (empty($postType)) {
    $postType = 'post';
}

// Posts per page
$perPageInput = text('Posts per page', '3', '3');
$perPage = (int)$perPageInput;
if ($perPage <= 0) {
    $perPage = 3;
}

// Options
$includeFeaturedImage = confirm('Include featured image?', true);
$includeExcerpt = confirm('Include excerpt?', true);
$includePagination = confirm('Include pagination?', true);

// Build pattern content
$patternContent = generateQueryLoopPattern(
    $title,
    $description,
    $slug,
    $postType,
    $perPage,
    $includeFeaturedImage,
    $includeExcerpt,
    $includePagination
);

// Target path
$targetFile = __DIR__ . '/../patterns/' . $slug . '.php';

// Check if file already exists
if (file_exists($targetFile)) {
    $overwrite = confirm("Pattern file '$slug.php' already exists. Overwrite?", false);
    if (!$overwrite) {
        info('Query loop creation cancelled.');
        exit(0);
    }
}

// Write file
if (file_put_contents($targetFile, $patternContent) !== false) {
    info("✅ Query loop pattern '$slug.php' created successfully!");
    info("📁 Location: patterns/$slug.php");
} else {
    error('❌ Failed to create query loop pattern file.');
    exit(1);
}

/**
 * Build query loop pattern content
 */
function generateQueryLoopPattern(
    string $title,
    string $description,
    string $slug,
    string $postType,
    int $perPage,
    bool $includeFeaturedImage,
    bool $includeExcerpt,
    bool $includePagination
): string {
    $pattern = "<?php\n";
    $pattern .= "/**\n";
    $pattern .= ' * Title: ' . $title . "\n";
    $pattern .= ' * Slug: ' . ct_get_current_theme_textdomain() . '/' . $slug . "\n";
    $pattern .= ' * Categories: query' . "\n";
    $pattern .= ' * Block Types: core/query' . "\n";
    if (!empty($description)) {
        $pattern .= ' * Description: ' . $description . "\n";
    }
    $pattern .= " */\n";
    $pattern .= "?>\n\n";

    $pattern .= '<!-- wp:query {"query":{"perPage":' . $perPage . ',"pages":0,"offset":0,"postType":"' . $postType . '","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[]},"align":"full","layout":{"type":"default"}} -->' . "\n";
    $pattern .= '<div class="wp-block-query alignfull">' . "\n";
    $pattern .= "\t<!-- wp:post-template {\"align\":\"full\",\"layout\":{\"type\":\"default\"}} -->\n";
    $pattern .= "\t\t<!-- wp:group {\"align\":\"full\",\"layout\":{\"type\":\"constrained\"}} -->\n";
    $pattern .= "\t\t<div class=\"wp-block-group alignfull\">\n";

    if ($includeFeaturedImage) {
        $pattern .= "\t\t\t<!-- wp:post-featured-image {\"isLink\":true,\"aspectRatio\":\"3/2\"} /-->\n";
    }

    $pattern .= "\t\t\t<!-- wp:post-title {\"isLink\":true} /-->\n";

    if ($includeExcerpt) {
        $pattern .= "\t\t\t<!-- wp:post-excerpt /-->\n";
    }

    $pattern .= "\t\t\t<!-- wp:post-date {\"isLink\":true} /-->\n";
    $pattern .= "\t\t</div>\n";
    $pattern .= "\t\t<!-- /wp:group -->\n";
    $pattern .= "\t<!-- /wp:post-template -->\n";

    if ($includePagination) {
        $pattern .= "\t<!-- wp:query-pagination {\"paginationArrow\":\"arrow\",\"align\":\"wide\",\"layout\":{\"type\":\"flex\",\"justifyContent\":\"space-between\"}} -->\n";
        $pattern .= "\t\t<!-- wp:query-pagination-previous /-->\n";
        $pattern .= "\t\t<!-- wp:query-pagination-numbers /-->\n";
        $pattern .= "\t\t<!-- wp:query-pagination-next /-->\n";
        $pattern .= "\t<!-- /wp:query-pagination -->\n";
    }

    $pattern .= "\t<!-- wp:query-no-results -->\n";
    $pattern .= "\t\t<!-- wp:paragraph -->\n";
    $pattern .= "\t\t<p>No posts found.</p>\n";
    $pattern .= "\t\t<!-- /wp:paragraph -->\n";
    $pattern .= "\t<!-- /wp:query-no-results -->\n";

    $pattern .= "</div>\n";
    $pattern .= "<!-- /wp:query -->\n";

    return $pattern;
}
