# WordPress Theme Boilerplate

<p align="center">
  <img src="https://img.shields.io/badge/WordPress-6.8+-21759B?style=for-the-badge&logo=wordpress&logoColor=white" alt="WordPress">
  <img src="https://img.shields.io/badge/PHP-8.4+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Node-22.11+-339933?style=for-the-badge&logo=node.js&logoColor=white" alt="Node">
  <img src="https://img.shields.io/badge/TypeScript-5.9.3-3178C6?style=for-the-badge&logo=typescript&logoColor=white" alt="TypeScript 5.9.3">
  <img src="https://img.shields.io/badge/Rector-v2.2.9-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="Rector v2.2.9">
  <img src="https://img.shields.io/badge/License-GPL--2.0+-blue?style=for-the-badge" alt="License">
</p>

---

## 🛠️ Technologies

<table>
<tr>
<td valign="top">

**Frontend**

-   ![SCSS](https://img.shields.io/badge/SCSS-CC6699?style=flat-square&logo=sass&logoColor=white)
-   ![TypeScript](https://img.shields.io/badge/TypeScript-3178C6?style=flat-square&logo=typescript&logoColor=white)

</td>
<td valign="top">

**Build Tools**

-   ![WordPress](https://img.shields.io/badge/@wordpress/scripts-21759B?style=flat-square&logo=wordpress&logoColor=white)
-   ![Node.js](https://img.shields.io/badge/Node.js-339933?style=flat-square&logo=node.js&logoColor=white)

</td>
<td valign="top">

**Code Quality**

-   ![PHPStan](https://img.shields.io/badge/PHPStan-777BB4?style=flat-square&logo=php&logoColor=white)
-   ![Rector](https://img.shields.io/badge/Rector-777BB4?style=flat-square&logo=php&logoColor=white)
-   ![Stylelint](https://img.shields.io/badge/Stylelint-263238?style=flat-square&logo=stylelint&logoColor=white)
-   ![Pint](https://img.shields.io/badge/Pint-FF2D20?style=flat-square&logo=laravel&logoColor=white)

</td>
</tr>
</table>

---
---

## 📚 Documentation

-   [INSTALLATION.md](INSTALLATION.md): setup and requirements
-   [DEPENDENCIES.md](DEPENDENCIES.md): dependency overview
-   [CHANGELOG.md](CHANGELOG.md): release history
-   [.github/agents/THEME-HOW-IT-WORKS.md](.github/agents/THEME-HOW-IT-WORKS.md): high-level theme architecture
-   [.github/agents/THEME-JSON-WORKFLOW.md](.github/agents/THEME-JSON-WORKFLOW.md): TypeScript theme.json workflow
-   [.github/agents/THEME_AUTOCOMPLETION.md](.github/agents/THEME_AUTOCOMPLETION.md): preset and custom property autocomplete system

---

## 🚀 Installation

```bash
composer create-project ralfhortt/wordpress-theme-boilerplate
```

For detailed setup, see [INSTALLATION.md](INSTALLATION.md).

---

## 💻 Development

### Quick Start

```bash
npm start
```

Starts development watchers for assets, blocks, block styles, and theme configuration.

```bash
npm run build
```

Runs a production build for assets, blocks, and generated theme files.

### Main Commands

#### Build and Watch

| Command | Description |
| --- | --- |
| `npm run build` | Full production build |
| `npm start` | Start all development watchers |
| `npm run build:theme` | Build root theme.json from TypeScript config |
| `npm run watch:theme` | Watch TypeScript config and rebuild theme.json |
| `npm run generate:theme-types` | Refresh schema-derived theme TypeScript types |

#### Scaffolding and Helpers

| Command | Description |
| --- | --- |
| `npm run make:block` | Scaffold a new block |
| `npm run make:block-config` | Scaffold a TypeScript block config file |
| `npm run make:block-style` | Scaffold a block style variation config |
| `npm run make:pattern` | Scaffold a pattern file |
| `npm run css:clamp` | CSS clamp helper |
| `npm run css:color` | Color conversion helper |
| `npm run css:contrast` | Contrast helper |

#### Linting and Formatting

| Command | Description |
| --- | --- |
| `npm run lint` | Run Stylelint and PHP lint checks |
| `npm run lint:css` | Run Stylelint for SCSS |
| `npm run lint:css:fix` | Auto-fix Stylelint issues |
| `npm run lint:php` | Run PHP lint via Composer scripts |
| `composer run lint:php` | Run PHPStan analysis |
| `composer run format` | Format PHP with Pint |
| `composer run refactor` | Apply Rector refactors |
| `composer run refactor:dry` | Preview Rector refactors |

### Commit Workflow

This repository enforces commit quality checks through Husky hooks:

-   Pre-commit: runs Rector and Pint on staged PHP files, then lint checks.
-   Commit-msg: enforces Conventional Commits format.

Example commit messages:

-   `feat: add starter pattern scaffold`
-   `fix: handle empty post type input`
-   `chore: update lint tooling`

---

## 🏗️ Theme Architecture

The project uses a TypeScript-first workflow for theme configuration.

### Source of Truth

-   `src/blocks/theme.ts`: base theme configuration
-   `src/blocks/core/`: per-core-block config modules
-   `theme.json`: generated output consumed by WordPress

### Build Flow

1. Edit files in `src/blocks/`.
2. Run `npm run build:theme` or `npm run build`.
3. Commit source changes and generated outputs as needed by your workflow.

For full details, see [.github/agents/THEME-JSON-WORKFLOW.md](.github/agents/THEME-JSON-WORKFLOW.md).
