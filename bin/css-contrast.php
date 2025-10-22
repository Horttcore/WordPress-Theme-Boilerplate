#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use function Laravel\Prompts\text;
use function Laravel\Prompts\info;
use function Laravel\Prompts\error;

/**
 * CSS Contrast Checker - Calculate contrast ratios and accessibility compliance
 */

// Named colors mapping (CSS3 standard colors)
$namedColors = [
    'aliceblue' => '#f0f8ff',
    'antiquewhite' => '#faebd7',
    'aqua' => '#00ffff',
    'aquamarine' => '#7fffd4',
    'azure' => '#f0ffff',
    'beige' => '#f5f5dc',
    'bisque' => '#ffe4c4',
    'black' => '#000000',
    'blanchedalmond' => '#ffebcd',
    'blue' => '#0000ff',
    'blueviolet' => '#8a2be2',
    'brown' => '#a52a2a',
    'burlywood' => '#deb887',
    'cadetblue' => '#5f9ea0',
    'chartreuse' => '#7fff00',
    'chocolate' => '#d2691e',
    'coral' => '#ff7f50',
    'cornflowerblue' => '#6495ed',
    'cornsilk' => '#fff8dc',
    'crimson' => '#dc143c',
    'cyan' => '#00ffff',
    'darkblue' => '#00008b',
    'darkcyan' => '#008b8b',
    'darkgoldenrod' => '#b8860b',
    'darkgray' => '#a9a9a9',
    'darkgreen' => '#006400',
    'darkkhaki' => '#bdb76b',
    'darkmagenta' => '#8b008b',
    'darkolivegreen' => '#556b2f',
    'darkorange' => '#ff8c00',
    'darkorchid' => '#9932cc',
    'darkred' => '#8b0000',
    'darksalmon' => '#e9967a',
    'darkseagreen' => '#8fbc8f',
    'darkslateblue' => '#483d8b',
    'darkslategray' => '#2f4f4f',
    'darkturquoise' => '#00ced1',
    'darkviolet' => '#9400d3',
    'deeppink' => '#ff1493',
    'deepskyblue' => '#00bfff',
    'dimgray' => '#696969',
    'dodgerblue' => '#1e90ff',
    'firebrick' => '#b22222',
    'floralwhite' => '#fffaf0',
    'forestgreen' => '#228b22',
    'fuchsia' => '#ff00ff',
    'gainsboro' => '#dcdcdc',
    'ghostwhite' => '#f8f8ff',
    'gold' => '#ffd700',
    'goldenrod' => '#daa520',
    'gray' => '#808080',
    'green' => '#008000',
    'greenyellow' => '#adff2f',
    'honeydew' => '#f0fff0',
    'hotpink' => '#ff69b4',
    'indianred' => '#cd5c5c',
    'indigo' => '#4b0082',
    'ivory' => '#fffff0',
    'khaki' => '#f0e68c',
    'lavender' => '#e6e6fa',
    'lavenderblush' => '#fff0f5',
    'lawngreen' => '#7cfc00',
    'lemonchiffon' => '#fffacd',
    'lightblue' => '#add8e6',
    'lightcoral' => '#f08080',
    'lightcyan' => '#e0ffff',
    'lightgoldenrodyellow' => '#fafad2',
    'lightgray' => '#d3d3d3',
    'lightgreen' => '#90ee90',
    'lightpink' => '#ffb6c1',
    'lightsalmon' => '#ffa07a',
    'lightseagreen' => '#20b2aa',
    'lightskyblue' => '#87cefa',
    'lightslategray' => '#778899',
    'lightsteelblue' => '#b0c4de',
    'lightyellow' => '#ffffe0',
    'lime' => '#00ff00',
    'limegreen' => '#32cd32',
    'linen' => '#faf0e6',
    'magenta' => '#ff00ff',
    'maroon' => '#800000',
    'mediumaquamarine' => '#66cdaa',
    'mediumblue' => '#0000cd',
    'mediumorchid' => '#ba55d3',
    'mediumpurple' => '#9370db',
    'mediumseagreen' => '#3cb371',
    'mediumslateblue' => '#7b68ee',
    'mediumspringgreen' => '#00fa9a',
    'mediumturquoise' => '#48d1cc',
    'mediumvioletred' => '#c71585',
    'midnightblue' => '#191970',
    'mintcream' => '#f5fffa',
    'mistyrose' => '#ffe4e1',
    'moccasin' => '#ffe4b5',
    'navajowhite' => '#ffdead',
    'navy' => '#000080',
    'oldlace' => '#fdf5e6',
    'olive' => '#808000',
    'olivedrab' => '#6b8e23',
    'orange' => '#ffa500',
    'orangered' => '#ff4500',
    'orchid' => '#da70d6',
    'palegoldenrod' => '#eee8aa',
    'palegreen' => '#98fb98',
    'paleturquoise' => '#afeeee',
    'palevioletred' => '#db7093',
    'papayawhip' => '#ffefd5',
    'peachpuff' => '#ffdab9',
    'peru' => '#cd853f',
    'pink' => '#ffc0cb',
    'plum' => '#dda0dd',
    'powderblue' => '#b0e0e6',
    'purple' => '#800080',
    'red' => '#ff0000',
    'rosybrown' => '#bc8f8f',
    'royalblue' => '#4169e1',
    'saddlebrown' => '#8b4513',
    'salmon' => '#fa8072',
    'sandybrown' => '#f4a460',
    'seagreen' => '#2e8b57',
    'seashell' => '#fff5ee',
    'sienna' => '#a0522d',
    'silver' => '#c0c0c0',
    'skyblue' => '#87ceeb',
    'slateblue' => '#6a5acd',
    'slategray' => '#708090',
    'snow' => '#fffafa',
    'springgreen' => '#00ff7f',
    'steelblue' => '#4682b4',
    'tan' => '#d2b48c',
    'teal' => '#008080',
    'thistle' => '#d8bfd8',
    'tomato' => '#ff6347',
    'turquoise' => '#40e0d0',
    'violet' => '#ee82ee',
    'wheat' => '#f5deb3',
    'white' => '#ffffff',
    'whitesmoke' => '#f5f5f5',
    'yellow' => '#ffff00',
    'yellowgreen' => '#9acd32'
];

