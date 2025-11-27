# Theme.json TypeScript Workflow

This project uses TypeScript files with full type safety to manage WordPress theme.json configuration.

## Overview

The theme.json configuration is split into modular TypeScript files:

-   **Theme**: `src/theme/theme.ts` - Base theme configuration

All files are type-checked against the official WordPress theme.json schema.

## Available Commands

### `npm run generate:theme-types`

Downloads the latest WordPress theme.json schema and generates TypeScript type definitions.

**When to use:** Run this occasionally to update type definitions when WordPress releases new theme.json features.

```bash
npm run generate:theme-types
```

### `npm run compile:theme`

Compiles TypeScript files to JavaScript using the TypeScript compiler.

**When to use:** Automatically runs as part of `build:theme-json`. You typically don't need to run this directly.

```bash
npm run compile:theme
```

### `npm run build:theme-json`

Compiles TypeScript files and builds the final `theme.json` file at the project root.

**When to use:** Run this whenever you make changes to any TypeScript configuration files. This is your main command for building theme.json.

```bash
npm run build:theme-json
```

## Workflow

### Initial Setup (One Time)

1. Generate type definitions:

    ```bash
    npm run generate:theme-types
    ```

### Daily Development

1. Edit TypeScript files in:

    - `src/theme/theme.ts` for base configuration

2. Build theme.json:

    ```bash
    npm run build:theme-json
    ```

3. The generated `theme.json` appears at the project root and is used by WordPress.

## File Structure

```
src/theme/
├── theme.d.ts                 # TypeScript type definitions (auto-generated)
├── theme.ts              # Base theme configuration
└── blocks/
    └── core/                  # Core block configurations
        ├── button/
        │   └── button.ts
        ├── heading/
        │   └── heading.ts
        └── ...
```

## Type Safety Benefits

-   **Autocomplete**: Get IDE suggestions for all valid theme.json properties
-   **Validation**: Catch errors before building (invalid properties, wrong types, etc.)
-   **Documentation**: Hover over properties to see their descriptions
-   **Refactoring**: Safely rename and restructure configuration with IDE support

## Example: Adding Block Styles

```typescript
// src/theme/blocks/core/button/button.ts
import type { JSONSchemaForWordPressBlockThemeGlobalSettingsAndStyles } from "../../../theme.d.ts";

const config: JSONSchemaForWordPressBlockThemeGlobalSettingsAndStyles = {
    $schema: "https://schemas.wp.org/trunk/theme.json",
    version: 3,
    settings: {
        blocks: {
            "core/button": {
                border: {
                    radius: true,
                },
            },
        },
    },
    styles: {
        blocks: {
            "core/button": {
                border: {
                    radius: "0.5rem",
                },
                typography: {
                    fontWeight: "600",
                },
            },
        },
    },
};

export default config;
```

Then run `npm run build:theme-json` to rebuild theme.json with your changes.

## Troubleshooting

### Types are outdated

Run `npm run generate:theme-types` to download the latest schema.

### Build fails with type errors

Check your TypeScript files for invalid properties or incorrect types. Your IDE should highlight these errors.

### Changes not appearing in theme.json

Make sure to run `npm run build:theme-json` after making changes to TypeScript files.
