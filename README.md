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

-   `npm run make:block namespace/block-name` to create a new json file for a block in `src/themes/blocks/blockname`.
-   `npm run make:style namepsace/blockname Title` to create a block style in `src/themes/namespace/blockname
-   `npm run build:theme` to build the theme.json file from `src/themes/` and copying the block styles to `styles` folder

## Build Process

### Production

-   Run `npm run build` for production build

### Development

-   Run `npm run start`

#### Linters

Run `npm run lint`

-   [phpcs](https://github.com/squizlabs/PHP_CodeSniffer) ([VScode](https://marketplace.visualstudio.com/items?itemName=ikappas.phpcs))
-   [phpmd](https://phpmd.org/) ([VScode](https://marketplace.visualstudio.com/items?itemName=ecodes.vscode-phpmd))
-   [eslint](https://eslint.org/) ([VScode](https://marketplace.visualstudio.com/items?itemName=dbaeumer.vscode-eslint))
-   [stylelint](https://stylelint.io/) ([VScode](https://marketplace.visualstudio.com/items?itemName=shinnn.stylelint))

#### Fixers

Run `npm run fix` for auto fixing

-   [eslint](https://eslint.org/)
-   [stylelint](https://stylelint.io/)
-   [phpcbf](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Fixing-Errors-Automatically)