/**
 * Parse color input and convert to RGB values
 */
function parseColor($color, $namedColors) {
    $color = trim(strtolower((string) $color));

    // Named colors
    if (isset($namedColors[$color])) {
        $color = $namedColors[$color];
    }

    // Hex colors
    if (preg_match('/^#([a-f0-9]{3}|[a-f0-9]{6})$/i', $color)) {
        return hexToRgb($color);
    }

    // RGB/RGBA colors
    if (preg_match('/^rgba?\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*(?:,\s*([\d.]+))?\s*\)$/i', $color, $matches)) {
        return [
            'r' => (int)$matches[1],
            'g' => (int)$matches[2],
            'b' => (int)$matches[3],
            'a' => isset($matches[4]) ? (float)$matches[4] : 1
        ];
    }

    // HSL/HSLA colors
    if (preg_match('/^hsla?\(\s*(\d+)\s*,\s*(\d+)%\s*,\s*(\d+)%\s*(?:,\s*([\d.]+))?\s*\)$/i', $color, $matches)) {
        $hsl = [
            'h' => (int)$matches[1],
            's' => (int)$matches[2],
            'l' => (int)$matches[3],
            'a' => isset($matches[4]) ? (float)$matches[4] : 1
        ];
        return hslToRgb($hsl['h'], $hsl['s'], $hsl['l'], $hsl['a']);
    }

    return false;
}

/**
 * Convert hex to RGB
 */
function hexToRgb($hex) {
    $hex = ltrim((string) $hex, '#');

    if (strlen($hex) == 3) {
        $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    }

    return [
        'r' => hexdec(substr($hex, 0, 2)),
        'g' => hexdec(substr($hex, 2, 2)),
        'b' => hexdec(substr($hex, 4, 2)),
        'a' => 1
    ];
}

/**
 * Convert HSL to RGB
 */
function hslToRgb($h, $s, $l, $a = 1) {
    $h /= 360;
    $s /= 100;
    $l /= 100;

    if ($s == 0) {
        $r = $g = $b = $l;
    } else {
        $hue2rgb = function($p, $q, $t) {
            if ($t < 0) $t += 1;
            if ($t > 1) $t -= 1;
            if ($t < 1/6) return $p + ($q - $p) * 6 * $t;
            if ($t < 1/2) return $q;
            if ($t < 2/3) return $p + ($q - $p) * (2/3 - $t) * 6;
            return $p;
        };

        $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
        $p = 2 * $l - $q;

        $r = $hue2rgb($p, $q, $h + 1/3);
        $g = $hue2rgb($p, $q, $h);
        $b = $hue2rgb($p, $q, $h - 1/3);
    }

    return [
        'r' => round($r * 255),
        'g' => round($g * 255),
        'b' => round($b * 255),
        'a' => $a
    ];
}

