# ACF Blocks Setup Guide

This theme now supports **Advanced Custom Fields (ACF) blocks** for building flexible, custom Gutenberg blocks with PHP templates and ACF field groups.

## Requirements

- WordPress 6.0+
- **ACF Pro 6.0+** (required for ACF blocks feature)
- PHP 7.4+

## Installing ACF Pro

1. Purchase ACF Pro from [advancedcustomfields.com](https://www.advancedcustomfields.com/pro/)
2. Download the plugin
3. Install via WordPress Admin → Plugins → Add New → Upload Plugin
4. Activate the plugin

## Features

### ✅ ACF Block Support
- Automatic block registration from `/blocks` directories
- ACF JSON for version-controlled field groups
- Both parent and child theme support ACF blocks

### ✅ Layout CSS Framework
- Responsive grid system (12-column)
- Container utilities (container, container-fluid, container-narrow, container-wide)
- Flexbox utilities
- Spacing utilities (margin, padding)
- Section spacing classes
- Mobile-first responsive breakpoints

### ✅ Sample ACF Blocks Included

#### Hero Section Block
- Full-width hero with background image
- Customizable title, subtitle, and CTA button
- Adjustable overlay opacity
- Text alignment options

#### Two Column Layout Block
- Flexible column ratios (50/50, 60/40, 40/60, 70/30, 30/70)
- Vertical alignment options
- Reverse columns on mobile option
- WYSIWYG editors for both columns

## Creating ACF Blocks

### Method 1: CLI Tool

```bash
npm run create-acf-block
```

This will prompt you for:
- Block name
- Description
- Category
- Icon

It creates:
- `block.php` - Block registration
- `template.php` - Block template
- `style.css` - Block styles
- `acf-json/group_*_block.json` - ACF field group

### Method 2: Manual Creation

1. Create a new directory in `themes/ai-test-child/blocks/your-block-name/`

2. Create `block.php`:
```php
<?php
acf_register_block_type( array(
    'name'              => 'your-block',
    'title'             => __( 'Your Block', 'ai-test-child' ),
    'description'       => __( 'Block description', 'ai-test-child' ),
    'render_template'   => get_stylesheet_directory() . '/blocks/your-block/template.php',
    'category'          => 'layout',
    'icon'              => 'admin-page',
    'supports'          => array(
        'align' => array( 'wide', 'full' ),
        'anchor' => true,
    ),
) );
```

3. Create `template.php`:
```php
<?php
$id = 'your-block-' . $block['id'];
$className = 'your-block';

$title = get_field( 'title' );
?>
<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?>">
    <h2><?php echo esc_html( $title ); ?></h2>
</section>
```

4. Create `style.css` with your block styles

5. Create ACF fields in WordPress Admin or via ACF JSON

## Using Layout Classes

### Containers

```html
<div class="container">
    <!-- Max-width 1200px, centered -->
</div>

<div class="container-narrow">
    <!-- Max-width 800px, centered -->
</div>

<div class="container-wide">
    <!-- Max-width 1400px, centered -->
</div>
```

### Grid System

```html
<div class="row">
    <div class="col-12 col-md-6 col-lg-4">
        <!-- Full width mobile, half on tablet, third on desktop -->
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <!-- Column 2 -->
    </div>
    <div class="col-12 col-md-12 col-lg-4">
        <!-- Column 3 -->
    </div>
</div>
```

### Flexbox Utilities

```html
<div class="d-flex justify-content-between align-items-center">
    <!-- Flex container with space between and centered items -->
</div>
```

### Spacing

```html
<div class="mt-5 mb-3 p-4">
    <!-- Margin top 3rem, margin bottom 1rem, padding 1.5rem -->
</div>
```

### Section Spacing

```html
<section class="section">
    <!-- Padding 60px top/bottom -->
</section>

<section class="section-lg">
    <!-- Padding 80px top/bottom -->
</section>
```

## ACF JSON

Field groups are stored in `themes/ai-test-child/acf-json/` for version control:

- Automatically exports field groups to JSON when saved
- Automatically imports field groups from JSON on load
- Allows field groups to be version controlled in Git
- Syncing available in WordPress Admin → Custom Fields

## Block Template Example

Here's a complete template using layout classes:

```php
<?php
$title = get_field( 'title' );
$content = get_field( 'content' );
$image = get_field( 'image' );
?>
<section class="section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h2 class="mb-3"><?php echo esc_html( $title ); ?></h2>
                <div class="content">
                    <?php echo wp_kses_post( $content ); ?>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <?php if ( $image ) : ?>
                    <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
```

## Troubleshooting

### ACF blocks not appearing
- Ensure ACF Pro is installed and activated
- Check that block.php files exist in block directories
- Verify functions.php is registering blocks on `acf/init` hook

### Field groups not loading
- Check that acf-json directory exists
- Verify JSON files are properly formatted
- Try syncing in WordPress Admin → Custom Fields

### Styles not loading
- Ensure style.css exists in block directory
- Check that enqueue_assets callback is properly configured
- Clear browser cache

## Resources

- [ACF Blocks Documentation](https://www.advancedcustomfields.com/resources/blocks/)
- [ACF JSON Documentation](https://www.advancedcustomfields.com/resources/local-json/)
- Layout CSS classes reference in `themes/ai-test-parent/assets/css/layout.css`

## Migration from Standard Gutenberg Blocks

If you have existing standard Gutenberg blocks (using JavaScript), you can:

1. Keep them as-is (they'll still work)
2. Convert to ACF blocks by creating PHP templates
3. Use both types in the same theme

The theme supports both ACF blocks and standard Gutenberg blocks simultaneously.
