#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use function Laravel\Prompts\text;
use function Laravel\Prompts\info;

/**
 * Calculate the CSS clamp value based on min/max viewport widths and min/max values
 *
 * @param float $minViewport Minimum viewport width in pixels
 * @param float $maxViewport Maximum viewport width in pixels
 * @param float $minValue Minimum value
 * @param float $maxValue Maximum value
 * @return string The calculated CSS clamp function
 */
function calculateClamp($minViewport, $maxViewport, $minValue, $maxValue) {
    // Calculate the slope
    $slope = ($maxValue - $minValue) / ($maxViewport - $minViewport);

    // Calculate the y-intercept (b in y = mx + b)
    $yIntercept = $minValue - $slope * $minViewport;

    // Format the preferred value (the linear equation)
    $preferredValue = $yIntercept . 'px + ' . ($slope * 100) . 'vw';

    // Return the clamp function
    return "clamp({$minValue}px, {$preferredValue}, {$maxValue}px)";
}

// WordPress default values
$defaultMinViewport = 320; // Mobile
$defaultMaxViewport = 1920; // Desktop

// Get user input with WordPress defaults
$minViewport = text(
    'Enter minimum viewport width (px)',
    'Default: 320px (mobile)',
    $defaultMinViewport,
    true
);

$maxViewport = text(
    'Enter maximum viewport width (px)',
    'Default: 1920px (desktop)',
    $defaultMaxViewport,
    true
);

$minValue = text(
    'Enter minimum value (px)',
    'e.g., 16px for font-size',
    '',
    true
);

$maxValue = text(
    'Enter maximum value (px)',
    'e.g., 24px for font-size',
    '',
    true
);

// Convert inputs to numbers
$minViewport = (float) $minViewport;
$maxViewport = (float) $maxViewport;
$minValue = (float) $minValue;
$maxValue = (float) $maxValue;

// Calculate the clamp value
$clampValue = calculateClamp($minViewport, $maxViewport, $minValue, $maxValue);

// Display the result
info("CSS clamp value: {$clampValue}");
info("Usage example: font-size: {$clampValue};");