/**
 * Calculate relative luminance of a color (WCAG 2.1 formula)
 */
function calculateRelativeLuminance($r, $g, $b) {
    // Convert RGB values to sRGB
    $rsRGB = $r / 255;
    $gsRGB = $g / 255;
    $bsRGB = $b / 255;

    // Apply gamma correction
    $rLinear = $rsRGB <= 0.03928 ? $rsRGB / 12.92 : (($rsRGB + 0.055) / 1.055) ** 2.4;
    $gLinear = $gsRGB <= 0.03928 ? $gsRGB / 12.92 : (($gsRGB + 0.055) / 1.055) ** 2.4;
    $bLinear = $bsRGB <= 0.03928 ? $bsRGB / 12.92 : (($bsRGB + 0.055) / 1.055) ** 2.4;

    // Calculate luminance using WCAG coefficients
    return 0.2126 * $rLinear + 0.7152 * $gLinear + 0.0722 * $bLinear;
}

/**
 * Calculate contrast ratio between two colors (WCAG 2.1 formula)
 */
function calculateContrastRatio($rgb1, $rgb2) {
    $luminance1 = calculateRelativeLuminance($rgb1['r'], $rgb1['g'], $rgb1['b']);
    $luminance2 = calculateRelativeLuminance($rgb2['r'], $rgb2['g'], $rgb2['b']);

    // Ensure lighter color is in numerator
    $lighter = max($luminance1, $luminance2);
    $darker = min($luminance1, $luminance2);

    return ($lighter + 0.05) / ($darker + 0.05);
}

/**
 * Get accessibility compliance status based on contrast ratio
 */
function getAccessibilityStatus($contrastRatio): array {
    $status = [];

    // WCAG 2.1 AA Standards
    $status['AA_normal'] = $contrastRatio >= 4.5;
    $status['AA_large'] = $contrastRatio >= 3.0;

    // WCAG 2.1 AAA Standards
    $status['AAA_normal'] = $contrastRatio >= 7.0;
    $status['AAA_large'] = $contrastRatio >= 4.5;

    return $status;
}

// Get color inputs from command line arguments or interactive prompt
if ($argc > 2) {
    // Use command line arguments for both colors
    $colorInput1 = $argv[1];
    $colorInput2 = $argv[2];
} elseif ($argc > 1) {
    // One color provided via command line, prompt for the second
    $colorInput1 = $argv[1];
    $colorInput2 = text(
        'Enter the background color',
        'Examples: #ff0000, rgb(255,0,0), hsl(0,100%,50%), red',
        '',
        true
    );
} else {
    // Fall back to interactive prompts for both colors
    $colorInput1 = text(
        'Enter the foreground color',
        'Examples: #ff0000, rgb(255,0,0), hsl(0,100%,50%), red',
        '',
        true
    );
    $colorInput2 = text(
        'Enter the background color',
        'Examples: #ffffff, rgb(255,255,255), hsl(0,0%,100%), white',
        '',
        true
    );
}

// Parse both colors
$rgb1 = parseColor($colorInput1, $namedColors);
$rgb2 = parseColor($colorInput2, $namedColors);

if ($rgb1 === false) {
    error("Invalid color format for foreground color: $colorInput1");
    exit(1);
}

if ($rgb2 === false) {
    error("Invalid color format for background color: $colorInput2");
    exit(1);
}

// Calculate contrast ratio and accessibility status
$contrastRatio = calculateContrastRatio($rgb1, $rgb2);
$accessibilityStatus = getAccessibilityStatus($contrastRatio);

// Display contrast ratio and accessibility information in compact format
$ratio = number_format($contrastRatio, 2) . ":1";
$aa_normal = $accessibilityStatus['AA_normal'] ? "✅" : "❌";
$aa_large = $accessibilityStatus['AA_large'] ? "✅" : "❌";
$aaa_normal = $accessibilityStatus['AAA_normal'] ? "✅" : "❌";
$aaa_large = $accessibilityStatus['AAA_large'] ? "✅" : "❌";

info("$colorInput1 vs $colorInput2 → Ratio: $ratio | AA: $aa_normal Normal $aa_large Large | AAA: $aaa_normal Normal $aaa_large Large");
