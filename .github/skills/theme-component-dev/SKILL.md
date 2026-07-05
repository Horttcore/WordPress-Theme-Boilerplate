---
name: theme-component-dev
description: "Use when: developing new theme components (blocks, patterns, styles). Guides end-to-end workflow from concept to implementation using composer make: commands, includes decision points for component types and validation checklists."
---

# Theme Component Development Workflow

## Overview

This skill provides a structured, end-to-end workflow for developing theme components in the WordPress Theme Boilerplate. It covers:

-   **Blocks** (custom block implementations)
-   **Block Styles** (style variants for existing blocks)
-   **Block Configurations** (block-specific settings and options)
-   **Patterns** (reusable content patterns)
-   **Starter Content** (default demo content)
-   **Query Loops** (dynamic query-based blocks)
-   **CSS Utilities** (design tokens, responsive scales, contrast validation)

Use this skill when you need to:

-   Generate scaffolding for new components
-   Understand the proper sequence for component development
-   Validate completed components against quality criteria
-   Reference templates and stub files

## Prerequisites

-   ✅ Composer installed and dependencies loaded
-   ✅ Node.js and npm available
-   ✅ Familiarity with PHP, TypeScript, and WordPress block development
-   ✅ Access to `composer run-script make:*` commands

## Workflow

### 1. Plan Component Type

**Determine what you're building:**

| Component           | Command                                    | Output                                          | When to Use                                  |
| ------------------- | ------------------------------------------ | ----------------------------------------------- | -------------------------------------------- |
| **Custom Block**    | `composer run-script make:block`           | Block folder in `src/blocks/` + TypeScript stub | New interactive block from scratch           |
| **Block Style**     | `composer run-script make:block-style`     | Style folder in `build/blocks/`                 | Visual variant of existing block             |
| **Block Config**    | `composer run-script make:block-config`    | Config TypeScript in `src/blocks/`              | Custom settings for block behavior           |
| **Pattern**         | `composer run-script make:pattern`         | HTML pattern in `patterns/`                     | Reusable layout/content combo                |
| **Starter Content** | `composer run-script make:starter-content` | PHP in `inc/`                                   | Demo data for fresh installs                 |
| **Query Loop**      | `composer run-script make:query-loop`      | Query block variant                             | Dynamic content from posts/custom post types |

**Decision:** Is this a new interactive component, a style variant, or reusable content?

-   → **Interactive** = Block · Block Config
-   → **Visual style** = Block Style
-   → **Content template** = Pattern or Starter Content
-   → **Dynamic query** = Query Loop

### 2. Generate Component Scaffolding

Run the appropriate `composer make:` command:

```bash
composer run-script make:block           # generates src/blocks/my-block/
composer run-script make:block-style     # generates build/blocks/my-block-style/
composer run-script make:pattern         # generates patterns/my-pattern/
```

**During generation:**

-   Follow prompts for component naming (slug format: `my-component`)
-   Confirm output paths
-   Review generated stub files

**After generation:**

-   Review the stub template files (`.ts`, `.php`, `.scss`)
-   Check that paths are correct in `theme.json` or `functions.php`

### 3. Implement Component Logic

**For Blocks:**

1. Edit the TypeScript file in `src/blocks/my-block/index.ts`
2. Add attributes, edit function, and save function
3. Register block with `theme.json`

**For Styles:**

1. Define CSS in `build/blocks/my-block-style/style.scss`
2. Register style class names in `inc/blocks/block-styles-registration.php`

**For Patterns:**

1. Edit the HTML pattern file in `patterns/my-pattern.html`
2. Add core blocks and markup
3. Register pattern slug in `functions.php` if needed

### 4. Apply Design Tokens & Utilities

**Use CSS utilities to generate values:**

