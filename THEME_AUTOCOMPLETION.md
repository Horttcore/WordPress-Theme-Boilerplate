# Theme Autocompletion Guide

This document explains the enhanced autocompletion system for `theme.json` and block configuration files.

## Overview

When editing block configurations in `src/blocks/core/*/block-name.ts`, you now get full VS Code autocompletion for:

1. **Preset References** - e.g., `var:preset|color|primary`
2. **Custom Property References** - e.g., `var:custom|color|primary`

## How It Works

### Generation Process

Running `npm run generate:theme-types` executes a single build script that:

1. **Downloads** the WordPress theme.json schema
2. **Generates** TypeScript definitions from the schema → `src/blocks/theme.d.ts`
3. **Extracts** all preset slugs from `theme.json` → `src/blocks/theme-presets.ts`
4. **Extracts** custom property paths from `theme.json` → included in `theme-presets.ts`
5. **Generates** helper types for references → `src/blocks/theme-utils.ts`
6. **Enhances** `theme.d.ts` to use the helper types
7. **Auto-ignores** generated files from git

### Auto-Generated Files

These files are automatically generated and git-ignored:

- `src/blocks/theme-presets.ts` - Preset constants and union types
- `src/blocks/theme-utils.ts` - Helper reference types
- `src/blocks/theme.d.ts` - Enhanced with import statements

## Usage Examples

### Using Preset References

When you have presets defined in `theme.json`:

```json
{
  "settings": {
    "color": {
      "palette": [
        { "name": "Primary", "slug": "primary", "color": "#0073aa" }
      ]
    },
    "typography": {
      "fontFamilies": [
        { "name": "Default", "slug": "default", "fontFamily": "system-ui" }
      ]
    }
  }
}
```

In a block configuration file:

```typescript
// src/blocks/core/button/button.ts
import type { ThemeJson } from '../../theme.d.js';

const config: Partial<ThemeJson> = {
  "styles": {
    "color": {
      "background": "var:preset|color|" // ← VS Code shows: [primary]
    },
    "typography": {
      "fontFamily": "var:preset|font-family|" // ← VS Code shows: [default]
    }
  }
};

export default config;
```

### Using Custom Property References

When you have custom properties in `theme.json`:

```json
{
  "settings": {
    "custom": {
      "color": {
        "primary": "#0073aa",
        "secondary": "#555d66"
      },
      "layout": {
        "max-width": {
          "content": "600px",
          "feature": "900px"
        }
      }
    }
  }
}
```

The extracted paths become:
- `color`
- `color.primary`
- `color.secondary`
- `layout`
- `layout.max-width`
- `layout.max-width.content`
- `layout.max-width.feature`

In a block configuration:

```typescript
const config: Partial<ThemeJson> = {
  "settings": {
    "layout": {
      "contentSize": "var:custom|layout|max-width|content"
      //                      ↑
      // VS Code shows: [color, color.primary, color.secondary, layout, ...]
    }
  }
};
```

## Supported Preset Types

The following preset categories are automatically extracted and typed:

1. **Colors** - `var:preset|color|{slug}`
2. **Gradients** - `var:preset|gradient|{slug}`
3. **Duotones** - `var:preset|duotone|{slug}`
4. **Font Sizes** - `var:preset|font-size|{slug}`
5. **Font Families** - `var:preset|font-family|{slug}`
6. **Spacing** - `var:preset|spacing|{slug}`
7. **Aspect Ratios** - `var:preset|aspect-ratio|{slug}`
8. **Border Radius** - `var:preset|border-radius|{slug}`
9. **Shadows** - `var:preset|shadow|{slug}`

## Regenerating Types

Whenever you update `theme.json` with new presets or custom properties, regenerate the types:

```bash
npm run generate:theme-types
```

This single command regenerates:
- Theme definitions from the WordPress schema
- Preset constants from `theme.json`
- Helper types
- Enhanced theme.d.ts

## Generated Type Files

### `theme-presets.ts`

Contains typed constants for all preset categories:

