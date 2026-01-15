<?php
/**
 * Reusable ACF Content Field Component
 * 
 * Provides WYSIWYG content editor fields
 *
 * @package AI_Test_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get content field configuration
 *
 * @param string $prefix Field name prefix for uniqueness
 * @param array  $config Optional configuration overrides
 * @return array ACF field configuration
 */
function ai_test_get_content_fields( $prefix = 'content', $config = array() ) {
    $defaults = array(
        'label'        => 'Content',
        'required'     => false,
        'toolbar'      => 'full',
        'media_upload' => true,
    );
    
    $config = wp_parse_args( $config, $defaults );
    
    $fields = array(
        array(
            'key'           => "field_{$prefix}",
            'label'         => $config['label'],
            'name'          => $prefix,
            'type'          => 'wysiwyg',
            'instructions'  => 'Add your content',
            'required'      => $config['required'],
            'tabs'          => 'all',
            'toolbar'       => $config['toolbar'],
            'media_upload'  => $config['media_upload'],
        ),
    );
    
    return $fields;
}
