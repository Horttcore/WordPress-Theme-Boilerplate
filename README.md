# Aurora Theme

## Documentation

Every folder contains a `README.md` with further instructions

## Installation

`$ composer create-project ralfhortt/wordpress-theme-boilerplate`
Check `INSTALLATION.md` for detailed installation steps

## Development

### Commands

#### Development Helpers

-   `npm run make:block-config` / `composer run make:block-config` to interactively create a new TypeScript configuration file for a block in `src/theme/blocks/namespace/blockname`.
-   `npm run make:block-style` / `composer run make:block-style` to interactively create a TypeScript block style variation file.
-   `npm run make:block` / `composer run make:block` to interactively create a block pattern.
-   `npm run make:pattern` / `composer run make:pattern` to interactively create a block pattern.
-   `npm run css:clamp` / `composer run css:clamp` to calculate CSS clamp values for responsive design based on viewport sizes.
-   `npm run css:color` / `composer run css:color` to show a color in different notations (i.e. rgb hex oklch …)
-   `npm run css:contrast` / `composer run css:contrast` to calculate color contrast ratios and accessibility compliance.
-   `npm run generate:theme-types` to generate TypeScript type definitions from the WordPress theme.json schema.

#### Build Commands

-   `npm run build:theme` to build the theme.json file from TypeScript files in `src/theme/` and generate block style variations as JSON files in the `styles/` folder
-   `npm run watch:theme` to watch and auto-rebuild theme files during development
-   `npm run build` for production build (includes theme.json generation)
-   `npm start` for development with file watchers (includes automatic theme.json rebuilding)

## Build Process

The theme uses TypeScript for theme.json configuration with full type safety:

-   **Theme Configuration**: All theme.json settings are defined in TypeScript files in `src/theme/`
    -   `src/theme/theme.ts` - Main theme configuration
    -   `src/theme/blocks/core/*/` - Block-specific settings and styles
    -   Block style variations (files matching `blockname.*.ts`) are automatically generated as separate JSON files in the `styles/` directory
-   **Type Safety**: TypeScript types are auto-generated from the official WordPress theme.json schema
-   **Build System**: Node.js directly loads TypeScript files using `--experimental-strip-types` flag (no compilation step needed)

### Production

-   Run `npm run build` for production build (includes theme.json generation)

### Development

-   Run `npm start` for development with file watchers (automatically rebuilds theme.json when TypeScript files change)

#### Linters

-   `npm run lint:css` / `composer run lint:css` - Run stylelint for CSS/SCSS files
-   `npm run lint:php` / `composer run lint:php` - Run PHP linters (phpcs, phpmd)
-   `composer run lint` - Run PHPStan static analysis

Available linters:

-   [phpcs](https://github.com/squizlabs/PHP_CodeSniffer) ([VScode](https://marketplace.visualstudio.com/items?itemName=ikappas.phpcs))
-   [phpmd](https://phpmd.org/) ([VScode](https://marketplace.visualstudio.com/items?itemName=ecodes.vscode-phpmd))
-   [stylelint](https://stylelint.io/) ([VScode](https://marketplace.visualstudio.com/items?itemName=shinnn.stylelint))
-   [PHPStan](https://phpstan.org/) - Static analysis for PHP

#### Fixers

-   `npm run lint:css:fix` / `composer run lint:css:fix` - Auto-fix stylelint issues
-   `npm run lint:php:fix` / `composer run lint:php:fix` - Auto-fix PHP formatting with phpcbf
-   `composer run format` - Format PHP code with Laravel Pint
-   `composer run format:prettier` - Format files with Prettier

Available fixers:

-   [stylelint](https://stylelint.io/)
-   [phpcbf](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Fixing-Errors-Automatically)
-   [Laravel Pint](https://github.com/laravel/pint) - PHP code style fixer

#### Project Setup

-   `composer run replace-textdomain` - Replace textdomain placeholders with project name
-   `composer run copy-env` - Copy environment configuration files
