<?php
/**
 * Hero Block
 *
 * @package AI_Test_Child
 */

if ( ! function_exists( 'acf_register_block_type' ) ) {
    return;
}

acf_register_block_type( array(
    'name'              => 'hero',
    'title'             => __( 'Hero Section', 'ai-test-child' ),
    'description'       => __( 'A hero section with title, subtitle, and background image.', 'ai-test-child' ),
    'render_template'   => get_stylesheet_directory() . '/blocks/hero/template.php',
    'category'          => 'layout',
    'icon'              => 'cover-image',
    'keywords'          => array( 'hero', 'banner', 'header' ),
    'supports'          => array(
        'align'         => array( 'wide', 'full' ),
        'anchor'        => true,
        'mode'          => true,
        'jsx'           => true,
    ),
    'enqueue_assets'    => function() {
        wp_enqueue_style( 
            'block-hero', 
            get_stylesheet_directory_uri() . '/blocks/hero/style.css',
            array(),
            filemtime( get_stylesheet_directory() . '/blocks/hero/style.css' )
        );
    },
) );
