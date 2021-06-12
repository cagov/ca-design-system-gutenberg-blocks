<?php

/**
 * Plugin Name: Content Navigation
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
add_action( 'init', 'ca_design_system_gutenberg_block_content_navigation' );

function ca_design_system_gutenberg_block_content_navigation() {
	load_plugin_textdomain( 'ca-design-system', false, basename( __DIR__ ) . '/languages' );
}

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function ca_design_system_register_content_navigation() {

	if ( ! function_exists( 'register_block_type' ) ) {
		// Gutenberg is not active.
		return;
	}

	// Register custom web component
	wp_register_script(
		'ca-design-system-content-navigation-web-component',
		plugins_url( 'web-component.js', __FILE__ ),
		array( ),
		filemtime( plugin_dir_path( __FILE__ ) . 'web-component.js' ),
	);

	wp_register_script(
		'ca-design-system-content-navigation',
		plugins_url( 'block.js', __FILE__ ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore', 'moment', 'ca-design-system-content-navigation-web-component' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'block.js' ),
	);

	wp_register_style(
		'ca-design-system-content-navigation',
		plugins_url( 'style.css', __FILE__ ),
		array( ),
		filemtime( plugin_dir_path( __FILE__ ) . 'style.css' )
	);

	register_block_type( 'ca-design-system/content-navigation', array(
		'style' => 'cagov-content-navigation',
		'editor_script' => 'ca-design-system-content-navigation',
	) );

}
add_action( 'init', 'ca_design_system_register_content_navigation' );

function ca_design_system_register_content_navigation_web_component_callback()
{
	// @TODO move into content-navigation
	wp_register_script(
		'ca-design-system-content-navigation-web-component',
		plugins_url('web-component.js', __FILE__),
		array(),
		filemtime(plugin_dir_path(__FILE__) . 'web-component.js'),
	);

	wp_enqueue_script('ca-design-system-content-navigation-web-component');
}

add_action('ca_design_system_register_content_navigation_web_component', 'ca_design_system_register_content_navigation_web_component_callback', 10, 2);
