# Dependencies

Here are a for what each dependency is used

## package.json

### Production

-   none

### Dev

-   **@wordpress/icons:** WordPress icon library for block editor
-   **@wordpress/scripts:** WordPress official build scripts for blocks and assets
-   **json-schema-to-typescript:** Generate TypeScript types from WordPress theme.json schema
-   **postcss-custom-media:** Adding [custom media query](https://www.npmjs.com/package/postcss-custom-media) support
-   **postcss-easing-gradients:** [Improve gradients](https://www.npmjs.com/package/postcss-easing-gradients)
-   **stylelint:** Lint CSS/SCSS errors
-   **stylelint-order:** Sort CSS attributes alphabetically
-   **stylelint-scss:** Lint SCSS syntax
-   **typescript:** TypeScript compiler and type checking

## composer.json

### Prod

-   **laravel/pint:** PHP code style fixer and formatter
-   **laravel/prompts:** Interactive CLI prompts for build scripts
-   **ralfhortt/wp-assets:** Registering/Enqueing assets
-   **ralfhortt/wp-image-sizes:** Easier image registration

### Dev

-   **phpstan/phpstan:** PHP static analysis tool for type checking and error detection
-   **phpstan/extension-installer:** Automatically installs PHPStan extensions
-   **szepeviktor/phpstan-wordpress:** PHPStan rules and stubs for WordPress development
