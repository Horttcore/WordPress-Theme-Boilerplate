#!/usr/bin/env node

const { compileFromFile } = require("json-schema-to-typescript");
const fs = require("fs").promises;
const fsSync = require("fs");
const path = require("path");
const https = require("https");

const SCHEMA_URL =
    "https://raw.githubusercontent.com/WordPress/gutenberg/trunk/schemas/json/theme.json";
const SCHEMA_PATH = path.join(__dirname, "..", "theme-schema.json");
const OUTPUT_PATH = path.join(__dirname, "..", "src", "blocks", "theme.d.ts");
const PRESETS_OUTPUT_PATH = path.join(__dirname, "..", "src", "blocks", "theme-presets.ts");
const UTILS_OUTPUT_PATH = path.join(__dirname, "..", "src", "blocks", "theme-utils.ts");
const THEME_JSON_PATH = path.join(__dirname, "..", "theme.json");

/**
 * Download the schema from the URL
 */
async function downloadSchema() {
    console.log("Downloading theme.json schema...");

    return new Promise((resolve, reject) => {
        https
            .get(SCHEMA_URL, (response) => {
                let data = "";

                response.on("data", (chunk) => {
                    data += chunk;
                });

                response.on("end", () => {
                    resolve(data);
                });
            })
            .on("error", (error) => {
                reject(error);
            });
    });
}

/**
 * Extract all preset slugs from theme.json
 */
function extractPresets(themeJson) {
    const presets = {
        colors: [],
        gradients: [],
        duotones: [],
        fontSizes: [],
        fontFamilies: [],
        spacings: [],
        aspectRatios: [],
        borderRadii: [],
        shadows: [],
    };

    try {
        const settings = themeJson.settings || {};

        // Color presets
        if (settings.color?.palette) {
            presets.colors = settings.color.palette
                .filter(p => p.slug)
                .map(p => p.slug);
        }

        // Gradient presets
        if (settings.color?.gradients) {
            presets.gradients = settings.color.gradients
                .filter(p => p.slug)
                .map(p => p.slug);
        }

        // Duotone presets
        if (settings.color?.duotone) {
            presets.duotones = settings.color.duotone
                .filter(p => p.slug)
                .map(p => p.slug);
        }

        // Font size presets
        if (settings.typography?.fontSizes) {
            presets.fontSizes = settings.typography.fontSizes
                .filter(p => p.slug)
                .map(p => p.slug);
        }

        // Font family presets
        if (settings.typography?.fontFamilies) {
            presets.fontFamilies = settings.typography.fontFamilies
                .filter(p => p.slug)
                .map(p => p.slug);
        }

        // Spacing presets
        if (settings.spacing?.spacingSizes) {
            presets.spacings = settings.spacing.spacingSizes
                .filter(p => p.slug)
                .map(p => p.slug);
        }

        // Aspect ratio presets
        if (settings.dimensions?.aspectRatios) {
            presets.aspectRatios = settings.dimensions.aspectRatios
                .filter(p => p.slug)
                .map(p => p.slug);
        }

        // Border radius presets
        if (settings.border?.radiusSizes) {
            presets.borderRadii = settings.border.radiusSizes
                .filter(p => p.slug)
                .map(p => p.slug);
        }

        // Shadow presets
        if (settings.shadow?.presets) {
            presets.shadows = settings.shadow.presets
                .filter(p => p.slug)
                .map(p => p.slug);
        }
    } catch (error) {
        console.warn("Warning: Error extracting presets from theme.json:", error.message);
    }

    return presets;
}

/**
 * Extract custom properties with nested paths from theme.json
 */
function extractCustomProperties(themeJson) {
    const customProperties = [];

    function flattenObject(obj, prefix = "") {
        for (const key in obj) {
            if (obj.hasOwnProperty(key)) {
                const value = obj[key];
                const path = prefix ? `${prefix}.${key}` : key;
                
                // Always add the path itself
                customProperties.push(path);
                
                // If value is an object (not array), recurse
                if (typeof value === "object" && value !== null && !Array.isArray(value)) {
                    flattenObject(value, path);
                }
            }
        }
    }

    try {
        const settings = themeJson.settings || {};
        if (settings.custom && typeof settings.custom === "object") {
            flattenObject(settings.custom);
        }
    } catch (error) {
        console.warn("Warning: Error extracting custom properties:", error.message);
    }

    // Remove duplicates and sort
    return [...new Set(customProperties)].sort();
}

/**
 * Generate theme-presets.ts content
 */
