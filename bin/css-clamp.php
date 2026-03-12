#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use function Laravel\Prompts\text;

/**
 * Convert pixels to rem (assuming 16px base)
 *
 * @param  float  $px  Pixel value
 * @param  float  $baseSize  Base font size in pixels (default 16px)
 * @return float Rem value
 */
function pxToRem($px, $baseSize = 16): float
{
    return round(($px / $baseSize) * 100) / 100;
}

/**
 * Calculate the CSS clamp value based on min/max viewport widths and min/max values
 *
 * @param  float  $minViewport  Minimum viewport width in pixels
 * @param  float  $maxViewport  Maximum viewport width in pixels
 * @param  float  $minValue  Minimum value
 * @param  float  $maxValue  Maximum value
 * @param  string  $unit  Unit to use (px or rem)
 * @param  float  $baseSize  Base font size for rem conversion
 * @return string The calculated CSS clamp function
 */
function calculateClamp($minViewport, $maxViewport, $minValue, $maxValue, $unit = 'px', $baseSize = 16): string
{
    // Convert to rem if needed
    if ($unit === 'rem') {
        $minValue = pxToRem($minValue, $baseSize);
        $maxValue = pxToRem($maxValue, $baseSize);
    }

    // Calculate the slope
    $slope = ($maxValue - $minValue) / ($maxViewport - $minViewport);

    // Calculate the y-intercept (b in y = mx + b)
    $yIntercept = $minValue - $slope * $minViewport;

    // Format the preferred value (the linear equation)
    $preferredValue = number_format($yIntercept, 4, '.', '').$unit.' + '.number_format($slope * 100, 4, '.', '').'vw';

    // Return the clamp function
    return "clamp({$minValue}{$unit}, {$preferredValue}, {$maxValue}{$unit})";
}

// WordPress default values
$defaultMinViewport = '320'; // Mobile
$defaultMaxViewport = '1920'; // Desktop

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
    'e.g., 16 for 16px or 1 for 1rem',
    '',
    true
);

$maxValue = text(
    'Enter maximum value (px)',
    'e.g., 24 for 24px or 1.5 for 1.5rem',
    '',
    true
);

// Convert inputs to numbers
$minViewport = (float) $minViewport;
$maxViewport = (float) $maxViewport;
$minValue = (float) $minValue;
$maxValue = (float) $maxValue;

// Calculate the clamp value in rem
$clampValue = calculateClamp($minViewport, $maxViewport, $minValue, $maxValue, 'rem');

// Display the result
echo "\n";
echo $clampValue;
echo "\n";
