# ai-test

This is a WordPress development environment with blank parent and child themes, **ACF (Advanced Custom Fields) block support**, and AI-assisted block creation tools.

## Quick Start

```bash
npm install
npm run build
```

See [ACF_BLOCKS_GUIDE.md](ACF_BLOCKS_GUIDE.md) for ACF blocks setup and [WORDPRESS_SETUP.md](WORDPRESS_SETUP.md) for complete documentation.

## Features

- 🎨 Blank WordPress parent theme with layout CSS framework
- 👶 Child theme ready for customization
- 🧱 **ACF Pro blocks support** (PHP-based custom blocks)
- 📐 Responsive layout system (grid, flexbox, spacing utilities)
- 🧱 Standard Gutenberg block development environment
- 🤖 AI-assisted block creator with templates
- 🛠️ CLI tools for creating blocks via terminal

## Creating ACF Blocks

```bash
# Create ACF block (recommended)
npm run create-acf-block

# Basic Gutenberg block creator
npm run create-block

# AI-assisted with templates
npm run ai-block
```

## Layout System

The theme includes a comprehensive CSS layout framework:
- Responsive grid system (12-column)
- Container utilities (standard, narrow, wide, fluid)
- Flexbox utilities
- Spacing utilities (margin, padding)
- Section spacing classes

See `themes/ai-test-parent/assets/css/layout.css` for all available classes.

## Sample ACF Blocks

Two sample ACF blocks are included:
- **Hero Section** - Full-width hero with background, overlay, and CTA
- **Two Column Layout** - Flexible 2-column layout with multiple ratio options

## Requirements

- **ACF Pro 6.0+** (for ACF blocks feature)
- WordPress 6.0+
- PHP 7.4+
- Node.js 14+
