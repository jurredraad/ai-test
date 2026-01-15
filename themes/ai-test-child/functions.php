<?php
/**
 * AI Test Child Theme functions and definitions
 *
 * @package AI_Test_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Enqueue parent and child theme styles
 */
function ai_test_child_enqueue_styles() {
    // Enqueue parent theme stylesheet
    wp_enqueue_style( 'ai-test-parent-style', get_template_directory_uri() . '/style.css', array(), '1.0.0' );
    
    // Enqueue child theme stylesheet
    wp_enqueue_style( 'ai-test-child-style', get_stylesheet_uri(), array( 'ai-test-parent-style' ), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'ai_test_child_enqueue_styles' );

/**
 * Register custom blocks from child theme
 */
function ai_test_child_register_blocks() {
    // Register blocks from the child theme blocks directory
    $blocks_dir = get_stylesheet_directory() . '/blocks/';
    
    if ( file_exists( $blocks_dir ) ) {
        $blocks = glob( $blocks_dir . '*', GLOB_ONLYDIR );
        
        foreach ( $blocks as $block ) {
            $block_json = $block . '/block.json';
            if ( file_exists( $block_json ) ) {
                register_block_type( $block );
            }
        }
    }
}
add_action( 'init', 'ai_test_child_register_blocks' );
