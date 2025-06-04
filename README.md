# Aurora Theme

[![Build Status](https://github.com/ralfhortt/wordpress-theme-boilerplate/actions/workflows/php.yml/badge.svg)](https://github.com/ralfhortt/wordpress-theme-boilerplate/actions/workflows/php.yml)
[![Lint Status](https://github.com/ralfhortt/wordpress-theme-boilerplate/actions/workflows/lint.yml/badge.svg)](https://github.com/ralfhortt/wordpress-theme-boilerplate/actions/workflows/lint.yml)

## Documentation

Every folder contains a `README.md` with further instructions

## Installation

`$ composer create-project ralfhortt/wordpress-theme-boilerplate`
Check `INSTALLATION.md` for detailed installation steps

## Development

### Commands

-   `npm run make:block` – Interactive prompt to create a new block in `src/theme/blocks/<block-name>`. Generates `block.json`, `edit.tsx`, `index.tsx`, and `save.tsx` from stubs.
-   `npm run make:style` – Interactive prompt to create a new block style JSON in `src/theme/blocks/<block-name>`.
-   `npm run make:block-config` – Interactive prompt to create a new block configuration JSON in `src/theme/blocks/<block-name>`.
-   `npm run build:theme` – Builds the `theme.json` file from `src/theme/` and copies block style JSON files to the `styles` folder.

### Hot Module Reloading

For a fast development workflow, hot module reloading (HMR) is enabled via `wp-scripts`:

-   Run `npm run start`
    This starts the development server with HMR for JS, TS, and SCSS files. Changes are automatically reflected in the browser without a full reload.

### Linters

-   **PHP:**
    -   Lint: `npm run lint:php` (runs PHPStan)
    -   Format: `npm run lint:php:fix` (runs Pint)
-   **JavaScript/TypeScript:**
    -   Lint: `npm run lint:js` (if configured)
    -   Format: `npm run lint:js:fix` (if configured)
-   **CSS/SCSS:**
    -   Lint: `npm run lint:css`
    -   Format: `npm run lint:css:fix`

You can also run all linters with `npm run lint` (if configured).

### Fixers

-   **PHP:**
    -   Format code using [Laravel Pint](https://laravel.com/docs/10.x/pint):
        `composer run format`
-   **CSS/SCSS:**
    -   Auto-fix with Stylelint:
        `npm run lint:css:fix`
-   **JavaScript/TypeScript:**
    -   Auto-fix with ESLint (if configured):
        `npm run lint:js:fix`

### Code Formatting

Use [Laravel Pint](https://laravel.com/docs/10.x/pint) to automatically format PHP code:

```sh
composer run format
```

You can customize Pint's rules by adding a `pint.json` or `pint.json5` configuration file to your project root.

### Code Upgrades

Run Rector to automatically upgrade and refactor PHP code:

```sh
composer run rector
```

See [Rector documentation](https://getrector.com/docs/) for configuration and usage details.
