#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/helpers.php';

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\multisearch;
use function Laravel\Prompts\text;
use function Laravel\Prompts\textarea;

// Starter content name
$title = text('Enter starter content name', 'e.g. Business homepage', '', true);

// Description (optional)
$description = text('Enter description (optional)', 'A short description for this starter content', '');

// Slug for filename
$slug = mb_strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', trim($title)));
$slug = trim($slug, '-');

// Post types (multi-select)
$postTypes = ct_get_registered_post_types();
$selectedPostTypes = [];
while (empty($selectedPostTypes)) {
    $selectedPostTypes = multisearch(
        'Select post types for this starter content',
        function (string $value) use ($postTypes) {
            return array_values(array_filter(
                $postTypes,
                fn($postType) => str_contains(mb_strtolower($postType), mb_strtolower($value))
            ));
        },
        'Start typing to search post types...'
    );

    if (empty($selectedPostTypes)) {
        error('Please select at least one post type.');
    }
}

// Optional content
$content = textarea(
    'Enter starter content (optional)',
    'Paste block markup here. Leave empty to generate a basic structure.'
);

// Generate content
$patternContent = generateStarterContentPattern($title, $description, $slug, $selectedPostTypes, $content);

// Target path
$targetFile = __DIR__ . '/../patterns/' . $slug . '.php';

// Check if file already exists
if (file_exists($targetFile)) {
    $overwrite = confirm("Pattern file '$slug.php' already exists. Overwrite?", false);
    if (!$overwrite) {
        info('Starter content creation cancelled.');
        exit(0);
    }
}

// Write file
if (file_put_contents($targetFile, $patternContent) !== false) {
    info("✅ Starter content pattern '$slug.php' created successfully!");
    info("📁 Location: patterns/$slug.php");
} else {
    error('❌ Failed to create starter content pattern file.');
    exit(1);
}

/**
 * Build starter content pattern content
 */
function generateStarterContentPattern(string $title, string $description, string $slug, array $postTypes, string $content): string
{
    $content = trim($content);

    $pattern = "<?php\n";
    $pattern .= "/**\n";
    $pattern .= ' * Title: ' . $title . "\n";
    $pattern .= ' * Slug: ' . ct_get_current_theme_textdomain() . '/' . $slug . "\n";
    if (!empty($description)) {
        $pattern .= ' * Description: ' . $description . "\n";
    }
    $pattern .= ' * Keywords: starter' . "\n";
    $pattern .= ' * Block Types: core/post-content' . "\n";
    $pattern .= ' * Post Types: ' . implode(', ', $postTypes) . "\n";
    $pattern .= ' * Viewport width: 1400' . "\n";
    $pattern .= " */\n";
    $pattern .= "?>\n\n";

    if ($content === '') {
        $pattern .= "<!-- wp:group -->\n";
        $pattern .= "<div class=\"wp-block-group\">\n";
        $pattern .= "\t<!-- wp:heading -->\n";
        $pattern .= "\t<h2 class=\"wp-block-heading\">" . $title . "</h2>\n";
        $pattern .= "\t<!-- /wp:heading -->\n";
        $pattern .= "</div>\n";
        $pattern .= "<!-- /wp:group -->\n";
    } else {
        $pattern .= $content . "\n";
    }

    return $pattern;
}
