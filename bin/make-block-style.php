#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;

/**
 * Slugify a string
 *
 * @param string $str The string to slugify
 * @return string The slugified string
 */
function slugify($str)
{
    $str = strtolower($str);
    $str = preg_replace('/\s+/', '-', $str);
    $str = preg_replace('/[^\w\-]+/', '', (string)$str);
    $str = preg_replace('/\-\-+/', '-', (string)$str);
    $str = trim((string)$str, '-');
    return $str;
}

/**
 * Get available blocks from the project
 *
 * @return array List of available blocks in namespace/block format
 */
function getAvailableBlocks(): array
{
    $blocksBaseDir = __DIR__ . '/../src/theme/blocks';
    $blocks = [];

    // Theme Blocks
    $themeBlocks = [
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

    // Add theme blocks to the list
    $blocks = array_merge($blocks, $themeBlocks);

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

// Get the namespace and block name using Laravel Prompts with autocomplete
$namespaceBlock = suggest(
    'Enter namespace/block',
    getAvailableBlocks(),
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

// Get the style name
$styleName = text('Enter Style Name', 'e.g. Rounded Corners', '', true);

// Split the input into namespace and block
[$namespace, $block] = explode('/', $namespaceBlock, 2);
$slug = slugify($styleName);

// Define paths
$blocksBaseDir = __DIR__ . '/../src/theme/blocks';
$blockDir = $blocksBaseDir . '/' . $namespace . '/' . $block;
$destFile = $blockDir . '/' . $block . '.' . $slug . '.json';
$stubFile = __DIR__ . '/stubs/block-style.stub.json';

// Check if stub file exists
if (!file_exists($stubFile)) {
    error("Stub file not found: $stubFile");
    exit(1);
}

// Create directories if they don't exist
if (!is_dir($blockDir)) {
    mkdir($blockDir, 0755, true);
}

// Check if destination file already exists
if (file_exists($destFile)) {
    error("File already exists: $destFile");
    exit(1);
}

// Read stub file and replace placeholders
$content = file_get_contents($stubFile);
$content = str_replace('namespace/block', $namespace . '/' . $block, $content);
$content = preg_replace('/"title":\s*"[^"]*"/', '"title": "' . $styleName . '"', $content);
$content = preg_replace('/"slug":\s*"[^"]*"/', '"slug": "' . $slug . '"', (string)$content);

// Write to destination file
file_put_contents($destFile, $content);
info("✅ Created $destFile");