| Task                    | Command                            | Purpose                            |
| ----------------------- | ---------------------------------- | ---------------------------------- |
| Responsive font scaling | `composer run-script css:clamp`    | Generate CSS clamp() for font-size |
| Color value validation  | `composer run-script css:color`    | Convert/validate color formats     |
| Contrast checking       | `composer run-script css:contrast` | Verify WCAG contrast ratios        |
| SVG to mask             | `composer run-script css:mask`     | Convert SVG icons to CSS masks     |

Example workflow:

```bash
# Generate responsive font scale
composer run-script css:clamp         # outputs CSS clamp(min, preferred, max)

# Validate colors in your palette
composer run-script css:color         # checks color syntax and compatibility

# Check button contrast ratio
composer run-script css:contrast      # validates WCAG AA/AAA compliance
```

### 5. Testing & Validation

**Component Quality Checklist:**

-   [ ] Component generates without errors
-   [ ] Naming follows theme conventions (kebab-case for slugs)
-   [ ] TypeScript/PHP has no syntax errors
-   [ ] CSS builds and compiles without warnings
-   [ ] Block appears in editor (for blocks)
-   [ ] Pattern renders correctly as content (for patterns)
-   [ ] All required attributes are registered
-   [ ] Accessibility: labels, roles, color contrast pass
-   [ ] Responsive behavior tested on mobile/tablet/desktop
-   [ ] Documentation added to component folder

**Run linting before commit:**

```bash
composer run-script lint:php           # PHP validation
npm run lint                           # TypeScript & CSS
npm run format                         # Auto-format code
```

### 6. Integration Steps

**After component passes validation:**

1. **Register block** in `theme.json` or `inc/blocks/` if not auto-registered
2. **Update documentation** in component README or main docs
3. **Add to type exports** in `src/blocks/theme.d.ts` (if block exports types)
4. **Test in page editor** - verify in WordPress editor environment
5. **Commit with descriptive message** - include component type in commit

## Template Reference

### Block Implementation Template

**File:** `src/blocks/my-block/index.ts`

```typescript
import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import Edit from "./edit";
import Save from "./save";
import metadata from "./block.json";

registerBlockType(metadata.name, {
    ...metadata,
    edit: Edit,
    save: Save,
});
```

### Block Style Template

**File:** `build/blocks/my-style/style.scss`

```scss
.wp-block-my-block {
    &.is-style-my-style {
        // Custom style properties
        padding: var(--wp--custom--spacing--block);
        background: var(--wp--color--background);
    }
}
```

### Pattern Template

**File:** `patterns/my-pattern.html`

```html
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
    <!-- wp:heading {"level":2} -->
    <h2>Pattern Title</h2>
    <!-- /wp:heading -->

    <!-- wp:paragraph -->
    <p>Pattern content</p>
    <!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
```

## Troubleshooting

**Issue:** Generator prompts aren't working

-   Solution: Ensure `laravel/prompts` dependency is installed (`composer update`)

**Issue:** Generated block doesn't appear in editor

-   Solution: Check `theme.json` for block registration; run `npm run build`

**Issue:** TypeScript compilation errors

-   Solution: Verify file paths in `tsconfig.json`; check for missing imports

**Issue:** CSS doesn't apply to block

-   Solution: Verify class names; check that SCSS is in correct build path; run `npm run build:css`

## Related Make Commands

Full reference of all available scaffolding commands in `composer.json`:

-   `make:block` — Custom block component
-   `make:block-style` — Block style variant
-   `make:block-config` — Block configuration/settings
-   `make:pattern` — Reusable markup pattern
-   `make:starter-content` — Demo/default site content
-   `make:query-loop` — Dynamic query-based block
-   `css:clamp` — Responsive scaling utility
-   `css:color` — Color validation utility
-   `css:contrast` — Contrast ratio checker
-   `css:mask` — SVG mask generator

## Assets

See related files for detailed implementation examples:

-   [Block stubs](../../bin/stubs/) — Template TypeScript and config files
-   [Existing blocks](../../src/blocks/) — Real component examples
-   [Pattern examples](../../patterns/) — Content pattern reference
