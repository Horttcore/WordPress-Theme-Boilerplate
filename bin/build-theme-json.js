#!/usr/bin/env node

const fs = require("fs").promises;
const path = require("path");
const { pathToFileURL } = require("url");

const THEME_DIR = path.join(__dirname, "..", "src", "theme");
const BLOCKS_DIR = path.join(__dirname, "..", "src", "blocks", "core");
const BLOCKS_CONFIG_DIR = path.join(__dirname, "..", "src", "blocks");
const OUTPUT_PATH = path.join(__dirname, "..", "theme.json");

/**
 * Deep merge two objects
 */
function deepMerge(target, source) {
    const output = { ...target };

    if (isObject(target) && isObject(source)) {
        Object.keys(source).forEach((key) => {
            if (isObject(source[key])) {
                if (!(key in target)) {
                    output[key] = source[key];
                } else {
                    output[key] = deepMerge(target[key], source[key]);
                }
            } else {
                output[key] = source[key];
            }
        });
    }

    return output;
}

/**
 * Check if value is an object
 */
function isObject(item) {
    return item && typeof item === "object" && !Array.isArray(item);
}

/**
 * Load a TypeScript/JavaScript module
 */
async function loadModule(filePath) {
    try {
        // Convert to file URL for dynamic import
        const fileUrl = pathToFileURL(filePath).href;
        const module = await import(fileUrl);
        return module.default || module;
    } catch (error) {
        const fileName = path.basename(filePath);
        console.error(`\n⚠ Error loading ${fileName}`);
        console.error(`  File: ${filePath}`);
        console.error(`  Issue: ${error.message}`);
        console.error(
            `  Tip: Check file syntax, TypeScript errors, and that exports are correct\n`
        );
        return null;
    }
}

/**
 * Load all block configurations and styles
 */
async function loadBlocks() {
    const blocks = {};
    const blockStyles = [];

    try {
        const entries = await fs.readdir(BLOCKS_DIR, { withFileTypes: true });
        const directories = entries.filter((entry) => entry.isDirectory());

        if (directories.length === 0) {
            console.log("⚠ No block directories found in src/blocks/core/");
        }

        for (const dir of directories) {
            const blockName = dir.name;
            const blockDir = path.join(BLOCKS_DIR, blockName);
            let blockLoaded = false;

            // Load main block configuration (blockname.ts)
            const blockPath = path.join(blockDir, `${blockName}.ts`);

            try {
                await fs.access(blockPath);
                const config = await loadModule(blockPath);

                if (config) {
                    blocks[blockName] = config;
                    console.log(`✓ Loaded block: ${blockName}`);
                    blockLoaded = true;
                }
            } catch (error) {
                // File doesn't exist, skip
            }

            // Load block styles (blockname.*.ts)
            try {
                const blockFiles = await fs.readdir(blockDir);
                const styleFiles = blockFiles.filter((file) => {
                    return (
                        file.startsWith(`${blockName}.`) &&
                        file.endsWith(".ts") &&
                        file !== `${blockName}.ts`
                    );
                });

                for (const styleFile of styleFiles) {
                    const stylePath = path.join(blockDir, styleFile);
                    const styleConfig = await loadModule(stylePath);

                    if (styleConfig) {
                        // Store the original filename without .ts extension
                        const styleFileName = styleFile.replace(/\.ts$/, "");
                        blockStyles.push({ ...styleConfig, _filename: styleFileName });
                        console.log(`✓ Loaded block style: ${styleFile}`);
                    }
                }
            } catch (error) {
                // No styles found, skip
            }

            if (
                !blockLoaded &&
                (await fs.readdir(blockDir)).filter((f) => f.endsWith(".ts")).length === 0
            ) {
                console.log(`⚠ Block directory "${blockName}" has no .ts files`);
            }
        }
    } catch (error) {
        console.error(`\n⚠ Error reading blocks directory: ${error.message}`);
        console.error(`  Path: ${BLOCKS_DIR}`);
        console.error(`  Tip: Check that src/blocks/core/ directory exists\n`);
    }

    return { blocks, blockStyles };
}

/**
 * Load theme configuration
 */
async function loadTheme() {
    const themePath = path.join(BLOCKS_CONFIG_DIR, "theme.ts");

    try {
        await fs.access(themePath);
        const config = await loadModule(themePath);
        console.log(`✓ Loaded theme configuration`);
        return config || {};
    } catch (error) {
        console.log(`⚠ No theme.ts found (${BLOCKS_CONFIG_DIR}/theme.ts)`);
        console.log(`  Using default theme configuration\n`);
        return {
            $schema: "https://schemas.wp.org/trunk/theme.json",
            version: 3,
        };
    }
}

/**
 * Build the complete theme.json
 */
async function buildThemeJson() {
    try {
        console.log("\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        console.log("Building theme.json...");
        console.log("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n");

        // Load all components
        const theme = await loadTheme();
        console.log();

        const { blocks, blockStyles } = await loadBlocks();
        console.log();

        // Start with theme base
        let themeJson = { ...theme };

        // Merge block settings and styles
        if (Object.keys(blocks).length > 0) {
            // Initialize settings.blocks and styles.blocks if they don't exist
            if (!themeJson.settings) themeJson.settings = {};
            if (!themeJson.settings.blocks) themeJson.settings.blocks = {};
            if (!themeJson.styles) themeJson.styles = {};
            if (!themeJson.styles.blocks) themeJson.styles.blocks = {};

            for (const [blockName, blockConfig] of Object.entries(blocks)) {
                // Merge block settings
                if (blockConfig.settings?.blocks) {
                    themeJson.settings.blocks = deepMerge(
                        themeJson.settings.blocks,
                        blockConfig.settings.blocks
                    );
                }

                // Merge block styles
                if (blockConfig.styles?.blocks) {
                    themeJson.styles.blocks = deepMerge(
                        themeJson.styles.blocks,
                        blockConfig.styles.blocks
                    );
                }
            }
        }

        // Generate block styles as separate JSON files
        if (blockStyles.length > 0) {
            const stylesDir = path.join(__dirname, "..", "styles");

            // Ensure styles directory exists
            try {
                await fs.mkdir(stylesDir, { recursive: true });
            } catch (error) {
                // Directory already exists
            }

            for (const styleConfig of blockStyles) {
                const { slug, _filename, ...styleData } = styleConfig;

                // Use original filename if available, otherwise fall back to slug
                const outputFileName = _filename || slug;

                if (outputFileName) {
                    const styleFilePath = path.join(stylesDir, `${outputFileName}.json`);
                    await fs.writeFile(styleFilePath, JSON.stringify(styleData, null, "\t"));
                    console.log(`✓ Generated block style: ${outputFileName}.json`);
                }
            }
        }

        // Write theme.json
        await fs.writeFile(OUTPUT_PATH, JSON.stringify(themeJson, null, "\t"));

        console.log(`\n✓ theme.json built successfully`);
        console.log(`━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n`);
    } catch (error) {
        console.error(`\n✗ Error building theme.json:\n  ${error.message}\n`);
        process.exit(1);
    }
}

buildThemeJson();
