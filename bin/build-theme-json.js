#!/usr/bin/env node

const fs = require("fs").promises;
const path = require("path");
const { pathToFileURL } = require("url");

const THEME_DIR = path.join(__dirname, "..", "src", "theme");
const BLOCKS_DIR = path.join(THEME_DIR, "blocks", "core");
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
        console.error(`Error loading ${filePath}:`, error.message);
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

        for (const dir of directories) {
            const blockName = dir.name;
            const blockDir = path.join(BLOCKS_DIR, blockName);

            // Load main block configuration (blockname.ts)
            const blockPath = path.join(blockDir, `${blockName}.ts`);

            try {
                await fs.access(blockPath);
                const config = await loadModule(blockPath);

                if (config) {
                    blocks[blockName] = config;
                    console.log(`✓ Loaded block: ${blockName}`);
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
        }
    } catch (error) {
        console.log("No blocks directory found, skipping...");
    }

    return { blocks, blockStyles };
}

/**
 * Load theme configuration
 */
async function loadTheme() {
    const themePath = path.join(THEME_DIR, "theme.ts");

    try {
        await fs.access(themePath);
        const config = await loadModule(themePath);
        console.log(`✓ Loaded theme configuration`);
        return config || {};
    } catch (error) {
        console.log("No theme file found, using empty object...");
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
        console.log("Building theme.json...\n");

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

        console.log(`✓ theme.json generated successfully at ${OUTPUT_PATH}`);
    } catch (error) {
        console.error("Error building theme.json:", error);
        process.exit(1);
    }
}

buildThemeJson();
