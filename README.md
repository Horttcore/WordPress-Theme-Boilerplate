# Aurora Theme

<p align="center">
  <img src="https://img.shields.io/badge/WordPress-6.8+-21759B?style=for-the-badge&logo=wordpress&logoColor=white" alt="WordPress">
  <img src="https://img.shields.io/badge/PHP-8.4+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Node-22.11+-339933?style=for-the-badge&logo=node.js&logoColor=white" alt="Node">
  <img src="https://img.shields.io/badge/TypeScript-5.9-3178C6?style=for-the-badge&logo=typescript&logoColor=white" alt="TypeScript">
  <img src="https://img.shields.io/badge/License-GPL--2.0+-blue?style=for-the-badge" alt="License">
</p>

---

## 🛠️ Technologies

<table>
<tr>
<td>

**Frontend**

-   ![SCSS](https://img.shields.io/badge/SCSS-CC6699?style=flat-square&logo=sass&logoColor=white) PostCSS
-   ![TypeScript](https://img.shields.io/badge/TypeScript-3178C6?style=flat-square&logo=typescript&logoColor=white) Native Support

</td>
<td>

**Build Tools**

-   ![WordPress](https://img.shields.io/badge/@wordpress/scripts-21759B?style=flat-square&logo=wordpress&logoColor=white) 30.26
-   ![Node.js](https://img.shields.io/badge/Node.js-339933?style=flat-square&logo=node.js&logoColor=white) ESM

</td>
<td>

**Code Quality**

-   ![PHPStan](https://img.shields.io/badge/PHPStan-777BB4?style=flat-square&logo=php&logoColor=white) Level Max
-   ![Rector](https://img.shields.io/badge/Rector-777BB4?style=flat-square&logo=php&logoColor=white) Refactoring
-   ![Stylelint](https://img.shields.io/badge/Stylelint-263238?style=flat-square&logo=stylelint&logoColor=white) 16
-   ![Pint](https://img.shields.io/badge/Pint-FF2D20?style=flat-square&logo=laravel&logoColor=white) 1.22

</td>
</tr>
</table>

---

---

## 📚 Documentation

Comprehensive guides to help you get started and understand the project structure:

<table>
<tr>
<td width="33%">

### 📦 [Installation Guide](INSTALLATION.md)

Step-by-step installation instructions including requirements (Composer, Node.js) and setup process.

</td>
<td width="33%">

### 🎨 [Theme.json Workflow](THEME-JSON-WORKFLOW.md)

Learn how to work with TypeScript-based theme.json configuration, including type safety benefits and daily development workflow.

</td>
<td width="33%">

### 📋 [Dependencies](DEPENDENCIES.md)

Detailed breakdown of all npm and Composer dependencies, explaining what each package does and why it's included.

</td>
</tr>
<tr>
<td width="33%">

### 📝 [Changelog](CHANGELOG.md)

Track version history and changes to the project.

</td>
<td width="33%">

### 📁 Folder READMEs

Every major folder contains its own `README.md` with specific instructions for that section.

</td>
<td width="33%">

</td>
</tr>
</table>

---

## 🚀 Installation

```bash
composer create-project ralfhortt/wordpress-theme-boilerplate
```

> 📖 Check `INSTALLATION.md` for detailed installation steps

---

## 💻 Development

### ⚡ Quick Start

<table>
<tr>
<td width="50%">

**🏗️ Production Build**

```bash
npm run build
```

Builds all assets and generates theme.json

</td>
<td width="50%">

**👀 Development Mode**

```bash
npm start
```

Starts file watchers with auto-rebuild

</td>
</tr>
</table>

### 🔧 Commands

<details>
<summary><b>🎨 Development Helpers</b></summary>

| Command                        | Description                                     |
| ------------------------------ | ----------------------------------------------- |
| `npm run make:block-config`    | Create TypeScript block configuration           |
| `npm run make:block-style`     | Create TypeScript block style variation         |
| `npm run make:block`           | Create a block pattern                          |
| `npm run make:pattern`         | Create a block pattern                          |
| `npm run css:clamp`            | Calculate CSS clamp values                      |
| `npm run css:color`            | Convert color notations (rgb, hex, oklch)       |
| `npm run css:contrast`         | Calculate color contrast ratios                 |
| `npm run generate:theme-types` | Generate TypeScript types from WordPress schema |

</details>

<details>
<summary><b>🏗️ Build Commands</b></summary>

| Command               | Description                            |
| --------------------- | -------------------------------------- |
| `npm run build:theme` | Build theme.json from TypeScript files |
| `npm run watch:theme` | Watch and auto-rebuild theme files     |
| `npm run build`       | Production build (includes theme.json) |
| `npm start`           | Development mode with file watchers    |

</details>

<details>
<summary><b>🔍 Linters</b></summary>

| Command             | Description                 |
| ------------------- | --------------------------- |
| `npm run lint:css`  | Run Stylelint for CSS/SCSS  |
| `npm run lint:php`  | Run PHPStan analysis        |
| `composer run lint` | Run PHPStan static analysis |

**Available Tools:**

-   ![PHPStan](https://img.shields.io/badge/PHPStan-777BB4?style=flat-square&logo=php&logoColor=white) [PHPStan](https://phpstan.org/) - Static analysis
-   ![Stylelint](https://img.shields.io/badge/Stylelint-263238?style=flat-square&logo=stylelint&logoColor=white) [Stylelint](https://stylelint.io/) - CSS/SCSS linting

</details>

<details>
<summary><b>🔧 Fixers & Formatters</b></summary>

| Command                        | Description                       |
| ------------------------------ | --------------------------------- |
| `npm run lint:css:fix`         | Auto-fix Stylelint issues         |
| `npm run lint:php:fix`         | Format PHP with Laravel Pint      |
| `composer run format`          | Format PHP code with Laravel Pint |
| `composer run format:prettier` | Format all files with Prettier    |
| `composer run refactor`        | Refactor PHP code with Rector     |
| `composer run refactor:dry`    | Preview Rector changes            |

**Available Tools:**

-   ![Pint](https://img.shields.io/badge/Pint-FF2D20?style=flat-square&logo=laravel&logoColor=white) [Laravel Pint](https://github.com/laravel/pint) - PHP formatter
-   ![Rector](https://img.shields.io/badge/Rector-777BB4?style=flat-square&logo=php&logoColor=white) [Rector](https://getrector.com/) - PHP refactoring
-   ![Stylelint](https://img.shields.io/badge/Stylelint-263238?style=flat-square&logo=stylelint&logoColor=white) [Stylelint](https://stylelint.io/) - Auto-fix CSS
-   ![Prettier](https://img.shields.io/badge/Prettier-F7B93E?style=flat-square&logo=prettier&logoColor=black) [Prettier](https://prettier.io/) - Code formatter

</details>

<details>
<summary><b>⚙️ Project Setup</b></summary>

| Command                           | Description                          |
| --------------------------------- | ------------------------------------ |
| `composer run replace-textdomain` | Replace textdomain with project name |
| `composer run copy-env`           | Copy environment configuration files |

</details>

---

## 🏗️ Build Process

The theme uses **TypeScript** for theme.json configuration with full type safety:

### 📁 Project Structure

```
src/theme/
├── theme.ts                    # Main theme configuration
├── theme.d.ts                  # Auto-generated TypeScript types
└── blocks/core/*/              # Block-specific settings and styles
    ├── blockname.ts            # Block configuration
    └── blockname.stylename.ts  # Block style variations → styles/blockname.stylename.json
```

### ✨ Features

-   **🎯 Type Safety**: TypeScript types auto-generated from official WordPress theme.json schema
-   **⚡ No Compilation**: Node.js loads TypeScript directly with `--experimental-strip-types` flag
-   **🎨 Block Styles**: Style variations (files matching `blockname.*.ts`) automatically generate separate JSON files in `styles/` directory
-   **🔄 Live Reload**: Watch mode automatically rebuilds when TypeScript files change

### 🚀 Workflows

<table>
<tr>
<td width="50%">

**Production**

```bash
npm run build
```

Complete production build with theme.json generation

</td>
<td width="50%">

**Development**

```bash
npm start
```

File watchers with automatic theme.json rebuild

</td>
</tr>
</table>
