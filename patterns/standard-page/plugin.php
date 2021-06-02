<?php

/**
 * Plugin Name: Standard Page Pattern
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
            'content' => '<!-- wp:columns --><div class=\"wp-block-columns\"><!-- wp:column {\"width\":\"33.33%\"} -->
            <div class=\"wp-block-column\" style=\"flex-basis:33.33%\"><!-- wp:html -->
            <cagov-content-navigation></cagov-content-navigation>
            <!-- /wp:html --></div>
            <!-- /wp:column -->
            
            <!-- wp:column {\"width\":\"66.66%\"} -->
            <div id=\"main-content\" class=\"wp-block-column\" style=\"flex-basis:66.66%\"><!-- wp:html -->
            <!-- /wp:html --></div>
            <!-- /wp:column --></div>
            <!-- /wp:columns -->
            
            <!-- wp:paragraph -->
            <p></p>
            <!-- /wp:paragraph -->',
            "categories" => array('cagov'),
        )
    );
}

add_action( 'init', 'cagov_design_system_custom_wp_block_patterns' );


function cagov_design_system_web_component_scripts() {
    // Global dependencies
    wp_enqueue_script(
        'moment'
    );

    // Custom web components javascript and css
    wp_enqueue_script(
        'california-design-system-news-list-web-component',
        plugins_url( '/blocks/news-list/web-component.js', dirname( __FILE__ ) ),
        array( ),
    );
    // @TODO this is acting strangely, figure out why.
    // wp_enqueue_style(
    //     'california-design-system-news-list',
    //     plugins_url( '/blocks/news-list/style.css', dirname( __FILE__ ) ),
    //     array( )
    // );

    wp_enqueue_script(
        'california-design-system-content-navigation-web-component',
        plugins_url( '/blocks/content-navigation/web-component.js', dirname( __FILE__ ) ),
        array( ),
    );
}


add_action('wp_enqueue_scripts', 'cagov_design_system_web_component_scripts');