# WordPress Gutenberg Block Development Setup

## Project Overview

This repository provides a complete WordPress development environment with:

1. **Parent Theme (`ai-test-parent`)** - A minimal, blank WordPress theme
2. **Child Theme (`ai-test-child`)** - Extends the parent theme with custom Gutenberg blocks
3. **Block Development Tools** - Scripts to create blocks manually or with AI-assisted templates
4. **Build System** - Webpack-based compilation using @wordpress/scripts

## Quick Start

### Installation

```bash
# Install dependencies
npm install

# Build the sample block
npm run build
```

### Creating Blocks

**Method 1: Basic Block Creator**
```bash
npm run create-block
```
Interactive CLI that creates a simple block with RichText editing.

**Method 2: AI-Assisted Block Creator**
```bash
npm run ai-block
```
Choose from pre-built templates:
- Call to Action (gradient background, button)
- Testimonial (quote with author)
- Feature Box (icon, title, description)
- Custom (basic template)

### Using in WordPress

1. Copy themes to your WordPress installation:
```bash
cp -r themes/ai-test-parent /path/to/wordpress/wp-content/themes/
cp -r themes/ai-test-child /path/to/wordpress/wp-content/themes/
```

2. Activate "AI Test Child" theme in WordPress Admin

3. Use blocks in the Gutenberg editor

## Project Structure

```
ai-test/
├── themes/
│   ├── ai-test-parent/          # Parent theme
│   │   ├── style.css
│   │   ├── functions.php
│   │   ├── header.php
│   │   ├── footer.php
│   │   └── index.php
│   │
│   └── ai-test-child/           # Child theme
│       ├── style.css
│       ├── functions.php
│       └── blocks/              # Custom blocks
│           └── sample-block/
│               ├── block.json   # Block configuration
│               ├── src/         # Source files
│               │   ├── index.js
│               │   ├── editor.scss
│               │   └── style.scss
│               └── build/       # Compiled files (auto-generated)
│
├── scripts/
│   ├── create-block.js          # Basic block generator
│   └── ai-block-creator.js      # AI template-based generator
│
├── package.json
├── webpack.config.js            # Auto-detects blocks
├── README.md                    # This file
├── QUICKSTART.md                # Quick start guide
└── WORDPRESS_SETUP.md           # Detailed documentation
```

## Development Workflow

### 1. Create a Block

Run one of the block creation commands:
```bash
npm run ai-block
```

### 2. Build the Block

Development mode (watch for changes):
```bash
npm start
```

Production build:
```bash
npm run build
```

### 3. Test in WordPress

The webpack configuration automatically detects all blocks in `themes/ai-test-child/blocks/*/src/index.js`, so no manual configuration is needed when adding new blocks.

## Features

### Parent Theme
- Minimal, clean design
- Full Gutenberg editor support
- Automatic block registration
- Responsive layout
- Theme functions for WordPress best practices

### Child Theme
- Inherits all parent theme features
- Custom block support
- Independent from parent updates
- Easy to customize

### Block Development Tools

**Basic Block Creator** (`create-block.js`)
- Interactive prompts for block metadata
- Creates basic block structure
- Includes RichText editing
- Customizable styling

**AI Block Creator** (`ai-block-creator.js`)
- Pre-built templates for common patterns
- Professional styling included
- Hover effects and animations
- Ready to use out of the box

### Build System
- Automatic block detection
- Webpack-based compilation
- SCSS support
- Production optimization
- Source maps for debugging

## Documentation

- **[QUICKSTART.md](QUICKSTART.md)** - Get started in 3 steps
- **[WORDPRESS_SETUP.md](WORDPRESS_SETUP.md)** - Complete setup guide and documentation

## Block Templates

The AI-assisted creator includes these templates:

### Call to Action
- Gradient background
- Title and description
- Customizable button with URL
- Hover animations

### Testimonial
- Quote styling with quotation marks
- Author attribution
- Role/company field
- Professional design

### Feature Box
- Icon/emoji support
- Title and description
- Card design with hover effects
- Perfect for feature grids

## Requirements

- Node.js 14+
- npm or yarn
- WordPress 6.0+
- PHP 7.4+

## Scripts

- `npm install` - Install dependencies
- `npm run build` - Build blocks for production
- `npm start` - Start development mode (watch)
- `npm run create-block` - Create a basic block
- `npm run ai-block` - Create a block from templates

## Support

For issues or questions, please refer to:
- [WordPress Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- [@wordpress/scripts Documentation](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/)

## License

GPL-2.0-or-later

## Notes

- Build artifacts (`build/` directories, compiled CSS/JS) are gitignored
- The webpack config automatically detects new blocks
- Blocks can be created in either the parent or child theme
- The child theme is recommended for custom blocks
