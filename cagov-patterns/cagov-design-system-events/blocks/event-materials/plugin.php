<?php

/**
 * Plugin Name: Event Materials
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

add_action( 'init', 'cagov_register_event_materials' );

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function cagov_register_event_materials() {

    if ( ! function_exists( 'register_block_type' ) ) {
        // Gutenberg is not active.
        return;
    }

    // Register custom web component
    // wp_register_script(
    // 	'ca-design-system-event-materials-web-component',
    // 	plugins_url( 'web-component.js', __FILE__ ),
    // 	array( ),
    // 	filemtime( plugin_dir_path( __FILE__ ) . 'web-component.js' ),
    // );

    // wp_register_script(
    // 	'ca-design-system-event-materials',
    // 	plugins_url( 'block.js', __FILE__ ),
    // 	array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore', 'moment', 'ca-design-system-event-materials-web-component' ),
    // 	filemtime( plugin_dir_path( __FILE__ ) . 'block.js' ),
    // );

    // wp_register_style(
    //     'ca-design-system-event-materials',
    //     plugins_url( 'index.css', __FILE__ ),
    //     array( ),
    //     filemtime( plugin_dir_path( __FILE__ ) . 'index.css' )
    // );


	wp_register_style( 'ca-design-system-event-materials-style', false );
	$style_css = file_get_contents(plugin_dir_path(__FILE__) . '/index.css', __FILE__);
	wp_add_inline_style('ca-design-system-event-materials-style', $style_css);

    register_block_type( 'ca-design-system/event-materials', array(
        'style' => 'ca-design-system-event-materials-style',
        // 'editor_script' => 'ca-design-system-event-materials',
        // 'editor_style' => 'ca-design-system-event-materials-editor',
        'render_callback' => 'cagov_event_materials_dynamic_render_callback'
    ) );
    
}

// NOTE: This is a proof of concept, that we are just starting to research.
function cagov_event_materials_dynamic_render_callback($block_attributes, $content)
{

    $title = isset($block_attributes["title"]) ? $block_attributes["title"] : "";
    $agenda = isset($block_attributes["agenda"]) ? $block_attributes["agenda"] : "";
    $materials = isset($block_attributes["materials"]) ? $block_attributes["materials"] : "";

    return '
    <div class="wp-block-ca-design-system-post-list cagov-post-list cagov-stack">
        <div>
            <h3>' . $title . '</h3>
            <div class="wp-block-ca-design-system-event-materials cagov-event-materials cagov-stack">
                <div class="agenda">' . $agenda . '</div>
                <div class="materials">' . $materials . '</div>
            </div>
        </div>
    </div>';
}


