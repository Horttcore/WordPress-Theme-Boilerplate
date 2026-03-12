#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

/**
 * Validate SVG content
 */
function validateSvg($svg): bool
{
    $svg = trim((string) $svg);

    if (empty($svg)) {
        return false;
    }

    // Check for SVG tag
    if (! preg_match('/<svg/i', $svg)) {
        return false;
    }

    // Try to load as XML to validate structure
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $success = $dom->loadXML($svg);
    libxml_use_internal_errors(false);

    return $success !== false;
}

/**
 * Convert SVG to data URI with proper encoding
 */
function svgToDataUri($svg): string
{
    $svg = trim((string) $svg);

    // Ensure SVG has xmlns if not present
    if (! preg_match('/xmlns\s*=/i', $svg)) {
        $svg = preg_replace(
            '/<svg/i',
            '<svg xmlns="http://www.w3.org/2000/svg"',
            $svg,
            1
        );
    }

    // URL encode the SVG, but keep it readable
    // Only encode necessary characters
    $encoded = $svg;
    $encoded = str_replace(['"', '#', '%'], ['\'', '%23', '%25'], $encoded);
    $encoded = str_replace(['<', '>'], ['%3C', '%3E'], $encoded);
    $encoded = str_replace(' ', '%20', $encoded);

    return 'data:image/svg+xml;utf8,'.$encoded;
}

/**
 * Generate CSS output
 */
function generateCssOutput($dataUri): string
{
    $css = <<<'CSS'
/* SVG Mask Image */
mask-image: url('{dataUri}');
mask-size: contain;
mask-repeat: no-repeat;
mask-position: center;

/* Usage Example */
.element {
  background-color: currentColor;
  width: 24px; /* adjust size as needed */
  height: 24px;
  mask-image: url('{dataUri}');
  mask-size: contain;
  mask-repeat: no-repeat;
  mask-position: center;
}
CSS;

    return str_replace('{dataUri}', $dataUri, $css);
}

// Get SVG input
$svgInput = text(
    'Paste your SVG code',
    'Example: <svg xmlns="http://www.w3.org/2000/svg">...</svg>',
    '',
    true
);

// Validate SVG
if (! validateSvg($svgInput)) {
    error('Invalid SVG format');
    exit(1);
}

// Generate data URI
$dataUri = svgToDataUri($svgInput);

// Generate CSS
$css = generateCssOutput($dataUri);

// Display output
echo "\n";
info('CSS Mask Image Generated:');
echo "\n";
echo $css;
echo "\n\n";
info('Copy the CSS code above to use in your stylesheet.');
info('Change background-color to any color or use currentColor for flexible styling.');
