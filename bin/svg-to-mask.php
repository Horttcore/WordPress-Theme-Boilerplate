#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\textarea;

/**
 * Validate SVG content
 */
function validateSvg($svg): bool
{
    $svg = mb_trim((string) $svg);

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
    $svg = mb_trim((string) $svg);

    // Ensure SVG has xmlns if not present
    if (! preg_match('/xmlns\s*=/', $svg)) {
        $svg = preg_replace(
            '/<svg/i',
            '<svg xmlns="http://www.w3.org/2000/svg"',
            $svg,
            1
        );
    }

    // Minimal Encoding für CSS-kompatible Data-URIs
    // Zeilenumbrüche entfernen
    $svg = str_replace(["\r", "\n"], '', $svg);
    // Überflüssige Whitespaces am Anfang/Ende entfernen
    $svg = mb_trim($svg);
    // Doppelte Anführungszeichen durch einfache ersetzen
    $svg = str_replace('"', "'", $svg);

    return 'data:image/svg+xml;utf8,'.$svg;
}

/**
 * Generate CSS output
 */
function generateCssOutput($dataUri): string
{
    $css = <<<CSS
    mask-image: url("{$dataUri}");
    mask-size: contain;
    mask-repeat: no-repeat;
    mask-position: center;
    CSS;

    return $css;
}

// Get SVG input
$svgInput = textarea(
    'Paste your SVG code',
    'Example: <svg xmlns="http://www.w3.org/2000/svg">...</svg>'
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