```typescript
export const COLOR_PRESETS = ['primary', 'secondary'] as const;
export type ColorPreset = typeof COLOR_PRESETS[number];

export const FONT_FAMILY_PRESETS = ['default'] as const;
export type FontFamilyPreset = typeof FONT_FAMILY_PRESETS[number];

// ... other presets ...

export const CUSTOM_PROPERTIES = [
  'color',
  'color.primary',
  'layout.max-width.content',
  // ...
] as const;
export type CustomProperty = typeof CUSTOM_PROPERTIES[number];
```

### `theme-utils.ts`

Contains helper types for building valid reference strings:

```typescript
export type PresetColorRef = `var:preset|color|${ColorPreset}`;
export type PresetFontFamilyRef = `var:preset|font-family|${FontFamilyPreset}`;
export type CustomPropertyRef = `var:custom|${CustomProperty}`;

export type ThemePresetReference =
  | PresetColorRef
  | PresetGradientRef
  | PresetFontFamilyRef
  | // ... other reference types ...
  | CustomPropertyRef
  | string; // Fallback for custom values
```

### `theme.d.ts` (Enhanced)

The generated schema file is enhanced with:

```typescript
import type { ThemePresetReference } from './theme-utils.js';

export interface RefComplete {
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
}
```

## Type Safety

The typing system provides:

✅ **Compile-time validation** - Invalid preset references are caught during development  
✅ **IDE autocompletion** - Full IntelliSense in VS Code  
✅ **Nested path support** - Works with deeply nested custom properties  
✅ **Fallback to string** - Allows custom/dynamic values when needed  
✅ **Zero runtime overhead** - All checking happens at compile time  

## Error Handling

The generation script gracefully handles edge cases:

- **Missing theme.json** - Logs warning, skips extraction, completes successfully
- **Invalid JSON** - Logs error, skips extraction, completes successfully
- **Empty presets** - Generates empty arrays, types work correctly
- **Deeply nested custom properties** - Recursively extracts all paths

## Tips for Best Results

1. **Update presets in theme.json first**, then regenerate types
2. **Use the autocomplete** - Let VS Code guide you to valid values
3. **Follow naming conventions** - Use kebab-case for slugs as per WordPress guidelines
4. **Test after adding presets** - Run type generation immediately after updating theme.json
5. **Commit the script changes** - Only commit `bin/generate-theme-types.js` changes, not generated files

## Git Configuration

The following files are automatically ignored from git:

```
theme.d.ts
src/blocks/theme-presets.ts
src/blocks/theme-utils.ts
```

This is configured in `.gitignore`, so generated files never appear in version control.

## Example Workflow

### 1. Add New Presets to theme.json

```json
{
  "settings": {
    "color": {
      "palette": [
        { "name": "Primary", "slug": "primary", "color": "#0073aa" },
        { "name": "Accent", "slug": "accent", "color": "#ff5722" }
      ]
    }
  }
}
```

### 2. Regenerate Types

```bash
npm run generate:theme-types
```

### 3. Use in Block Config with Autocompletion

```typescript
// VS Code now autocompletes:
const config: Partial<ThemeJson> = {
  "styles": {
    "color": {
      "text": "var:preset|color|" // ← Shows: [primary, accent]
    }
  }
};
```

## Troubleshooting

**Q: Autocompletion not showing in VS Code?**  
A: Make sure TypeScript extension is enabled and run `npm run generate:theme-types` after any theme.json changes.

**Q: Why are some presets not showing?**  
A: Check that presets have valid `slug` properties in theme.json. Regenerate with `npm run generate:theme-types`.

**Q: Can I add custom values not in presets?**  
A: Yes! The `string` fallback allows any value. The types just provide suggestions for known presets.

**Q: Do generated files need to be committed?**  
A: No! They're git-ignored. Only commit changes to `bin/generate-theme-types.js` and `theme.json`.

## References

- [WordPress Theme JSON Schema](https://schemas.wp.org/trunk/theme.json)
- [WordPress Theme JSON Documentation](https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-json-guide/)
- [TypeScript Template Literal Types](https://www.typescriptlang.org/docs/handbook/2/template-literal-types.html)
