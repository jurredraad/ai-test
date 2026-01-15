<?php
/**
 * Two Column Block Template
 *
 * @package AI_Test_Child
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'two-column-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'two-column-block';
if ( ! empty( $block['className'] ) ) {
    $className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $className .= ' align' . $block['align'];
}

// Load values and handle defaults.
$column_ratio       = get_field( 'column_ratio' ) ?: '50-50';
$reverse_on_mobile  = get_field( 'reverse_on_mobile' ) ?: false;
$vertical_alignment = get_field( 'vertical_alignment' ) ?: 'center';
$left_content       = get_field( 'left_content' );
$right_content      = get_field( 'right_content' );

// Add reverse class if needed
if ( $reverse_on_mobile ) {
    $className .= ' reverse-mobile';
}

// Add ratio class
$className .= ' ratio-' . $column_ratio;

// Add vertical alignment class
$className .= ' align-' . $vertical_alignment;

?>
<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?>">
    <div class="container">
        <div class="row">
            <div class="column column-left">
                <?php echo wp_kses_post( $left_content ); ?>
            </div>
            <div class="column column-right">
                <?php echo wp_kses_post( $right_content ); ?>
            </div>
        </div>
    </div>
</section>
