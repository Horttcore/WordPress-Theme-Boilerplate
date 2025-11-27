#!/usr/bin/env node

const { compileFromFile } = require("json-schema-to-typescript");
const fs = require("fs").promises;
const path = require("path");
const https = require("https");

const SCHEMA_URL =
    "https://raw.githubusercontent.com/WordPress/gutenberg/trunk/schemas/json/theme.json";
const SCHEMA_PATH = path.join(__dirname, "..", "theme-schema.json");
const OUTPUT_PATH = path.join(__dirname, "..", "src", "theme", "theme.d.ts");

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

        // Clean up downloaded schema
        await fs.unlink(SCHEMA_PATH);
        console.log("Cleaned up temporary schema file.");
    } catch (error) {
        console.error("Error generating types:", error);
        process.exit(1);
    }
}

generateTypes();