function generatePresetsFile(presets, customProperties) {
    const presetTypes = [
        { name: "COLOR", constant: "COLOR_PRESETS", values: presets.colors },
        { name: "GRADIENT", constant: "GRADIENT_PRESETS", values: presets.gradients },
        { name: "DUOTONE", constant: "DUOTONE_PRESETS", values: presets.duotones },
        { name: "FONT_SIZE", constant: "FONT_SIZE_PRESETS", values: presets.fontSizes },
        { name: "FONT_FAMILY", constant: "FONT_FAMILY_PRESETS", values: presets.fontFamilies },
        { name: "SPACING", constant: "SPACING_PRESETS", values: presets.spacings },
        { name: "ASPECT_RATIO", constant: "ASPECT_RATIO_PRESETS", values: presets.aspectRatios },
        { name: "BORDER_RADIUS", constant: "BORDER_RADIUS_PRESETS", values: presets.borderRadii },
        { name: "SHADOW", constant: "SHADOW_PRESETS", values: presets.shadows },
    ];

    let content = `/* eslint-disable */
/**
 * Auto-generated preset constants from theme.json
 * DO NOT MODIFY - regenerate with: npm run generate:theme-types
 */

`;

    // Generate preset types
    for (const preset of presetTypes) {
        const valuesStr = preset.values.map(v => `'${v}'`).join(", ");
        // Convert "COLOR_PRESETS" -> "ColorPreset"
        const typeNameSingular = preset.constant
            .replace("_PRESETS", "")
            .split("_")
            .map(word => word.charAt(0) + word.slice(1).toLowerCase())
            .join("")
            + "Preset";
        
        content += `// ${preset.name} presets
export const ${preset.constant} = [${valuesStr}] as const;
export type ${typeNameSingular} = typeof ${preset.constant}[number];

`;
    }

    // Generate custom properties
    const customPropsStr = customProperties.map(p => `'${p}'`).join(", ");
    content += `// Custom property paths (nested, e.g., "color", "color.primary", "layout.max-width.content")
export const CUSTOM_PROPERTIES = [${customPropsStr}] as const;
export type CustomProperty = typeof CUSTOM_PROPERTIES[number];
`;

    return content;
}

/**
 * Generate theme-utils.ts content
 */
function generateUtilsFile() {
    const content = `/* eslint-disable */
/**
 * Auto-generated helper types for theme.json references
 * DO NOT MODIFY - regenerate with: npm run generate:theme-types
 */

import type {
	ColorPreset,
	GradientPreset,
	DuotonePreset,
	FontSizePreset,
	FontFamilyPreset,
	SpacingPreset,
	AspectRatioPreset,
	BorderRadiusPreset,
	ShadowPreset,
	CustomProperty,
} from './theme-presets.js';

/**
 * Preset reference types - provide autocomplete for preset slugs
 */
export type PresetColorRef = \`var:preset|color|\${ColorPreset}\`;
export type PresetGradientRef = \`var:preset|gradient|\${GradientPreset}\`;
export type PresetDuotoneRef = \`var:preset|duotone|\${DuotonePreset}\`;
export type PresetFontSizeRef = \`var:preset|font-size|\${FontSizePreset}\`;
export type PresetFontFamilyRef = \`var:preset|font-family|\${FontFamilyPreset}\`;
export type PresetSpacingRef = \`var:preset|spacing|\${SpacingPreset}\`;
export type PresetAspectRatioRef = \`var:preset|aspect-ratio|\${AspectRatioPreset}\`;
export type PresetBorderRadiusRef = \`var:preset|border-radius|\${BorderRadiusPreset}\`;
export type PresetShadowRef = \`var:preset|shadow|\${ShadowPreset}\`;

/**
 * Custom property references - provide autocomplete for custom property paths
 */
export type CustomPropertyRef = \`var:custom|\${CustomProperty}\`;

/**
 * Combined reference type - use for any theme preset or custom property reference
 * Falls back to string for flexibility with custom values
 */
export type ThemePresetReference =
	| PresetColorRef
	| PresetGradientRef
	| PresetDuotoneRef
	| PresetFontSizeRef
	| PresetFontFamilyRef
	| PresetSpacingRef
	| PresetAspectRatioRef
	| PresetBorderRadiusRef
	| PresetShadowRef
	| CustomPropertyRef
	| string;
`;

    return content;
}

/**
 * Enhance theme.d.ts to import and use helper types
 */
