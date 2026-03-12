#!/usr/bin/env node

const fs = require('fs');
const path = require('path');
const crypto = require('crypto');
const { spawnSync } = require('child_process');

/**
 * Build Block Styles
 * 
 * Scans src/blocks/core/ for style.scss and editor.scss files
 * Builds each with wp-scripts and organizes output by block
 * Generates manifest.php cache file
 */

const BLOCKS_DIR = path.join(__dirname, '../src/blocks/core');
const BUILD_DIR = path.join(__dirname, '../build/blocks');
const MANIFEST_PATH = path.join(__dirname, '../build/manifest.php');

// Color codes for terminal output
const colors = {
    reset: '\x1b[0m',
    dim: '\x1b[2m',
    bright: '\x1b[1m',
    green: '\x1b[32m',
    yellow: '\x1b[33m',
    red: '\x1b[31m',
    cyan: '\x1b[36m',
    gray: '\x1b[90m',
};

/**
 * Format console output
 */
function log(message) {
    console.log(message);
}

function logSuccess(message) {
    console.log(`${colors.green}✓${colors.reset} ${message}`);
}

function logError(message) {
    console.error(`${colors.red}✗${colors.reset} ${colors.red}${message}${colors.reset}`);
}

function logInfo(message) {
    console.log(`${colors.cyan}•${colors.reset} ${message}`);
}

function logFile(file, size = null) {
    const sizeStr = size ? ` ${colors.dim}(${size.toLocaleString()} bytes)${colors.reset}` : '';
    console.log(`  ${colors.bright}${file}${colors.reset}${sizeStr}`);
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
    const files = {
        style: null,
        editor: null,
    };

    const styleFile = path.join(blockPath, 'style.scss');
    const editorFile = path.join(blockPath, 'editor.scss');

    if (fs.existsSync(styleFile)) {
        files.style = styleFile;
    }

    if (fs.existsSync(editorFile)) {
        files.editor = editorFile;
    }

    return files;
}

/**
 * Generate build hash from file contents and timestamp
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
 * Build and move a single SCSS file
 */
function buildAndMoveScss(blockName, entryPath, outputCssName) {
    try {
        // Build to a temporary directory first to avoid wp-scripts cleaning up other files
        const tempDir = path.join(path.dirname(BUILD_DIR), `.temp-build-${blockName}-${outputCssName}`);
        
        // Run wp-scripts build to temporary directory
        const result = spawnSync('npx', ['wp-scripts', 'build', entryPath, `--output-path=${tempDir}`], {
            cwd: path.join(__dirname, '..'),
            stdio: ['pipe', 'pipe', 'pipe'],
            encoding: 'utf-8'
        });

        if (result.error) {
            throw result.error;
        }

        if (result.status !== 0 && result.status !== null) {
            const errorMsg = result.stderr || 'Unknown error';
            const errorLines = errorMsg.split('\n').slice(0, 5).join('\n');
            throw new Error(`Build failed: ${errorLines.substring(0, 200)}`);
        }

        // Now move the compiled files to the final location
        const blockBuildDir = path.join(BUILD_DIR, blockName);
        
        // Ensure block directory exists
        if (!fs.existsSync(blockBuildDir)) {
            fs.mkdirSync(blockBuildDir, { recursive: true });
        }

        // Check what files were created and rename them appropriately
        const files = fs.readdirSync(tempDir);
        
        // Find the CSS file that was created
        // wp-scripts creates files like "{inputName}-{inputName}.css" for scss files
        // e.g., style.scss -> style-style.scss.css
        const scssBasename = path.basename(entryPath, '.scss');
        const expectedPattern = `${scssBasename}-${scssBasename}.scss`;
        
        const cssFile = files.find(f => f.startsWith(expectedPattern) && f.endsWith('.css') && !f.includes('-rtl'));
        const rtlFile = files.find(f => f.startsWith(expectedPattern) && f.endsWith('-rtl.css'));
        
        if (cssFile) {
            const sourcePath = path.join(tempDir, cssFile);
            const targetPath = path.join(blockBuildDir, `${outputCssName}.css`);
            fs.copyFileSync(sourcePath, targetPath);
            
            if (rtlFile) {
                const sourceRtlPath = path.join(tempDir, rtlFile);
                const targetRtlPath = path.join(blockBuildDir, `${outputCssName}-rtl.css`);
                fs.copyFileSync(sourceRtlPath, targetRtlPath);
            }
            
            return { success: true, cssFile: `${blockName}/${outputCssName}.css` };
        } else {
            // Create empty CSS file if nothing was generated
            fs.writeFileSync(path.join(blockBuildDir, `${outputCssName}.css`), '');
            fs.writeFileSync(path.join(blockBuildDir, `${outputCssName}-rtl.css`), '');
            return { success: true, cssFile: `${blockName}/${outputCssName}.css`, empty: true };
        }
    } catch (error) {
        return { success: false, error: error.message };
    } finally {
        // Clean up temporary directory
        const tempDir = path.join(path.dirname(BUILD_DIR), `.temp-build-${blockName}-${outputCssName}`);
        if (fs.existsSync(tempDir)) {
            fs.rmSync(tempDir, { recursive: true, force: true });
        }
    }
}

