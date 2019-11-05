# Aurora Theme

## Documentation

Every folder contains a `README.md` with further instructions

## Installation

`$ composer create-project ralfhortt/wordpress-theme-boilerplate`
Check `INSTALLATION.md` for detailed installation steps

## Build Process

### Fonts

-   Set Google fonts url in `fonts.list` file
-   Run `npm run fonts` or `yarn fonts` for downloading google fonts

### Production

-   Run `npm run production` or `yarn production` for production build

### Development

-   Run `npm run dev` or `yarn dev` on development systems

#### Linters

Run `npm run lint` or `yarn lint` linting files

-   [phpcs](https://github.com/squizlabs/PHP_CodeSniffer) ([VScode](https://marketplace.visualstudio.com/items?itemName=ikappas.phpcs))
-   [phpmd](https://phpmd.org/) ([VScode](https://marketplace.visualstudio.com/items?itemName=ecodes.vscode-phpmd))
-   [eslint](https://eslint.org/) ([VScode](https://marketplace.visualstudio.com/items?itemName=dbaeumer.vscode-eslint))
-   [stylelint](https://stylelint.io/) ([VScode](https://marketplace.visualstudio.com/items?itemName=shinnn.stylelint))

#### Fixers

Run `npm run fix` or `yarn fix` for auto fixing

-   [eslint](https://eslint.org/)
-   [stylelint](https://stylelint.io/)
-   [phpcbf](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Fixing-Errors-Automatically)
