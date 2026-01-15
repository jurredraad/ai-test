<?php
/**
 * Two Column Block
 *
 * @package AI_Test_Child
 */

if ( ! function_exists( 'acf_register_block_type' ) ) {
    return;
}

acf_register_block_type( array(
    'name'              => 'two-column',
    'title'             => __( 'Two Column Layout', 'ai-test-child' ),
    'description'       => __( 'A flexible two-column layout with customizable content.', 'ai-test-child' ),
    'render_template'   => get_stylesheet_directory() . '/blocks/two-column/template.php',
    'category'          => 'layout',
    'icon'              => 'columns',
    'keywords'          => array( 'two column', 'columns', 'layout', 'grid' ),
    'supports'          => array(
        'align'         => array( 'wide', 'full' ),
        'anchor'        => true,
        'mode'          => true,
        'jsx'           => true,
    ),
    'enqueue_assets'    => function() {
        wp_enqueue_style( 
            'block-two-column', 
            get_stylesheet_directory_uri() . '/blocks/two-column/style.css',
            array(),
            filemtime( get_stylesheet_directory() . '/blocks/two-column/style.css' )
        );
    },
) );
