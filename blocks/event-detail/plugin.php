<?php

/**
 * Plugin Name: Event Detail
 * Plugin URI: TBD
 * Description: TBD
 * Version: 1.1.1
 * Author: California Office of Digital Innovation
 * @package ca-design-system
 */

defined('ABSPATH') || exit;

/**
 * Load all translations for our plugin from the MO file.
 */
add_action('init', 'cagov_register_event_detail');

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function cagov_register_event_detail()
{

    if (!function_exists('register_block_type')) {
        // Gutenberg is not active.
        return;
    }

    // This component is generated with npm
    // Register custom web component
    // wp_register_script(
    // 	'ca-design-system-event-detail-web-component',
    // 	plugins_url( 'web-component.js', __FILE__ ),
    // 	array( ),
    // 	filemtime( plugin_dir_path( __FILE__ ) . 'web-component.js' ),
    // );

    // wp_register_script(
    //     'ca-design-system-event-detail',
    //     plugins_url('block.js', __FILE__),
    //     // array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore', 'moment'),
    //     array(),
    //     filemtime(plugin_dir_path(__FILE__) . 'block.js'),
    // );

    // wp_register_style(
    //     'ca-design-system-event-detail',
    //     plugins_url('style.css', __FILE__),
    //     array(),
    //     filemtime(plugin_dir_path(__FILE__) . 'style.css')
    // );

	wp_register_style( 'ca-design-system-event-detail-style', false );
	$style_css = file_get_contents(plugin_dir_path(__FILE__) . '/style.css', __FILE__);
	wp_add_inline_style('ca-design-system-event-detail-style', $style_css);

    register_block_type('ca-design-system/event-detail', array(
        'style' => 'ca-design-system-event-detail-style',
        'editor_script' => 'ca-design-system-event-detail',
        // 'editor_style' => 'ca-design-system-event-detail-editor',
        'render_callback' => 'cagov_event_detail_dynamic_render_callback'
    ));
}

function cagov_event_detail_dynamic_render_callback($block_attributes, $content)
{
    $title = isset($block_attributes["title"]) ? $block_attributes["title"] : "Event Details";
    $startDate = isset($block_attributes["startDate"]) ? $block_attributes["startDate"] : "";
    $endDate = isset($block_attributes["endDate"]) ? $block_attributes["endDate"] : "";
    $startTime = isset($block_attributes["startTime"]) ? $block_attributes["startTime"] : "";
    $endTime = isset($block_attributes["endTime"]) ? $block_attributes["endTime"] : "";
    $location = isset($block_attributes["location"]) ? $block_attributes["location"] : "";
    $cost = isset($block_attributes["cost"]) ? $block_attributes["cost"] : "";

    return <<<EOT
    <div class="wp-block-ca-design-system-post-list cagov-post-list cagov-stack">
        <div>
            <h3>$title</h3>
            <div class="wp-block-ca-design-system-event-detail cagov-event-detail cagov-stack">
                <h4>Date &amp; time</h4>
                <div class="startDate">$startDate</div>
                <div class="endDate">$endDate</div>

                <div class="startTime">$startTime</div>
                <div class="endTime">$endTime</div>
                <h4>Location</h4>
                <div class="location">$location</div>

                <h4>Cost</h4>
                <div class="cost">$cost</div>
            </div>
        </div>
    </div>
    EOT;
}
