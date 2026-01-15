# ai-test

This is a WordPress development environment with blank parent and child themes, **ACF (Advanced Custom Fields) block support** with **reusable field components**, and AI-assisted block creation tools.

## Quick Start

```bash
npm install
npm run build
```

See [ACF_BLOCKS_GUIDE.md](ACF_BLOCKS_GUIDE.md) for ACF blocks setup, [ACF_COMPONENTS_GUIDE.md](ACF_COMPONENTS_GUIDE.md) for reusable components, and [WORDPRESS_SETUP.md](WORDPRESS_SETUP.md) for complete documentation.

## Features

- 🎨 Blank WordPress parent theme with layout CSS framework
- 👶 Child theme ready for customization
- 🧱 **ACF Pro blocks support** (PHP-based custom blocks)
- 🔧 **Reusable ACF field components** (button, heading, background, spacing, content)
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

## Reusable ACF Components

Create blocks faster with reusable field components:

```php
// In block.php
acf_add_local_field_group( array(
    'fields' => array_merge(
        ai_test_get_heading_fields( 'my_title', array(
            'show_subtitle' => true,
            'required' => true,
        ) ),
        ai_test_get_button_fields( 'my_cta' ),
        ai_test_get_background_fields( 'my_bg' ),
    ),
    // ... location config
) );
```

Available components:
- **Button** - CTA button with text, URL, style, target
- **Heading** - Title with tag selector, alignment, optional subtitle
- **Background** - Image, color, overlay, position, size
- **Spacing** - Padding/margin controls with CSS class helpers
- **Content** - WYSIWYG editor

See [ACF_COMPONENTS_GUIDE.md](ACF_COMPONENTS_GUIDE.md) for complete documentation.

## Layout System

The theme includes a comprehensive CSS layout framework:
- Responsive grid system (12-column)
- Container utilities (standard, narrow, wide, fluid)
- Flexbox utilities
- Spacing utilities (margin, padding)
- Section spacing classes

See `themes/ai-test-parent/assets/css/layout.css` for all available classes.

## Sample ACF Blocks

Three sample ACF blocks are included:
- **Hero Section** - Full-width hero with background, overlay, and CTA
- **Two Column Layout** - Flexible 2-column layout with multiple ratio options
- **Feature Block** - Example using all 5 reusable components

## Requirements

- **ACF Pro 6.0+** (for ACF blocks feature)
- WordPress 6.0+
- PHP 7.4+
- Node.js 14+
