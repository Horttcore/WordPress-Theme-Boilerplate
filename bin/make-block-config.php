#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/helpers.php';

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;

// Get the namespace and block name using Laravel Prompts with autocomplete
$namespaceBlock = ct_prompt_namespace_block();

// Split the input into namespace and block
[$namespace, $block] = explode('/', $namespaceBlock, 2);

// Define paths
$blocksBaseDir = __DIR__.'/../src/blocks';
$blockDir = $blocksBaseDir.'/'.$namespace.'/'.$block;
$destFile = $blockDir.'/'.$block.'.ts';
$stubFile = __DIR__.'/stubs/block-config.ts';

// Check if stub file exists
if (! file_exists($stubFile)) {
    error("Stub file not found: $stubFile");
    exit(1);
}

// Create directories if they don't exist
if (! is_dir($blockDir)) {
    mkdir($blockDir, 0755, true);
}

// Check if destination file already exists
if (file_exists($destFile)) {
    error("File already exists: $destFile");
    exit(1);
}

// Read stub file and replace placeholders
$content = file_get_contents($stubFile);
$content = str_replace('namespace/block', $namespace.'/'.$block, $content);

// Write to destination file
file_put_contents($destFile, $content);
info("✅ Created $destFile");
