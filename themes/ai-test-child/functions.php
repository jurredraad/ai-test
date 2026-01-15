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
 * Load ACF field components
 */
function ai_test_child_load_acf_components() {
    $components_dir = get_stylesheet_directory() . '/acf-components/';
    
    if ( file_exists( $components_dir ) ) {
        $components = array(
            'button.php',
            'heading.php',
            'background.php',
            'spacing.php',
            'content.php',
        );
        
        foreach ( $components as $component ) {
            $file = $components_dir . $component;
            if ( file_exists( $file ) ) {
                require_once $file;
            }
        }
    }
}
add_action( 'after_setup_theme', 'ai_test_child_load_acf_components' );

/**
 * Enqueue parent and child theme styles
 */
function ai_test_child_enqueue_styles() {
    // Enqueue parent theme stylesheet
    wp_enqueue_style( 'ai-test-parent-style', get_template_directory_uri() . '/style.css', array(), '1.0.0' );
    
    // Enqueue child theme stylesheet (layout.css is already enqueued by parent)
    wp_enqueue_style( 'ai-test-child-style', get_stylesheet_uri(), array( 'ai-test-parent-style' ), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'ai_test_child_enqueue_styles' );

/**
 * Register ACF blocks from child theme
 */
function ai_test_child_register_acf_blocks() {
    // Check if ACF Pro is active
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        return;
    }

    // Register blocks from the child theme blocks directory
    $blocks_dir = get_stylesheet_directory() . '/blocks/';
    
    if ( file_exists( $blocks_dir ) ) {
        $block_dirs = glob( $blocks_dir . '*', GLOB_ONLYDIR );
        
        foreach ( $block_dirs as $block_dir ) {
            $block_file = $block_dir . '/block.php';
            if ( file_exists( $block_file ) ) {
                require_once $block_file;
            }
        }
    }
}
add_action( 'acf/init', 'ai_test_child_register_acf_blocks' );

/**
 * ACF JSON save point for child theme
 */
function ai_test_child_acf_json_save_point( $path ) {
    return get_stylesheet_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'ai_test_child_acf_json_save_point' );

/**
 * ACF JSON load point for child theme
 */
function ai_test_child_acf_json_load_point( $paths ) {
    // Add child theme path
    $paths[] = get_stylesheet_directory() . '/acf-json';
    
    // Add parent theme path
    $paths[] = get_template_directory() . '/acf-json';
    
    return $paths;
}
add_filter( 'acf/settings/load_json', 'ai_test_child_acf_json_load_point' );
