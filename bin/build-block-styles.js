#!/usr/bin/env node

const fs = require('fs');
const path = require('path');
const crypto = require('crypto');
const sass = require('sass');

/**
 * Build Block Styles - Lightning Fast Version
 * 
 * Uses Sass compiler directly instead of wp-scripts
 * ~10x faster than webpack-based builds
 */

const BLOCKS_DIR = path.join(__dirname, '../src/blocks/core');
const BUILD_DIR = path.join(__dirname, '../build/blocks');
const MANIFEST_PATH = path.join(__dirname, '../build/manifest.php');

// Color codes
const colors = {
    reset: '\x1b[0m',
    dim: '\x1b[2m',
    bright: '\x1b[1m',
    green: '\x1b[32m',
    red: '\x1b[31m',
    cyan: '\x1b[36m',
    yellow: '\x1b[33m',
};

function logInfo(message) {
    console.log(`${colors.cyan}•${colors.reset} ${message}`);
}

function logError(message) {
    console.error(`${colors.red}✗${colors.reset} ${colors.red}${message}${colors.reset}`);
}

function logFile(file) {
    console.log(`  ${colors.bright}${file}${colors.reset}`);
}

function logWarning(message) {
    console.log(`${colors.yellow}⚠${colors.reset}  ${message}`);
}

/**
 * Get all block directories
 */
function getBlockDirectories() {
    if (!fs.existsSync(BLOCKS_DIR)) {
        logError(`Blocks directory not found: ${BLOCKS_DIR}`);
        return [];
    }

    return fs.readdirSync(BLOCKS_DIR).filter(file => {
        const fullPath = path.join(BLOCKS_DIR, file);
        return fs.statSync(fullPath).isDirectory();
    });
}

/**
 * Get SCSS files for a block
 */
function getBlockScssFiles(blockName) {
    const blockPath = path.join(BLOCKS_DIR, blockName);
    return {
        style: fs.existsSync(path.join(blockPath, 'style.scss')) 
            ? path.join(blockPath, 'style.scss') 
            : null,
        editor: fs.existsSync(path.join(blockPath, 'editor.scss')) 
            ? path.join(blockPath, 'editor.scss') 
            : null,
    };
}

/**
 * Generate build hash
 */
function generateBuildHash() {
    const timestamp = Date.now();
    const blocks = getBlockDirectories();
    const fileList = blocks.map(block => {
        const scssFiles = getBlockScssFiles(block);
        return {
            block,
            hasStyle: !!scssFiles.style,
            hasEditor: !!scssFiles.editor,
        };
    });

    const content = timestamp + JSON.stringify(fileList);
    const hash = crypto.createHash('md5').update(content).digest('hex').slice(0, 8);
    return hash;
}

/**
 * Compile SCSS file using Sass
 */
function compileScss(inputPath, outputPath) {
    try {
        const result = sass.compile(inputPath, { style: 'compressed' });
        fs.writeFileSync(outputPath, result.css);
        return true;
    } catch (error) {
        throw new Error(`Sass compilation failed: ${error.message}`);
    }
}

/**
 * Build all block styles
 */
function buildBlockStyles() {
    const blocks = getBlockDirectories();
    const builtFiles = [];
    const errors = [];

    if (!fs.existsSync(BUILD_DIR)) {
        fs.mkdirSync(BUILD_DIR, { recursive: true });
    }

    blocks.forEach(blockName => {
        const scssFiles = getBlockScssFiles(blockName);

        if (!scssFiles.style && !scssFiles.editor) {
            return;
        }

        const blockBuildDir = path.join(BUILD_DIR, blockName);
        if (!fs.existsSync(blockBuildDir)) {
            fs.mkdirSync(blockBuildDir, { recursive: true });
        }

        // Compile style.scss
        if (scssFiles.style) {
            try {
                const outputPath = path.join(blockBuildDir, 'style.css');
                compileScss(scssFiles.style, outputPath);
                builtFiles.push(`${blockName}/style.css`);
            } catch (error) {
                errors.push({ block: blockName, type: 'style', error: error.message });
            }
        }

        // Compile editor.scss
        if (scssFiles.editor) {
            try {
                const outputPath = path.join(blockBuildDir, 'editor.css');
                compileScss(scssFiles.editor, outputPath);
                builtFiles.push(`${blockName}/editor.css`);
            } catch (error) {
                errors.push({ block: blockName, type: 'editor', error: error.message });
            }
        }
    });

    return { builtFiles, errors };
}

/**
 * Generate manifest.php
 */
