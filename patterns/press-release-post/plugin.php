<?php

/**
 * Plugin Name: CA Design System Press Release Post Pattern
 * Plugin URI: TBD
 * Description: TBD
 * Version: 1.1.0
 * Author: California Office of Digital Innovation
 * @package ca-design-system
 */

defined( 'ABSPATH' ) || exit;


/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function ca_design_system_custom_wp_block_pattern_press_release_post() {

	if ( ! function_exists( 'register_block_pattern' ) ) {
		// Gutenberg is not active.
		return;
	}

    /**
     * Register Block Pattern
     */
    register_block_pattern(
        'ca-design-system/press-release-post',
        // @TODO Update div & markup
        // @TODO Add css style (enqueue)
        // Add field reference

        // Great reference: https://fullsiteediting.com/lessons/introduction-to-block-patterns/
        array(
            'title'       => __( 'Press Release Post', 'ca-design-system' ),
            'description' => _x( 'Page layout with dynamic content navigation sidebar', 'Block pattern description', 'ca-design-system' ),
            'content' => '<!-- wp:columns --><div class="wp-block-columns has-2-columns"><!-- wp:column {"width":"33.33%"} -->
            <div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:html -->
            <cagov-content-navigation></cagov-content-navigation>
            <!-- /wp:html --></div>
            <!-- /wp:column -->
            
            <!-- wp:column {"width":"66.66%"} -->
            <div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:html -->
            <!-- /wp:html --></div>
            <!-- /wp:column --></div>
            <!-- /wp:columns -->',
            "categories" => array('ca-design-system'),
        )
    );
}

add_action( 'init', 'ca_design_system_custom_wp_block_pattern_press_release_post' );
