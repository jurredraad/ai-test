<?php
/**
 * Feature Block Template
 *
 * @package AI_Test_Child
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'feature-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'feature-block';
if ( ! empty( $block['className'] ) ) {
    $className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $className .= ' align' . $block['align'];
}

// Add spacing classes
if ( function_exists( 'ai_test_get_spacing_classes' ) ) {
    $className .= ' ' . ai_test_get_spacing_classes( 'feature_spacing', 'padding' );
}

// Load values
$heading_text      = get_field( 'feature_heading_text' ) ?: 'Feature Heading';
$heading_subtitle  = get_field( 'feature_heading_subtitle' );
$heading_tag       = get_field( 'feature_heading_tag' ) ?: 'h2';
$heading_alignment = get_field( 'feature_heading_alignment' ) ?: 'left';

$content = get_field( 'feature_content' );

$button_text   = get_field( 'feature_button_text' );
$button_url    = get_field( 'feature_button_url' );
$button_target = get_field( 'feature_button_target' ) ? '_blank' : '_self';
$button_style  = get_field( 'feature_button_style' ) ?: 'primary';

$bg_image = get_field( 'feature_background_image' );
$bg_color = get_field( 'feature_background_color' ) ?: '#ffffff';

// Build inline styles
$inline_styles = array();
if ( $bg_image && isset( $bg_image['url'] ) ) {
    $inline_styles[] = 'background-image: url(' . esc_url( $bg_image['url'] ) . ')';
    $inline_styles[] = 'background-size: cover';
    $inline_styles[] = 'background-position: center';
} elseif ( $bg_color ) {
    $inline_styles[] = 'background-color: ' . esc_attr( $bg_color );
}

$style_attr = ! empty( $inline_styles ) ? ' style="' . implode( '; ', $inline_styles ) . '"' : '';

?>
<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?>"<?php echo $style_attr; ?>>
    <div class="container">
        <div class="feature-content" style="text-align: <?php echo esc_attr( $heading_alignment ); ?>;">
            <?php
            $heading_open  = '<' . esc_attr( $heading_tag ) . ' class="feature-heading">';
            $heading_close = '</' . esc_attr( $heading_tag ) . '>';
            echo $heading_open . esc_html( $heading_text ) . $heading_close;
            ?>
            
            <?php if ( $heading_subtitle ) : ?>
                <p class="feature-subtitle"><?php echo esc_html( $heading_subtitle ); ?></p>
            <?php endif; ?>
            
            <?php if ( $content ) : ?>
                <div class="feature-description">
                    <?php echo wp_kses_post( $content ); ?>
                </div>
            <?php endif; ?>
            
            <?php if ( $button_text && $button_url ) : ?>
                <a href="<?php echo esc_url( $button_url ); ?>" 
                   class="feature-button button-<?php echo esc_attr( $button_style ); ?>"
                   target="<?php echo esc_attr( $button_target ); ?>"
                   <?php echo $button_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>>
                    <?php echo esc_html( $button_text ); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
