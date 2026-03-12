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

/**
 * Get all block directories
 */
function getBlockDirectories() {
    if (!fs.existsSync(BLOCKS_DIR)) {
        console.error(`Blocks directory not found: ${BLOCKS_DIR}`);
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
            if (result.stderr) console.error('  Build error:', result.stderr.substring(0, 200));
            throw new Error(`wp-scripts build failed`);
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
            console.log(`  ✓ ${blockName}/${outputCssName}.css`);
            
            if (rtlFile) {
                const sourceRtlPath = path.join(tempDir, rtlFile);
                const targetRtlPath = path.join(blockBuildDir, `${outputCssName}-rtl.css`);
                fs.copyFileSync(sourceRtlPath, targetRtlPath);
            }
        } else {
            // Create empty CSS file if nothing was generated
            fs.writeFileSync(path.join(blockBuildDir, `${outputCssName}.css`), '');
            fs.writeFileSync(path.join(blockBuildDir, `${outputCssName}-rtl.css`), '');
            console.log(`  ✓ ${blockName}/${outputCssName}.css (empty)`);
        }

        // Clean up temporary directory
        fs.rmSync(tempDir, { recursive: true, force: true });

        return true;
    } catch (error) {
        console.error(`  ✗ Failed to build ${blockName}:`, error.message);
        throw error;
    }
}

/**
 * Build block SCSS files with wp-scripts
 */
function buildBlockStyles() {
    const blocks = getBlockDirectories();
    const builtBlocks = {};

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
            buildAndMoveScss(blockName, `src/blocks/core/${blockName}/style.scss`, 'style');
            builtBlocks[blockName] = builtBlocks[blockName] || {};
            builtBlocks[blockName].style = true;
        }

        if (scssFiles.editor) {
            buildAndMoveScss(blockName, `src/blocks/core/${blockName}/editor.scss`, 'editor');
            builtBlocks[blockName] = builtBlocks[blockName] || {};
            builtBlocks[blockName].editor = true;
        }
    });

    if (Object.keys(builtBlocks).length === 0) {
        console.log('ℹ No block SCSS files found');
        return;
    }

    console.log(`✓ Built ${Object.keys(builtBlocks).length} block(s)`);
}

/**
 * Generate manifest.php file
 */
function generateManifest() {
    const blocks = getBlockDirectories();
    const buildHash = generateBuildHash();
    const timestamp = Date.now();

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
    'timestamp' => ${timestamp},
];
`;

    fs.writeFileSync(MANIFEST_PATH, phpContent);
    console.log(`✓ Generated manifest`);
}

/**
 * Main execution
 */
function main() {
    console.log('Building block styles...');

    try {
        buildBlockStyles();
        generateManifest();
        console.log('✓ Block styles build complete');
    } catch (error) {
        console.error('✗ Error building block styles:', error.message);
        process.exit(1);
    }
}

main();
