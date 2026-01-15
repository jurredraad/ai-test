# ACF Reusable Field Components Guide

## Overview

The ACF reusable field components system allows you to create consistent, DRY (Don't Repeat Yourself) ACF field definitions that can be shared across multiple blocks.

## Architecture

### Component Directory Structure

```
themes/ai-test-child/acf-components/
├── button.php          # CTA button fields (text, url, style, target)
├── heading.php         # Title/heading fields (text, tag, alignment, subtitle)
├── background.php      # Background image/color/overlay/position/size
├── spacing.php         # Margin/padding control fields
└── content.php         # WYSIWYG content editor fields
```

### How It Works

1. **Component files** contain PHP functions that return ACF field arrays
2. **Components are autoloaded** in `functions.php` on theme initialization
3. **Blocks compose fields** by using `array_merge()` to combine component outputs
4. **Fields are customizable** through configuration arrays passed to component functions

## Available Components

### 1. Button Component (`button.php`)

Creates fields for call-to-action buttons.

**Function:** `ai_test_get_button_fields( $prefix, $config )`

**Configuration options:**
```php
$config = array(
    'show_style'  => true,  // Show button style selector
    'show_target' => true,  // Show "open in new tab" option
    'required'    => false, // Make fields required
);
```

**Fields created:**
- Button text (text)
- Button URL (url)
- Open in new tab (true/false) - optional
- Button style (select: primary/secondary/outline/text) - optional

**Example usage:**
```php
ai_test_get_button_fields( 'hero_cta', array(
    'show_style'  => true,
    'show_target' => true,
) )
```

### 2. Heading Component (`heading.php`)

Creates fields for headings and titles.

**Function:** `ai_test_get_heading_fields( $prefix, $config )`

**Configuration options:**
```php
$config = array(
    'show_tag'       => true,   // Show HTML tag selector (h1-h6)
    'show_alignment' => true,   // Show text alignment options
    'show_subtitle'  => false,  // Show subtitle field
    'required'       => false,  // Make heading required
    'label'          => 'Heading', // Custom field label
);
```

**Fields created:**
- Heading text (text)
- Subtitle (textarea) - optional
- Heading tag (select: h1-h6) - optional
- Text alignment (button_group: left/center/right) - optional

**Example usage:**
```php
ai_test_get_heading_fields( 'section_title', array(
    'label'          => 'Section Title',
    'show_subtitle'  => true,
    'show_tag'       => true,
    'show_alignment' => true,
    'required'       => true,
) )
```

### 3. Background Component (`background.php`)

Creates fields for background styling.

**Function:** `ai_test_get_background_fields( $prefix, $config )`

**Configuration options:**
```php
$config = array(
    'show_color'      => true,  // Show background color picker
    'show_overlay'    => true,  // Show overlay color/opacity
    'show_position'   => true,  // Show background position
    'show_size'       => true,  // Show background size
    'required_image'  => false, // Make image required
);
```

**Fields created:**
- Background image (image)
- Background color (color_picker) - optional
- Background position (select) - optional, conditional on image
- Background size (select) - optional, conditional on image
- Overlay color (color_picker) - optional
- Overlay opacity (range: 0-100) - optional

**Example usage:**
```php
ai_test_get_background_fields( 'hero_bg', array(
    'show_color'   => true,
    'show_overlay' => true,
    'show_position'=> true,
    'show_size'    => true,
) )
```

### 4. Spacing Component (`spacing.php`)

Creates fields for controlling spacing (padding/margin).

**Function:** `ai_test_get_spacing_fields( $prefix, $config )`

**Configuration options:**
```php
$config = array(
    'show_padding' => true,  // Show padding controls
    'show_margin'  => true,  // Show margin controls
    'label'        => 'Spacing',
);
```

**Fields created:**
- Padding top (select: none/small/medium/large/xlarge) - optional
- Padding bottom (select) - optional
- Margin top (select) - optional
- Margin bottom (select) - optional

**Helper function:** `ai_test_get_spacing_classes( $prefix, $type )`

Converts spacing field values to CSS utility classes.

**Example usage:**
```php
// In block.php
ai_test_get_spacing_fields( 'block_spacing', array(
    'show_padding' => true,
    'show_margin'  => false,
) )

// In template.php
$className .= ' ' . ai_test_get_spacing_classes( 'block_spacing', 'padding' );
```

### 5. Content Component (`content.php`)

Creates WYSIWYG editor field.

**Function:** `ai_test_get_content_fields( $prefix, $config )`

**Configuration options:**
```php
$config = array(
    'label'        => 'Content',
    'required'     => false,
    'toolbar'      => 'full',      // 'full' or 'basic'
    'media_upload' => true,
);
```

**Fields created:**
- WYSIWYG editor with customizable toolbar

**Example usage:**
```php
ai_test_get_content_fields( 'main_content', array(
    'label'        => 'Main Content',
    'toolbar'      => 'basic',
    'media_upload' => false,
) )
```

## Creating a Block with Components

### Step 1: Create Block File Structure

```
blocks/my-block/
├── block.php
├── template.php
└── style.css
```

### Step 2: Register Block with Components (block.php)

```php
<?php
/**
 * My Block
 *
 * @package AI_Test_Child
 */

if ( ! function_exists( 'acf_register_block_type' ) ) {
    return;
}

acf_register_block_type( array(
    'name'              => 'my-block',
    'title'             => __( 'My Block', 'ai-test-child' ),
    'description'       => __( 'My custom block with components.', 'ai-test-child' ),
    'render_template'   => get_stylesheet_directory() . '/blocks/my-block/template.php',
    'category'          => 'layout',
    'icon'              => 'admin-page',
    'keywords'          => array( 'my', 'block' ),
    'supports'          => array(
        'align' => array( 'wide', 'full' ),
        'anchor' => true,
    ),
    'enqueue_assets' => function() {
        wp_enqueue_style( 
            'block-my-block', 
            get_stylesheet_directory_uri() . '/blocks/my-block/style.css',
            array(),
            filemtime( get_stylesheet_directory() . '/blocks/my-block/style.css' )
        );
    },
) );

/**
 * Register ACF fields using components
 */
if ( function_exists( 'acf_add_local_field_group' ) ) {
    acf_add_local_field_group( array(
        'key'    => 'group_my_block',
        'title'  => 'My Block Fields',
        'fields' => array_merge(
            // Add heading component
            ai_test_get_heading_fields( 'my_heading', array(
                'label'          => 'Block Title',
                'show_subtitle'  => true,
                'show_tag'       => true,
                'show_alignment' => true,
                'required'       => true,
            ) ),
            
            // Add content component
            ai_test_get_content_fields( 'my_content', array(
                'label'    => 'Block Content',
                'toolbar'  => 'full',
            ) ),
            
            // Add button component
            ai_test_get_button_fields( 'my_button', array(
                'show_style'  => true,
                'show_target' => true,
            ) ),
            
            // Add background component
            ai_test_get_background_fields( 'my_background', array(
                'show_color'   => true,
                'show_overlay' => false,
            ) ),
            
            // Add spacing component
            ai_test_get_spacing_fields( 'my_spacing', array(
                'show_padding' => true,
                'show_margin'  => false,
            ) )
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'block',
                    'operator' => '==',
                    'value'    => 'acf/my-block',
                ),
            ),
        ),
        'active' => true,
    ) );
}
```

### Step 3: Create Template (template.php)

```php
<?php
/**
 * My Block Template
 *
 * @package AI_Test_Child
 */

// Setup
$id = 'my-block-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
    $id = $block['anchor'];
}

$className = 'my-block';
if ( ! empty( $block['className'] ) ) {
    $className .= ' ' . $block['className'];
}

// Add spacing classes
if ( function_exists( 'ai_test_get_spacing_classes' ) ) {
    $className .= ' ' . ai_test_get_spacing_classes( 'my_spacing', 'padding' );
}

// Get field values
$heading_text      = get_field( 'my_heading_text' );
$heading_subtitle  = get_field( 'my_heading_subtitle' );
$heading_tag       = get_field( 'my_heading_tag' ) ?: 'h2';
$heading_alignment = get_field( 'my_heading_alignment' ) ?: 'left';

$content = get_field( 'my_content' );

$button_text   = get_field( 'my_button_text' );
$button_url    = get_field( 'my_button_url' );
$button_style  = get_field( 'my_button_style' ) ?: 'primary';
$button_target = get_field( 'my_button_target' ) ? '_blank' : '_self';

$bg_image = get_field( 'my_background_image' );
$bg_color = get_field( 'my_background_color' );

// Build styles
$styles = array();
if ( $bg_image && isset( $bg_image['url'] ) ) {
    $styles[] = 'background-image: url(' . esc_url( $bg_image['url'] ) . ')';
} elseif ( $bg_color ) {
    $styles[] = 'background-color: ' . esc_attr( $bg_color );
}
$style_attr = ! empty( $styles ) ? ' style="' . implode( '; ', $styles ) . '"' : '';

?>
<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?>"<?php echo $style_attr; ?>>
    <div class="container">
        <div style="text-align: <?php echo esc_attr( $heading_alignment ); ?>;">
            <?php
            $tag = esc_attr( $heading_tag );
            echo "<{$tag}>" . esc_html( $heading_text ) . "</{$tag}>";
            ?>
            
            <?php if ( $heading_subtitle ) : ?>
                <p class="subtitle"><?php echo esc_html( $heading_subtitle ); ?></p>
            <?php endif; ?>
            
            <?php if ( $content ) : ?>
                <div class="content">
                    <?php echo wp_kses_post( $content ); ?>
                </div>
            <?php endif; ?>
            
            <?php if ( $button_text && $button_url ) : ?>
                <a href="<?php echo esc_url( $button_url ); ?>" 
                   class="button button-<?php echo esc_attr( $button_style ); ?>"
                   target="<?php echo esc_attr( $button_target ); ?>"
                   <?php echo $button_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>>
                    <?php echo esc_html( $button_text ); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
```

## Example Block: Feature Block

See `blocks/feature/` for a complete working example that uses all five components:
- Heading component (with subtitle, tag selector, alignment)
- Content component (WYSIWYG editor)
- Button component (with style and target options)
- Background component (image and color)
- Spacing component (padding controls)

## Benefits

1. **Consistency**: Same field types across all blocks
2. **DRY**: Define field structure once, reuse everywhere
3. **Maintainability**: Update field config in one place
4. **Faster Development**: Quickly compose new blocks from existing components
5. **Flexibility**: Configure components per-block needs
6. **Type Safety**: Consistent field naming conventions

## Field Naming Convention

Components use prefixed field names to avoid conflicts:

- Prefix format: `{prefix}_{field_name}`
- Example: `hero_button_text`, `feature_heading_tag`

This allows using the same component multiple times in one block with different prefixes.

## Adding New Components

To create a new reusable component:

1. Create file in `acf-components/` (e.g., `gallery.php`)
2. Create function that returns ACF field array
3. Add file to autoloader in `functions.php`
4. Use component in blocks with `array_merge()`

Example component structure:
```php
<?php
function ai_test_get_COMPONENT_fields( $prefix = 'component', $config = array() ) {
    $defaults = array(
        // Default configuration
    );
    
    $config = wp_parse_args( $config, $defaults );
    
    $fields = array(
        // ACF field definitions
    );
    
    return $fields;
}
```

## Troubleshooting

**Issue**: Component functions not found
**Solution**: Ensure components are loaded in `functions.php` with `ai_test_child_load_acf_components()`

**Issue**: Fields not showing in block
**Solution**: Check that `acf_add_local_field_group()` is called and field names match template usage

**Issue**: Spacing classes not applying
**Solution**: Ensure `ai_test_get_spacing_classes()` is called in template and utility classes exist in CSS

## Resources

- [ACF Documentation](https://www.advancedcustomfields.com/resources/)
- [ACF Local Field Groups](https://www.advancedcustomfields.com/resources/register-fields-via-php/)
- Feature block example: `blocks/feature/`