function generateManifest() {
    const blocks = getBlockDirectories();
    const buildHash = generateBuildHash();
    const manifest = {};

    blocks.forEach(blockName => {
        const scssFiles = getBlockScssFiles(blockName);
        const hasStyle = !!scssFiles.style;
        const hasEditor = !!scssFiles.editor;

        manifest[blockName] = {
            style: hasStyle ? `build/blocks/${blockName}/style.css?v=${buildHash}` : null,
            editor: hasEditor ? `build/blocks/${blockName}/editor.css?v=${buildHash}` : null,
            exists_style: hasStyle,
            exists_editor: hasEditor,
        };
    });

    const phpContent = `<?php
/**
 * Block Styles Manifest
 * 
 * Auto-generated file - DO NOT EDIT
 * Generated: ${new Date().toISOString()}
 */

return [
    'blocks' => [
${Object.entries(manifest)
    .map(
        ([blockName, files]) =>
            `        '${blockName}' => [
            'style' => ${files.style ? `'${files.style}'` : 'null'},
            'editor' => ${files.editor ? `'${files.editor}'` : 'null'},
            'exists_style' => ${files.exists_style ? 'true' : 'false'},
            'exists_editor' => ${files.exists_editor ? 'true' : 'false'},
        ],`
    )
    .join('\n')}
    ],
    'build_hash' => '${buildHash}',
    'timestamp' => ${Date.now()},
];
`;

    fs.writeFileSync(MANIFEST_PATH, phpContent);
    return buildHash;
}

/**
 * Smart watch mode
 */
function watchBlockScssFiles() {
    const watchedFiles = new Map();
    let rebuildTimeout;

    const rebuild = () => {
        clearTimeout(rebuildTimeout);
        rebuildTimeout = setTimeout(() => {
            const startTime = Date.now();
            const result = buildBlockStyles();
            const elapsed = Date.now() - startTime;
            
            if (result.errors.length > 0) {
                logError(`Build failed with ${result.errors.length} error(s):`);
                result.errors.forEach(err => {
                    logError(`  ${err.block}/${err.type}: ${err.error}`);
                });
            } else if (result.builtFiles.length > 0) {
                logInfo(`Rebuilt ${result.builtFiles.length} file(s) ${colors.dim}(${elapsed}ms)${colors.reset}`);
                result.builtFiles.forEach(f => logFile(f));
                generateManifest();
            }
        }, 50);
    };

    const setupFileWatcher = (filePath) => {
        if (watchedFiles.has(filePath)) {
            return;
        }

        try {
            let lastChangeTime = 0;
            const watcher = fs.watch(filePath, { persistent: true }, (eventType) => {
                const now = Date.now();
                if (now - lastChangeTime < 100) return;
                lastChangeTime = now;
                
                if (eventType === 'change') {
                    rebuild();
                }
            });
            watchedFiles.set(filePath, watcher);
        } catch (error) {
            // Ignore
        }
    };

    const scanAndWatch = () => {
        const blocks = getBlockDirectories();
        blocks.forEach(blockName => {
            const scssFiles = getBlockScssFiles(blockName);
            if (scssFiles.style) setupFileWatcher(scssFiles.style);
            if (scssFiles.editor) setupFileWatcher(scssFiles.editor);
        });
        setTimeout(scanAndWatch, 10000);
    };

    scanAndWatch();
    logInfo(`Watching for SCSS changes ${colors.dim}(Ctrl+C to stop)${colors.reset}`);
}

/**
 * Main
 */
function main() {
    const args = process.argv.slice(2);
    const watchMode = args.includes('--watch') || args.includes('-w');
    const startTime = Date.now();

    try {
        const result = buildBlockStyles();
        const elapsed = Date.now() - startTime;

        if (result.errors.length > 0) {
            logError(`Build failed with ${result.errors.length} error(s):`);
            result.errors.forEach(err => {
                logError(`  ${err.block}/${err.type}: ${err.error}`);
            });
            process.exit(1);
        }

        if (result.builtFiles.length === 0) {
            logWarning(`No block SCSS files found`);
        } else {
            logInfo(`Built ${result.builtFiles.length} file(s) ${colors.dim}(${elapsed}ms)${colors.reset}`);
            result.builtFiles.forEach(f => logFile(f));
        }

        const buildHash = generateManifest();
        logInfo(`Manifest generated ${colors.dim}(hash: ${buildHash})${colors.reset}`);

        if (watchMode) {
            console.log('');
            watchBlockScssFiles();
        }
    } catch (error) {
        logError(`Error: ${error.message}`);
        process.exit(1);
    }
}

main();