/**
 * Build block SCSS files with wp-scripts
 */
function buildBlockStyles() {
    const blocks = getBlockDirectories();
    const builtFiles = [];
    const errors = [];

    // Ensure build directory exists
    if (!fs.existsSync(BUILD_DIR)) {
        fs.mkdirSync(BUILD_DIR, { recursive: true });
    }

    blocks.forEach(blockName => {
        const scssFiles = getBlockScssFiles(blockName);

        if (!scssFiles.style && !scssFiles.editor) {
            return; // Skip blocks with no SCSS files
        }

        if (scssFiles.style) {
            const result = buildAndMoveScss(blockName, `src/blocks/core/${blockName}/style.scss`, 'style');
            if (result.success) {
                builtFiles.push({ file: result.cssFile, empty: result.empty });
            } else {
                errors.push({ block: blockName, type: 'style', error: result.error });
            }
        }

        if (scssFiles.editor) {
            const result = buildAndMoveScss(blockName, `src/blocks/core/${blockName}/editor.scss`, 'editor');
            if (result.success) {
                builtFiles.push({ file: result.cssFile, empty: result.empty });
            } else {
                errors.push({ block: blockName, type: 'editor', error: result.error });
            }
        }
    });

    return { builtFiles, errors };
}

/**
 * Generate manifest.php file
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

    // Create PHP array format
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
 * Watch for SCSS file changes and rebuild
 */
function watchBlockScssFiles() {
    const watchedFiles = new Map();
    let rebuildTimeout;
    const trackedChanges = new Map(); // Track which files changed

    const rebuild = () => {
        clearTimeout(rebuildTimeout);
        rebuildTimeout = setTimeout(() => {
            const startTime = Date.now();
            const result = buildBlockStyles();
            
            if (result.errors.length > 0) {
                logError(`Build failed with ${result.errors.length} error(s):`);
                result.errors.forEach(err => {
                    logError(`  ${err.block}/${err.type}: ${err.error}`);
                });
            } else if (result.builtFiles.length > 0) {
                const elapsed = Date.now() - startTime;
                logInfo(`Rebuilt ${result.builtFiles.length} file(s) ${colors.dim}(${elapsed}ms)${colors.reset}`);
                result.builtFiles.forEach(f => {
                    logFile(f.file);
                });
                generateManifest();
            }
            trackedChanges.clear();
        }, 50); // Reduced debounce time for faster feedback
    };

    const setupFileWatcher = (filePath) => {
        if (watchedFiles.has(filePath)) {
            return;
        }

        try {
            let lastChangeTime = 0;
            const watcher = fs.watch(filePath, { persistent: true }, (eventType) => {
                // Debounce file system events (sometimes fires multiple times)
                const now = Date.now();
                if (now - lastChangeTime < 100) return;
                lastChangeTime = now;
                
                if (eventType === 'change') {
                    rebuild();
                }
            });
            watchedFiles.set(filePath, watcher);
        } catch (error) {
            // File might not exist yet, skip
        }
    };

    const scanAndWatch = () => {
        const blocks = getBlockDirectories();
        blocks.forEach(blockName => {
            const scssFiles = getBlockScssFiles(blockName);
            if (scssFiles.style) setupFileWatcher(scssFiles.style);
            if (scssFiles.editor) setupFileWatcher(scssFiles.editor);
        });

        // Re-scan for new files every 10 seconds (less frequent scanning)
        setTimeout(scanAndWatch, 10000);
    };

    scanAndWatch();
    logInfo(`Watching for SCSS changes ${colors.dim}(Ctrl+C to stop)${colors.reset}`);
}

/**
 * Main execution
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
            result.builtFiles.forEach(f => {
                logFile(f.file);
            });
        }

        const buildHash = generateManifest();
        logInfo(`Manifest generated ${colors.dim}(hash: ${buildHash})${colors.reset}`);

        if (watchMode) {
            log('');
            watchBlockScssFiles();
        }
    } catch (error) {
        logError(`Error building block styles: ${error.message}`);
        process.exit(1);
    }
}

main();
