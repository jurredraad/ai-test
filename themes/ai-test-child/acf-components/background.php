<?php
/**
 * Reusable ACF Background Field Component
 * 
 * Provides background image/color/overlay fields
 *
 * @package AI_Test_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get background field configuration
 *
 * @param string $prefix Field name prefix for uniqueness
 * @param array  $config Optional configuration overrides
 * @return array ACF field configuration
 */
function ai_test_get_background_fields( $prefix = 'background', $config = array() ) {
    $defaults = array(
        'show_color'      => true,
        'show_overlay'    => true,
        'show_position'   => true,
        'show_size'       => true,
        'required_image'  => false,
    );
    
    $config = wp_parse_args( $config, $defaults );
    
    $fields = array(
        array(
            'key'           => "field_{$prefix}_image",
            'label'         => 'Background Image',
            'name'          => "{$prefix}_image",
            'type'          => 'image',
            'instructions'  => 'Upload a background image',
            'required'      => $config['required_image'],
            'return_format' => 'array',
            'preview_size'  => 'medium',
            'library'       => 'all',
        ),
    );
    
    if ( $config['show_color'] ) {
        $fields[] = array(
            'key'           => "field_{$prefix}_color",
            'label'         => 'Background Color',
            'name'          => "{$prefix}_color",
            'type'          => 'color_picker',
            'instructions'  => 'Choose background color (used if no image)',
            'default_value' => '#f5f5f5',
        );
    }
    
    if ( $config['show_position'] ) {
        $fields[] = array(
            'key'           => "field_{$prefix}_position",
            'label'         => 'Background Position',
            'name'          => "{$prefix}_position",
            'type'          => 'select',
            'instructions'  => 'Choose background image position',
            'choices'       => array(
                'center center' => 'Center',
                'top center'    => 'Top',
                'bottom center' => 'Bottom',
                'left center'   => 'Left',
                'right center'  => 'Right',
            ),
            'default_value' => 'center center',
            'conditional_logic' => array(
                array(
                    array(
                        'field'    => "field_{$prefix}_image",
                        'operator' => '!=empty',
                    ),
                ),
            ),
        );
    }
    
    if ( $config['show_size'] ) {
        $fields[] = array(
            'key'           => "field_{$prefix}_size",
            'label'         => 'Background Size',
            'name'          => "{$prefix}_size",
            'type'          => 'select',
            'instructions'  => 'Choose how background image is sized',
            'choices'       => array(
                'cover'   => 'Cover',
                'contain' => 'Contain',
                'auto'    => 'Auto',
            ),
            'default_value' => 'cover',
            'conditional_logic' => array(
                array(
                    array(
                        'field'    => "field_{$prefix}_image",
                        'operator' => '!=empty',
                    ),
                ),
            ),
        );
    }
    
    if ( $config['show_overlay'] ) {
        $fields[] = array(
            'key'           => "field_{$prefix}_overlay_color",
            'label'         => 'Overlay Color',
            'name'          => "{$prefix}_overlay_color",
            'type'          => 'color_picker',
            'instructions'  => 'Choose overlay color',
            'default_value' => '#000000',
        );
        
        $fields[] = array(
            'key'           => "field_{$prefix}_overlay_opacity",
            'label'         => 'Overlay Opacity',
            'name'          => "{$prefix}_overlay_opacity",
            'type'          => 'range',
            'instructions'  => 'Adjust overlay opacity (0-100%)',
            'min'           => 0,
            'max'           => 100,
            'step'          => 5,
            'default_value' => 50,
            'append'        => '%',
        );
    }
    
    return $fields;
}
