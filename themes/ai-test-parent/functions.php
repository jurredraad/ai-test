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
}
add_action( 'wp_enqueue_scripts', 'ai_test_parent_scripts' );

/**
 * Register custom blocks
 */
function ai_test_parent_register_blocks() {
    // Register blocks from the blocks directory
    $blocks_dir = get_template_directory() . '/blocks/';
    
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
add_action( 'init', 'ai_test_parent_register_blocks' );
