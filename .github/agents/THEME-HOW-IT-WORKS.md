# Theme How-It-Works (Agent Guide)

This guide gives coding agents a fast mental model of how this WordPress block theme works.

## Core Idea

The theme uses a **TypeScript-first workflow** for `theme.json`.

You edit TypeScript source files in `src/blocks/`, then generate the final root-level `theme.json` from those typed modules.

## Source of Truth

-   `src/blocks/theme.ts`: base theme configuration
-   `src/blocks/core/**`: per-core-block theme overrides
-   `theme.json`: generated output consumed by WordPress

Treat `src/blocks/*` as editable source and root `theme.json` as build output.

## Build Pipeline

1. `npm run generate:theme-types`

    - Downloads WordPress schema
    - Generates/updates theme types
    - Generates preset/custom-property helper types for autocomplete

2. `npm run build:theme-json`
    - Compiles TypeScript config
    - Produces the final `theme.json` at project root

## Autocompletion System

The type generation step builds helpers for:

-   `var:preset|...|{slug}` references
-   `var:custom|...` references

Generated helper files are in `src/blocks/` and are git-ignored.

## Typical Agent Workflow

1. Edit files in `src/blocks/theme.ts` and/or `src/blocks/core/**`.
2. Run `npm run build:theme-json`.
3. Validate output in root `theme.json`.
4. If presets/custom properties changed, run `npm run generate:theme-types` first.

## Do/Don't

-   Do: keep changes in typed source files.
-   Do: regenerate types after changing presets or custom properties.
-   Don't: hand-edit generated type helper files.
-   Don't: rely on stale `theme.json`; always rebuild after config edits.

## Related Docs

-   `./THEME-JSON-WORKFLOW.md`
-   `./THEME_AUTOCOMPLETION.md`
