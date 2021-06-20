<?php

/**
 * Plugin Name: Content Footer
 * Plugin URI: TBD
 * Description: TBD
 * Version: 1.1.0
 * Author: California Office of Digital Innovation
 * @package ca-design-system
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load all translations for our plugin from the MO file.
 */
add_action( 'init', 'ca_design_system_gutenberg_blocks_content_footer' );

function ca_design_system_gutenberg_blocks_content_footer() {
    load_plugin_textdomain( 'ca-design-system', false, basename( __DIR__ ) . '/languages' );
}

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function ca_design_system_register_content_footer() {

    if ( ! function_exists( 'register_block_type' ) ) {
        // Gutenberg is not active.
        return;
    }

    // Register custom web component
    wp_register_script(
        'ca-design-system-content-footer-web-component',
        plugins_url( 'web-component.js', __FILE__ ),
        array( ),
        filemtime( plugin_dir_path( __FILE__ ) . 'web-component.js' ),
    );

    wp_register_script(
        'ca-design-system-content-footer',
        plugins_url( 'block.js', __FILE__ ),
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore', 'moment', 'ca-design-system-content-footer-web-component' ),
        filemtime( plugin_dir_path( __FILE__ ) . 'block.js' ),
    );

    wp_register_style(
        'ca-design-system-content-footer',
        plugins_url( 'style.css', __FILE__ ),
        array( ),
        filemtime( plugin_dir_path( __FILE__ ) . 'style.css' )
    );

    register_block_type( 'ca-design-system/content-footer', array(
        'style' => 'cagov-content-footer',
        'editor_script' => 'ca-design-system-content-footer',
    ) );

}
add_action( 'init', 'ca_design_system_register_content_footer' );