<?php
/**
 * Hero Block Template
 *
 * @package AI_Test_Child
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'hero-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'hero-block';
if ( ! empty( $block['className'] ) ) {
    $className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $className .= ' align' . $block['align'];
}

// Load values and handle defaults.
$title          = get_field( 'title' ) ?: 'Your Hero Title';
$subtitle       = get_field( 'subtitle' ) ?: 'Add a compelling subtitle here';
$button_text    = get_field( 'button_text' ) ?: '';
$button_link    = get_field( 'button_link' ) ?: '';
$background_image = get_field( 'background_image' );
$overlay_opacity = get_field( 'overlay_opacity' ) ?: 50;
$text_alignment = get_field( 'text_alignment' ) ?: 'center';

?>
<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?>" style="<?php echo $background_image ? 'background-image: url(' . esc_url( $background_image['url'] ) . ');' : ''; ?>">
    <div class="hero-overlay" style="opacity: <?php echo esc_attr( $overlay_opacity / 100 ); ?>;"></div>
    <div class="container">
        <div class="hero-content" style="text-align: <?php echo esc_attr( $text_alignment ); ?>;">
            <h1 class="hero-title"><?php echo esc_html( $title ); ?></h1>
            <?php if ( $subtitle ) : ?>
                <p class="hero-subtitle"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>
            <?php if ( $button_text && $button_link ) : ?>
                <a href="<?php echo esc_url( $button_link ); ?>" class="hero-button"><?php echo esc_html( $button_text ); ?></a>
            <?php endif; ?>
        </div>
    </div>
</section>
