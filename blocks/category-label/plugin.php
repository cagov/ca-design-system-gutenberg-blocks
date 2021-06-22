<?php

/**
 * Plugin Name: Category Label
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
add_action( 'init', 'cagov_category_label' );

function cagov_category_label() {
	load_plugin_textdomain( 'ca-design-system', false, basename( __DIR__ ) . '/languages' );
}

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function ca_design_system_register_category_label() {
	
	if ( ! function_exists( 'register_block_type' ) ) {
		// Gutenberg is not active.
		return;
	}
	
	global $post;

	wp_register_script(
		'ca-design-system-category-label',
		plugins_url( 'block.js', __FILE__ ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore'),
		filemtime( plugin_dir_path( __FILE__ ) . 'block.js' ),
	);

	$taxonomy_name = "category"; // @TODO This can be a CONST set in the plugin initializer

	$terms = get_terms( array( 
		'taxonomy' => $taxonomy_name,
		'hide_empty' => false,
	));
	
	wp_localize_script('ca-design-system-category-label', 'cagov_category_label_vars', array(
			'terms' => $terms
		)
	);

	wp_register_style(
		'ca-design-system-category-label',
		plugins_url( 'style.css', __FILE__ ),
		array( ),
		filemtime( plugin_dir_path( __FILE__ ) . 'style.css' )
	);

	register_block_type( 'ca-design-system/category-label', array(
		'style' => 'cagov-category-label',
		'editor_script' => 'ca-design-system-category-label',
	) );

}
add_action( 'init', 'ca_design_system_register_category_label' );