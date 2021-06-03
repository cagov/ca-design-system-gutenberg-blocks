<?php

/**
 * Plugin Name: Mailchimp
 * Plugin URI: TBD
 * Description: TBD
 * Version: 1.1.0
 * Author: California Office of Digital Innovation
 * @package cagov-design-system
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load all translations for our plugin from the MO file.
 */
add_action( 'init', 'cagov_design_system_gutenberg_block_mailchimp' );

function cagov_design_system_gutenberg_block_mailchimp() {
	load_plugin_textdomain( 'cagov-design-system', false, basename( __DIR__ ) . '/languages' );
}

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function cagov_design_system_register_mailchimp() {

	if ( ! function_exists( 'register_block_type' ) ) {
		// Gutenberg is not active.
		return;
	}

	// Register custom web component
	wp_register_script(
		'california-design-system-mailchimp-web-component',
		plugins_url( 'web-component.js', __FILE__ ),
		array( ),
		filemtime( plugin_dir_path( __FILE__ ) . 'web-component.js' ),
	);

	wp_register_script(
		'california-design-system-mailchimp',
		plugins_url( 'block.js', __FILE__ ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore', 'moment', 'california-design-system-mailchimp-web-component' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'block.js' ),
	);

	wp_register_style(
		'california-design-system-mailchimp',
		plugins_url( 'style.css', __FILE__ ),
		array( ),
		filemtime( plugin_dir_path( __FILE__ ) . 'style.css' )
	);

	register_block_type( 'cagov/mailchimp', array(
		'style' => 'cagov-mailchimp',
		'editor_script' => 'california-design-system-mailchimp',
	) );

}
add_action( 'init', 'cagov_design_system_register_mailchimp' );