<?php
/**
 * AI Test Parent Theme functions and definitions
 *
 * @package AI_Test_Parent
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Theme setup
 */
function ai_test_parent_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails.
    add_theme_support( 'post-thumbnails' );

    // Add support for Block Styles.
    add_theme_support( 'wp-block-styles' );

    // Add support for full and wide align images.
    add_theme_support( 'align-wide' );

    // Add support for editor styles.
    add_theme_support( 'editor-styles' );

    // Add support for responsive embeds.
    add_theme_support( 'responsive-embeds' );

    // Register navigation menus.
    register_nav_menus(
        array(
            'primary' => __( 'Primary Menu', 'ai-test-parent' ),
        )
    );
}
add_action( 'after_setup_theme', 'ai_test_parent_setup' );

/**
 * Enqueue scripts and styles.
 */
function ai_test_parent_scripts() {
    wp_enqueue_style( 'ai-test-parent-style', get_stylesheet_uri(), array(), '1.0.0' );
    wp_enqueue_style( 'ai-test-parent-layout', get_template_directory_uri() . '/assets/css/layout.css', array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'ai_test_parent_scripts' );

/**
 * Register ACF blocks
 */
function ai_test_parent_register_acf_blocks() {
    // Check if ACF Pro is active
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        return;
    }

    // Register blocks from the blocks directory
    $blocks_dir = get_template_directory() . '/blocks/';
    
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
add_action( 'acf/init', 'ai_test_parent_register_acf_blocks' );

/**
 * ACF JSON save point
 */
function ai_test_parent_acf_json_save_point( $path ) {
    return get_template_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'ai_test_parent_acf_json_save_point' );

/**
 * ACF JSON load point
 */
function ai_test_parent_acf_json_load_point( $paths ) {
    unset( $paths[0] );
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
}
add_filter( 'acf/settings/load_json', 'ai_test_parent_acf_json_load_point' );
