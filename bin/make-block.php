#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use function Laravel\Prompts\text;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\multiselect;

// Get the namespace and block name using Laravel Prompts
$namespaceBlock = text('Enter namespace/block', 'e.g. core/button', '', true, function ($value) {
    if (strpos($value, '/') === false) {
        return 'Input must be in the format "namespace/block"';
    }
    return null;
});

// Split the input into namespace and block
list($namespace, $block) = explode('/', $namespaceBlock, 2);

// Define block features that can be supported
$blockFeatures = [
    // Structure & UI
    'anchor' => 'Structure & UI: HTML anchor support',
    'align' => 'Structure & UI: Alignment options (also as array of allowed values)',
    'alignWide' => 'Structure & UI: Wide alignment support',
    'ariaLabel' => 'Structure & UI: ARIA label support',
    'className' => 'Structure & UI: Custom CSS class name',
    'customClassName' => 'Structure & UI: Custom CSS class name input field',
    'html' => 'Structure & UI: Allow editing HTML',
    'inserter' => 'Structure & UI: Show in inserter/Style Book',
    'lock' => 'Structure & UI: Show/hide locking UI',
    'multiple' => 'Structure & UI: Allow multiple instances',
    'renaming' => 'Structure & UI: Allow block to be renamed',
    'reusable' => 'Structure & UI: Allow converting to reusable',
    'splitting' => 'Structure & UI: Enter splits text blocks',

    // Layout & Position
    'layout' => 'Layout & Position: Layout controls',
    'position.sticky' => 'Layout & Position: Sticky positioning',

    // Visual styles
    'background' => 'Visual styles: Background settings',
    'background.backgroundImage' => 'Visual styles: Background image support',
    'background.backgroundSize' => 'Visual styles: Background size (adds FocalPoint/size UI)',
    'color' => 'Visual styles: Color settings',
    'color.background' => 'Visual styles: Background color',
    'color.text' => 'Visual styles: Text color',
    'color.link' => 'Visual styles: Link color',
    'color.gradients' => 'Visual styles: Gradient support',
    'color.heading' => 'Visual styles: Heading color',
    'color.button' => 'Visual styles: Button color',
    'color.enableContrastChecker' => 'Visual styles: Enable contrast checker',
    'dimensions' => 'Visual styles: Dimension controls',
    'dimensions.aspectRatio' => 'Visual styles: Aspect ratio control',
    'dimensions.minHeight' => 'Visual styles: Minimum height control',
    'filter' => 'Visual styles: Filter controls',
    'filter.duotone' => 'Visual styles: Duotone filter',
    'shadow' => 'Visual styles: Box-shadow picker',
    'spacing' => 'Visual styles: Spacing controls',
    'spacing.margin' => 'Visual styles: Margin controls',
    'spacing.padding' => 'Visual styles: Padding controls',
    'spacing.blockGap' => 'Visual styles: Block gap controls',
    'typography' => 'Visual styles: Typography controls',
    'typography.fontSize' => 'Visual styles: Font size control',
    'typography.lineHeight' => 'Visual styles: Line height control',
    'typography.textAlign' => 'Visual styles: Text alignment control',

    // Interactivity
    'interactivity' => 'Interactivity: Interactivity controls',
    'interactivity.clientNavigation' => 'Interactivity: Client-side navigation',
    'interactivity.interactive' => 'Interactivity: Interactive elements'
];

// Prompt for block features
$selectedFeatures = multiselect(
    'Select which features the block should support',
    $blockFeatures,
    [],
    5,
    false,
    null,
    'Use the space bar to select options.'
);

// Define paths
$blocksBaseDir = __DIR__ . '/../src/theme/blocks';
$namespaceDir = $blocksBaseDir . '/' . $namespace;
$destDir = $namespaceDir . '/' . $block;
$destFile = $destDir . '/' . $block . '.json';
$stubFile = __DIR__ . '/stubs/block.stub.json';

// Check if stub file exists
if (!file_exists($stubFile)) {
    error("Stub file not found: $stubFile");
    exit(1);
}

// Create directories if they don't exist
if (!is_dir($namespaceDir)) {
    mkdir($namespaceDir, 0755, true);
}

if (!is_dir($destDir)) {
    mkdir($destDir, 0755, true);
}

// Check if destination file already exists
if (file_exists($destFile)) {
    error("File already exists: $destFile");
    exit(1);
}

// Read stub file and replace placeholders
$content = file_get_contents($stubFile);
$content = str_replace('"namespace/block"', '"' . $namespace . '/' . $block . '"', $content);

// Add selected features to the block.json file if any were selected
if (!empty($selectedFeatures)) {
    // Parse the JSON content
    $jsonContent = json_decode($content, true);

    // Create the supports object
    $supports = [];
    foreach ($selectedFeatures as $feature) {
        // Handle nested features (e.g., 'color.background')
        if (strpos($feature, '.') !== false) {
            $parts = explode('.', $feature);
            $parent = $parts[0];
            $child = $parts[1];

            // Initialize parent if it doesn't exist
            if (!isset($supports[$parent])) {
                $supports[$parent] = [];
            }

            // If parent was previously set to true, convert it to an array
            if ($supports[$parent] === true) {
                $supports[$parent] = [];
            }

            // Set the child property
            $supports[$parent][$child] = true;
        } else {
            $supports[$feature] = true;
        }
    }

    // Add the supports object to the settings section
    if (isset($jsonContent['settings']['blocks'][$namespace . '/' . $block])) {
        $jsonContent['settings']['blocks'][$namespace . '/' . $block]['supports'] = $supports;
    }

    // Convert back to JSON with proper formatting
    $content = json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

// Write to destination file
file_put_contents($destFile, $content);
info("✅ Created $destFile");
