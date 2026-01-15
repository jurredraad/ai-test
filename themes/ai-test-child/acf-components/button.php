<?php
/**
 * Reusable ACF Button Field Component
 * 
 * Provides button/CTA fields (text, URL, style)
 *
 * @package AI_Test_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get button field configuration
 *
 * @param string $prefix Field name prefix for uniqueness
 * @param array  $config Optional configuration overrides
 * @return array ACF field configuration
 */
function ai_test_get_button_fields( $prefix = 'button', $config = array() ) {
    $defaults = array(
        'show_style'  => true,
        'show_target' => true,
        'required'    => false,
    );
    
    $config = wp_parse_args( $config, $defaults );
    
    $fields = array(
        array(
            'key'           => "field_{$prefix}_text",
            'label'         => 'Button Text',
            'name'          => "{$prefix}_text",
            'type'          => 'text',
            'instructions'  => 'Enter the button text',
            'required'      => $config['required'],
            'placeholder'   => 'Click Here',
            'default_value' => '',
        ),
        array(
            'key'           => "field_{$prefix}_url",
            'label'         => 'Button URL',
            'name'          => "{$prefix}_url",
            'type'          => 'url',
            'instructions'  => 'Enter the button link URL',
            'required'      => $config['required'],
            'placeholder'   => 'https://example.com',
        ),
    );
    
    if ( $config['show_target'] ) {
        $fields[] = array(
            'key'           => "field_{$prefix}_target",
            'label'         => 'Open in New Tab',
            'name'          => "{$prefix}_target",
            'type'          => 'true_false',
            'instructions'  => 'Open link in a new browser tab',
            'default_value' => 0,
            'ui'            => 1,
        );
    }
    
    if ( $config['show_style'] ) {
        $fields[] = array(
            'key'           => "field_{$prefix}_style",
            'label'         => 'Button Style',
            'name'          => "{$prefix}_style",
            'type'          => 'select',
            'instructions'  => 'Choose button style',
            'choices'       => array(
                'primary'   => 'Primary',
                'secondary' => 'Secondary',
                'outline'   => 'Outline',
                'text'      => 'Text Only',
            ),
            'default_value' => 'primary',
            'allow_null'    => 0,
        );
    }
    
    return $fields;
}
