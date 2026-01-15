<?php
/**
 * Reusable ACF Spacing Field Component
 * 
 * Provides margin/padding control fields
 *
 * @package AI_Test_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get spacing field configuration
 *
 * @param string $prefix Field name prefix for uniqueness
 * @param array  $config Optional configuration overrides
 * @return array ACF field configuration
 */
function ai_test_get_spacing_fields( $prefix = 'spacing', $config = array() ) {
    $defaults = array(
        'show_padding' => true,
        'show_margin'  => true,
        'label'        => 'Spacing',
    );
    
    $config = wp_parse_args( $config, $defaults );
    
    $spacing_options = array(
        'none'   => 'None',
        'small'  => 'Small',
        'medium' => 'Medium',
        'large'  => 'Large',
        'xlarge' => 'Extra Large',
    );
    
    $fields = array();
    
    if ( $config['show_padding'] ) {
        $fields[] = array(
            'key'           => "field_{$prefix}_padding_top",
            'label'         => 'Padding Top',
            'name'          => "{$prefix}_padding_top",
            'type'          => 'select',
            'instructions'  => 'Choose top padding',
            'choices'       => $spacing_options,
            'default_value' => 'medium',
            'allow_null'    => 0,
        );
        
        $fields[] = array(
            'key'           => "field_{$prefix}_padding_bottom",
            'label'         => 'Padding Bottom',
            'name'          => "{$prefix}_padding_bottom",
            'type'          => 'select',
            'instructions'  => 'Choose bottom padding',
            'choices'       => $spacing_options,
            'default_value' => 'medium',
            'allow_null'    => 0,
        );
    }
    
    if ( $config['show_margin'] ) {
        $fields[] = array(
            'key'           => "field_{$prefix}_margin_top",
            'label'         => 'Margin Top',
            'name'          => "{$prefix}_margin_top",
            'type'          => 'select',
            'instructions'  => 'Choose top margin',
            'choices'       => $spacing_options,
            'default_value' => 'none',
            'allow_null'    => 0,
        );
        
        $fields[] = array(
            'key'           => "field_{$prefix}_margin_bottom",
            'label'         => 'Margin Bottom',
            'name'          => "{$prefix}_margin_bottom",
            'type'          => 'select',
            'instructions'  => 'Choose bottom margin',
            'choices'       => $spacing_options,
            'default_value' => 'none',
            'allow_null'    => 0,
        );
    }
    
    return $fields;
}

/**
 * Get spacing class names based on field values
 *
 * @param string $prefix Field name prefix
 * @param string $type   'padding' or 'margin'
 * @return string CSS class names
 */
function ai_test_get_spacing_classes( $prefix = 'spacing', $type = 'padding' ) {
    $classes = array();
    
    $top    = get_field( "{$prefix}_{$type}_top" );
    $bottom = get_field( "{$prefix}_{$type}_bottom" );
    
    $spacing_map = array(
        'none'   => '0',
        'small'  => '2',
        'medium' => '3',
        'large'  => '4',
        'xlarge' => '5',
    );
    
    $prefix_map = array(
        'padding' => 'p',
        'margin'  => 'm',
    );
    
    $prefix_char = $prefix_map[ $type ];
    
    if ( $top && isset( $spacing_map[ $top ] ) ) {
        $classes[] = $prefix_char . 't-' . $spacing_map[ $top ];
    }
    
    if ( $bottom && isset( $spacing_map[ $bottom ] ) ) {
        $classes[] = $prefix_char . 'b-' . $spacing_map[ $bottom ];
    }
    
    return implode( ' ', $classes );
}
