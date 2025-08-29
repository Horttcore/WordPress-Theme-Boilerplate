#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use function Laravel\Prompts\text;
use function Laravel\Prompts\info;
use function Laravel\Prompts\error;

/**
 * CSS Color Converter - Convert between different CSS color formats
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
    $color = trim(strtolower($color));

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

    // OKLCH colors
    if (preg_match('/^oklch\(\s*([\d.]+)\s+([\d.]+)\s+([\d.]+)(?:\s*\/\s*([\d.]+))?\s*\)$/i', $color, $matches)) {
        $oklch = [
            'l' => (float)$matches[1],
            'c' => (float)$matches[2],
            'h' => (float)$matches[3],
            'a' => isset($matches[4]) ? (float)$matches[4] : 1
        ];
        return oklchToRgb($oklch['l'], $oklch['c'], $oklch['h'], $oklch['a']);
    }

    return false;
}

/**
 * Convert hex to RGB
 */
function hexToRgb($hex) {
    $hex = ltrim($hex, '#');

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
 * Convert RGB to hex
 */
function rgbToHex($r, $g, $b) {
    return sprintf("#%02x%02x%02x", $r, $g, $b);
}

/**
 * Convert HSL to RGB
 */
function hslToRgb($h, $s, $l, $a = 1) {
    $h = $h / 360;
    $s = $s / 100;
    $l = $l / 100;

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
 * Convert OKLCH to RGB
 */
function oklchToRgb($l, $c, $h, $a = 1) {
    // Convert OKLCH to OKLab
    $hRad = deg2rad($h);
    $lab_a = $c * cos($hRad);
    $lab_b = $c * sin($hRad);

    // Convert OKLab to linear RGB
    $l_ = $l + 0.3963377774 * $lab_a + 0.2158037573 * $lab_b;
    $m_ = $l - 0.1055613458 * $lab_a - 0.0638541728 * $lab_b;
    $s_ = $l - 0.0894841775 * $lab_a - 1.2914855480 * $lab_b;

    $l = $l_ * $l_ * $l_;
    $m = $m_ * $m_ * $m_;
    $s = $s_ * $s_ * $s_;

    // Convert to linear RGB
    $r_linear = +4.0767416621 * $l - 3.3077115913 * $m + 0.2309699292 * $s;
    $g_linear = -1.2684380046 * $l + 2.6097574011 * $m - 0.3413193965 * $s;
    $b_linear = -0.0041960863 * $l - 0.7034186147 * $m + 1.7076147010 * $s;

    // Apply gamma correction
    $gammaCorrect = function($val) {
        return $val >= 0.0031308 ? 1.055 * pow($val, 1/2.4) - 0.055 : 12.92 * $val;
    };

    $r = $gammaCorrect($r_linear);
    $g = $gammaCorrect($g_linear);
    $b = $gammaCorrect($b_linear);

    // Clamp to [0,1] and convert to [0,255]
    $r = max(0, min(1, $r)) * 255;
    $g = max(0, min(1, $g)) * 255;
    $b = max(0, min(1, $b)) * 255;

    return [
        'r' => round($r),
        'g' => round($g),
        'b' => round($b),
        'a' => $a
    ];
}

/**
 * Convert RGB to OKLCH
 */
function rgbToOklch($r, $g, $b) {
    // Normalize RGB to [0,1]
    $r = $r / 255;
    $g = $g / 255;
    $b = $b / 255;

    // Apply inverse gamma correction
    $linearize = function($val) {
        return $val >= 0.04045 ? pow(($val + 0.055) / 1.055, 2.4) : $val / 12.92;
    };

    $r_linear = $linearize($r);
    $g_linear = $linearize($g);
    $b_linear = $linearize($b);

    // Convert to OKLab
    $l = 0.4122214708 * $r_linear + 0.5363325363 * $g_linear + 0.0514459929 * $b_linear;
    $m = 0.2119034982 * $r_linear + 0.6806995451 * $g_linear + 0.1073969566 * $b_linear;
    $s = 0.0883024619 * $r_linear + 0.2817188376 * $g_linear + 0.6299787005 * $b_linear;

    $l_ = pow($l, 1/3);
    $m_ = pow($m, 1/3);
    $s_ = pow($s, 1/3);

    $lab_l = 0.2104542553 * $l_ + 0.7936177850 * $m_ - 0.0040720468 * $s_;
    $lab_a = 1.9779984951 * $l_ - 2.4285922050 * $m_ + 0.4505937099 * $s_;
    $lab_b = 0.0259040371 * $l_ + 0.7827717662 * $m_ - 0.8086757660 * $s_;

    // Convert OKLab to OKLCH
    $c = sqrt($lab_a * $lab_a + $lab_b * $lab_b);
    $h = rad2deg(atan2($lab_b, $lab_a));
    if ($h < 0) $h += 360;

    return [
        'l' => round($lab_l, 3),
        'c' => round($c, 3),
        'h' => round($h, 1)
    ];
}

/**
 * Convert RGB to HSL
 */
function rgbToHsl($r, $g, $b) {
    $r /= 255;
    $g /= 255;
    $b /= 255;

    $max = max($r, $g, $b);
    $min = min($r, $g, $b);
    $l = ($max + $min) / 2;

    if ($max == $min) {
        $h = $s = 0;
    } else {
        $d = $max - $min;
        $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);

        switch ($max) {
            case $r:
                $h = ($g - $b) / $d + ($g < $b ? 6 : 0);
                break;
            case $g:
                $h = ($b - $r) / $d + 2;
                break;
            case $b:
                $h = ($r - $g) / $d + 4;
                break;
        }
        $h /= 6;
    }

    return [
        'h' => round($h * 360),
        's' => round($s * 100),
        'l' => round($l * 100)
    ];
}

/**
 * Find the closest named color
 */
function findClosestNamedColor($r, $g, $b, $namedColors) {
    $minDistance = PHP_INT_MAX;
    $closestColor = '';

    foreach ($namedColors as $name => $hex) {
        $namedRgb = hexToRgb($hex);
        $distance = sqrt(
            pow($r - $namedRgb['r'], 2) +
            pow($g - $namedRgb['g'], 2) +
            pow($b - $namedRgb['b'], 2)
        );

        if ($distance < $minDistance) {
            $minDistance = $distance;
            $closestColor = $name;
        }
    }

    return $closestColor;
}


// Get color input from command line arguments or interactive prompt
if ($argc > 1) {
    // Use command line argument
    $colorInput = $argv[1];
} else {
    // Fall back to interactive prompt
    $colorInput = text(
        'Enter a CSS color',
        'Examples: #ff0000, rgb(255,0,0), hsl(0,100%,50%), red',
        '',
        true
    );
}

// Parse the color
$rgb = parseColor($colorInput, $namedColors);

if ($rgb === false) {
    error("Invalid color format: $colorInput");
    exit(1);
}

// Convert to all formats
$hex = rgbToHex($rgb['r'], $rgb['g'], $rgb['b']);
$hsl = rgbToHsl($rgb['r'], $rgb['g'], $rgb['b']);
$oklch = rgbToOklch($rgb['r'], $rgb['g'], $rgb['b']);
$closestNamed = findClosestNamedColor($rgb['r'], $rgb['g'], $rgb['b'], $namedColors);

// Display all color formats in compact format
$formats = [];
$formats[] = "HEX: $hex";
$formats[] = "RGB: rgb({$rgb['r']}, {$rgb['g']}, {$rgb['b']})";
if ($rgb['a'] < 1) {
    $formats[] = "RGBA: rgba({$rgb['r']}, {$rgb['g']}, {$rgb['b']}, {$rgb['a']})";
}
$formats[] = "HSL: hsl({$hsl['h']}, {$hsl['s']}%, {$hsl['l']}%)";
if ($rgb['a'] < 1) {
    $formats[] = "HSLA: hsla({$hsl['h']}, {$hsl['s']}%, {$hsl['l']}%, {$rgb['a']})";
}
$formats[] = "OKLCH: oklch({$oklch['l']} {$oklch['c']} {$oklch['h']})";
$formats[] = "Named: $closestNamed";

info("$colorInput → " . implode(" | ", $formats));
