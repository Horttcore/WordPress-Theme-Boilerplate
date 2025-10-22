#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;

// Get the block title using Laravel Prompts
$title = text('Enter block title', 'e.g. My Custom Block', '', true);

// Convert title to kebab case for slug
$slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', trim($title)));
$slug = trim($slug, '-');

// Ask if user wants to create a dynamic block
$isVariantDynamic = confirm('Create a dynamic block?', false);

// Read theme name from package.json for dynamic namespace
$packageJsonPath = __DIR__ . '/../package.json';
$packageData = json_decode(file_get_contents($packageJsonPath), true);
$themeName = $packageData['name'] ?? 'default-theme';

// Set target directory to src/blocks/$slug (without namespace)
$targetDirArg = ' --target-dir ' . escapeshellarg($slug);

// Set namespace to theme name (dynamic)
$namespaceArg = ' --namespace ' . escapeshellarg($themeName);

// Use the title we already collected
$titleArg = ' --title ' . escapeshellarg($title);

// Short description (optional)
$description = text('Enter short description (optional)', 'Brief description of the block');
$descriptionArg = '';
if (!empty($description)) {
    $descriptionArg = ' --short-description ' . escapeshellarg($description);
}

// Category selection with autocomplete
$categories = [
    'text',
    'media',
    'design',
    'widgets',
    'theme',
    'embed',
];

$category = suggest(
    'Enter block category',
    $categories,
    'Start typing to search...'
);
$categoryArg = ' --category ' . escapeshellarg($category);


// Build the complete command with all arguments
$command = sprintf('npx @wordpress/create-block@latest %s --no-plugin --textdomain %s', escapeshellarg($slug), escapeshellarg($themeName));

// Add all optional arguments
$command .= $targetDirArg;
$command .= $namespaceArg;
$command .= $titleArg;
$command .= $descriptionArg;
$command .= $categoryArg;

// Add variant flag if dynamic block is requested
if ($isVariantDynamic) {
    $command .= ' --variant dynamic';
}

info("Executing: $command");

// Change to src/blocks directory before executing the command
$blocksDir = __DIR__ . '/../src/blocks';
$currentDir = getcwd();
chdir($blocksDir);

// Execute the command with real-time output
$returnVar = 0;
passthru($command, $returnVar);

// Change back to original directory
chdir($currentDir);

// Check if command was successful
if ($returnVar === 0) {
    info("✅ Block '$slug' created successfully with @wordpress/create-block");
} else {
    error("Failed to create block with @wordpress/create-block (exit code: $returnVar)");
    exit(1);
}
