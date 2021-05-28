<?php

/**
 * Plugin Name: News List
 * Plugin URI: TBD
 * Description: TBD
 * Version: 1.1.0
 * Author: California Office of Digital Innovation
 * @package cagov-design-system
 */

defined( 'ABSPATH' ) || exit;


/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function cagov_design_system_custom_wp_block_patterns() {

	if ( ! function_exists( 'register_block_pattern' ) ) {
		// Gutenberg is not active.
		return;
	}

    /**
     * Register Block Pattern
     */
    register_block_pattern(
        'cagov/standard-page',
        // @TODO Update div & markup
        // @TODO Add css style (enqueue)
        // Add field reference

        // Great reference: https://fullsiteediting.com/lessons/introduction-to-block-patterns/
        array(
            'title'       => __( 'Standard Page', 'cagov' ),
            'description' => _x( 'Page layout with dynamic content navigation sidebar', 'Block pattern description', 'cagov' ),
            'content' => "<!-- wp:columns --><div class=\"wp-block-columns\"><!-- wp:column {\"width\":\"33.33%\"} -->
            <div class=\"wp-block-column\" style=\"flex-basis:33.33%\"><!-- wp:html -->
            Content Nav WEB COMPONENT HERE
            <!-- /wp:html --></div>
            <!-- /wp:column -->
            
            <!-- wp:column {\"width\":\"66.66%\"} -->
            <div class=\"wp-block-column\" style=\"flex-basis:66.66%\"><!-- wp:html -->
            [cds_content]
            <!-- /wp:html --></div>
            <!-- /wp:column --></div>
            <!-- /wp:columns -->
            
            <!-- wp:paragraph -->
            <p></p>
            <!-- /wp:paragraph -->",
            "categories" => array('cagov'),
        )
    );

    /**
     * Register Block Pattern Category.
     */
    if ( function_exists( 'register_block_pattern_category' ) ) {

        register_block_pattern_category(
            'cagov',
            array( 'label' => esc_html__( 'CA Design System', 'cagov' ) )
        );
    }
}