async function enhanceThemeDts() {
    let content = await fs.readFile(OUTPUT_PATH, "utf-8");

    // Check if already enhanced
    if (content.includes("import type { ThemePresetReference }")) {
        console.log("theme.d.ts already enhanced, skipping enhancement.");
        return;
    }

    // Add import at the beginning (after eslint-disable comment)
    const importStatement = `import type { ThemePresetReference, PresetColorRef, PresetGradientRef, PresetFontFamilyRef, PresetFontSizeRef, PresetSpacingRef, PresetBorderRadiusRef, PresetShadowRef, CustomPropertyRef } from './theme-utils.js';\n\n`;
    
    // Find where to insert - after the banner comment
    const lines = content.split("\n");
    let insertIndex = 0;
    for (let i = 0; i < lines.length; i++) {
        if (lines[i].endsWith("*/")) {
            insertIndex = i + 1;
            break;
        }
    }

    lines.splice(insertIndex, 0, importStatement);
    content = lines.join("\n");

    // Enhance RefComplete interface to use better types
    content = content.replace(
        /export interface RefComplete \{[^}]*ref\?: string;[^}]*\}/,
        `export interface RefComplete {
	/**
	 * A reference to another property value.
	 * 
	 * Supports theme preset references:
	 * - var:preset|color|{slug}
	 * - var:preset|font-family|{slug}
	 * - var:preset|font-size|{slug}
	 * - var:preset|spacing|{slug}
	 * 
	 * Supports custom property references:
	 * - var:custom|{path}
	 * 
	 * @example 'styles.color.text'
	 * @example 'var:preset|color|primary'
	 * @example 'var:custom|color|primary'
	 */
	ref?: ThemePresetReference;
}`
    );

    await fs.writeFile(OUTPUT_PATH, content);
    console.log("theme.d.ts enhanced with helper types");
}

/**
 * Generate TypeScript types from the schema
 */
async function generateTypes() {
    try {
        // Download schema
        const schemaData = await downloadSchema();
        await fs.writeFile(SCHEMA_PATH, schemaData);
        console.log("Schema downloaded successfully.");

        // Generate TypeScript types
        console.log("Generating TypeScript types...");
        const types = await compileFromFile(SCHEMA_PATH, {
            bannerComment:
                "/* eslint-disable */\n/**\n * This file was automatically generated from theme.json schema.\n * DO NOT MODIFY IT BY HAND. Instead, modify the source schema file,\n * and run `npm run generate:theme-types` to regenerate this file.\n */",
            style: {
                tabWidth: 4,
                useTabs: true,
            },
            enableConstEnums: false,
            strictIndexSignatures: false,
            unknownAny: true,
        });

        // Write types to file
        await fs.writeFile(OUTPUT_PATH, types);

        // Add a shorter type alias at the end
        const shortAlias =
            "\n\n/**\n * Shorter alias for the main theme.json type\n */\nexport type ThemeJson = JSONSchemaForWordPressBlockThemeGlobalSettingsAndStyles;\n";
        await fs.appendFile(OUTPUT_PATH, shortAlias);

        console.log(`TypeScript types generated successfully at ${OUTPUT_PATH}`);

        // Check if theme.json exists
        if (!fsSync.existsSync(THEME_JSON_PATH)) {
            console.warn(`⚠️  theme.json not found at ${THEME_JSON_PATH}, skipping preset generation.`);
            await fs.unlink(SCHEMA_PATH);
            return;
        }

        // Extract presets and custom properties from theme.json
        console.log("Extracting presets and custom properties from theme.json...");
        const themeJson = JSON.parse(await fs.readFile(THEME_JSON_PATH, "utf-8"));
        const presets = extractPresets(themeJson);
        const customProperties = extractCustomProperties(themeJson);

        // Generate theme-presets.ts
        console.log("Generating theme-presets.ts...");
        const presetsContent = generatePresetsFile(presets, customProperties);
        await fs.writeFile(PRESETS_OUTPUT_PATH, presetsContent);
        console.log(`✓ Generated ${PRESETS_OUTPUT_PATH}`);

        // Generate theme-utils.ts
        console.log("Generating theme-utils.ts...");
        const utilsContent = generateUtilsFile();
        await fs.writeFile(UTILS_OUTPUT_PATH, utilsContent);
        console.log(`✓ Generated ${UTILS_OUTPUT_PATH}`);

        // Enhance theme.d.ts
        console.log("Enhancing theme.d.ts...");
        await enhanceThemeDts();
        console.log(`✓ Enhanced ${OUTPUT_PATH}`);

        // Clean up downloaded schema
        await fs.unlink(SCHEMA_PATH);
        console.log("Cleaned up temporary schema file.");
        
        console.log("\n✅ All type files generated successfully!");
    } catch (error) {
        console.error("Error generating types:", error);
        process.exit(1);
    }
}

generateTypes();
