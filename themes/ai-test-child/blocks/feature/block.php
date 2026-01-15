<?php
/**
 * Feature Block - Example using reusable ACF components
 *
 * @package AI_Test_Child
 */

if ( ! function_exists( 'acf_register_block_type' ) ) {
    return;
}

acf_register_block_type( array(
    'name'              => 'feature',
    'title'             => __( 'Feature Block', 'ai-test-child' ),
    'description'       => __( 'A feature block with heading, content, and CTA button.', 'ai-test-child' ),
    'render_template'   => get_stylesheet_directory() . '/blocks/feature/template.php',
    'category'          => 'layout',
    'icon'              => 'star-filled',
    'keywords'          => array( 'feature', 'content', 'cta' ),
    'supports'          => array(
        'align'         => array( 'wide', 'full' ),
        'anchor'        => true,
        'mode'          => true,
        'jsx'           => true,
    ),
    'enqueue_assets'    => function() {
        wp_enqueue_style( 
            'block-feature', 
            get_stylesheet_directory_uri() . '/blocks/feature/style.css',
            array(),
            filemtime( get_stylesheet_directory() . '/blocks/feature/style.css' )
        );
    },
) );

/**
 * Register ACF fields for Feature block using reusable components
 */
if ( function_exists( 'acf_add_local_field_group' ) ) {
    acf_add_local_field_group( array(
        'key'      => 'group_feature_block',
        'title'    => 'Feature Block Fields',
        'fields'   => array_merge(
            // Heading component with subtitle
            ai_test_get_heading_fields( 'feature_heading', array(
                'label'          => 'Feature Heading',
                'show_subtitle'  => true,
                'show_tag'       => true,
                'show_alignment' => true,
                'required'       => true,
            ) ),
            // Content component
            ai_test_get_content_fields( 'feature_content', array(
                'label'        => 'Feature Description',
                'toolbar'      => 'basic',
                'media_upload' => false,
            ) ),
            // Button component
            ai_test_get_button_fields( 'feature_button', array(
                'show_style'  => true,
                'show_target' => true,
            ) ),
            // Background component
            ai_test_get_background_fields( 'feature_background', array(
                'show_color'   => true,
                'show_overlay' => false,
                'show_position'=> false,
                'show_size'    => false,
            ) ),
            // Spacing component
            ai_test_get_spacing_fields( 'feature_spacing', array(
                'show_padding' => true,
                'show_margin'  => false,
            ) )
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'block',
                    'operator' => '==',
                    'value'    => 'acf/feature',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
    ) );
}
