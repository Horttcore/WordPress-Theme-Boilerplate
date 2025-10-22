# Aurora Theme

## Documentation

Every folder contains a `README.md` with further instructions

## Installation

`$ composer create-project ralfhortt/wordpress-theme-boilerplate`
Check `INSTALLATION.md` for detailed installation steps

## Development

### Commands

#### Development Helpers

-   `npm run make:block` / `composer run make:block` to interactively create a new json file for a block in `src/theme/blocks/blockname`.
-   `npm run make:style` to interactively create a block style in `src/theme/namespace/blockname`.
-   `npm run make:block-style` / `composer run make:block-style` to interactively create a block style.
-   `npm run make:pattern` / `composer run make:pattern` to interactively create a block pattern.
-   `npm run css:clamp` / `composer run css:clamp` to calculate CSS clamp values for responsive design based on viewport sizes.
-   `npm run css:color` / `composer run css:color` to show a color in different notations (i.e. rgb hex oklch …)
-   `npm run css:contrast` / `composer run css:contrast` to calculate color contrast ratios and accessibility compliance.

#### Build Commands

-   `npm run build:theme` to build the theme.json file from `src/theme/` and copying the block styles to `styles` folder
-   `npm run watch:theme` to watch and auto-rebuild theme files during development

## Build Process

### Production

-   Run `npm run build` for production build

### Development

-   Run `npm run start`

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
