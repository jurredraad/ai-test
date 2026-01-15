<?php
/**
 * Reusable ACF Heading Field Component
 * 
 * Provides heading/title fields (text, tag, alignment)
 *
 * @package AI_Test_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get heading field configuration
 *
 * @param string $prefix Field name prefix for uniqueness
 * @param array  $config Optional configuration overrides
 * @return array ACF field configuration
 */
function ai_test_get_heading_fields( $prefix = 'heading', $config = array() ) {
    $defaults = array(
        'show_tag'       => true,
        'show_alignment' => true,
        'show_subtitle'  => false,
        'required'       => false,
        'label'          => 'Heading',
    );
    
    $config = wp_parse_args( $config, $defaults );
    
    $fields = array(
        array(
            'key'           => "field_{$prefix}_text",
            'label'         => $config['label'],
            'name'          => "{$prefix}_text",
            'type'          => 'text',
            'instructions'  => 'Enter the heading text',
            'required'      => $config['required'],
            'placeholder'   => 'Enter heading...',
            'default_value' => '',
        ),
    );
    
    if ( $config['show_subtitle'] ) {
        $fields[] = array(
            'key'           => "field_{$prefix}_subtitle",
            'label'         => 'Subtitle',
            'name'          => "{$prefix}_subtitle",
            'type'          => 'textarea',
            'instructions'  => 'Enter optional subtitle or description',
            'rows'          => 3,
            'placeholder'   => 'Enter subtitle...',
        );
    }
    
    if ( $config['show_tag'] ) {
        $fields[] = array(
            'key'           => "field_{$prefix}_tag",
            'label'         => 'Heading Tag',
            'name'          => "{$prefix}_tag",
            'type'          => 'select',
            'instructions'  => 'Choose HTML heading tag',
            'choices'       => array(
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
            ),
            'default_value' => 'h2',
            'allow_null'    => 0,
        );
    }
    
    if ( $config['show_alignment'] ) {
        $fields[] = array(
            'key'           => "field_{$prefix}_alignment",
            'label'         => 'Text Alignment',
            'name'          => "{$prefix}_alignment",
            'type'          => 'button_group',
            'instructions'  => 'Choose text alignment',
            'choices'       => array(
                'left'   => 'Left',
                'center' => 'Center',
                'right'  => 'Right',
            ),
            'default_value' => 'left',
            'allow_null'    => 0,
        );
    }
    
    return $fields;
}
