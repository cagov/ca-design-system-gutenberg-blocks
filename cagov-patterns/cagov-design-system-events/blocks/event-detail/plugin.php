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
add_action('init', 'cagov_design_system_register_event_detail');

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function cagov_design_system_register_event_detail()
{

    if (!function_exists('register_block_type')) {
        // Gutenberg is not active.
        return;
    }

    wp_register_style('ca-design-system-event-detail-style', false);
    $style_css = file_get_contents(plugin_dir_path(__FILE__) . '/style.css', __FILE__);
    wp_add_inline_style('ca-design-system-event-detail-style', $style_css);

    wp_register_style(
        'ca-design-system-event-detail-editor',
        plugins_url('editor.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'editor.css')
    );

    // include_once plugin_dir_path(__FILE__) .  '/meta.php';
    // cagov_design_system_event_detail_meta_init(); // Initialize meta content & backend field support.

    wp_enqueue_script( 'wp-api' ); // Make the wp-api available directly

    register_block_type('ca-design-system/event-detail', array(
        'style' => 'ca-design-system-event-detail-style',
        'editor_script' => 'ca-design-system-event-detail',
        'editor_style' => 'ca-design-system-event-detail-editor',
        'render_callback' => 'cagov_design_system_event_detail_dynamic_render_callback'
    ));

    // add_action( 'init', 'cagov_design_system_event_detail_register_settings' );

    // register_setting(
	// 	'cagov_design_system_event_detail_settings',
	// 	'cagov_design_system_event_detail_example_text',
	// 	[
	// 		'default'       => '',
	// 		'show_in_rest'  => true,
	// 		'type'          => 'string',
	// 	]
	// );
}

function cagov_design_system_event_detail_dynamic_render_callback($block_attributes, $content)
{
    $string_date_time = "Date &amp; time"; // @TODO Storing as variables these need a string registry.
    $string_location = "Location";
    $string_cost = "Cost";
    $title = isset($block_attributes["title"]) ? $block_attributes["title"] : "Event Details";
    $startDateTimeUTC = isset($block_attributes["startDateTimeUTC"]) ? $block_attributes["startDateTimeUTC"] : "";
    $endDateTimeUTC = isset($block_attributes["endDateTimeUTC"]) ? $block_attributes["endDateTimeUTC"] : "";
    $startDate = isset($block_attributes["startDate"]) ? $block_attributes["startDate"] : "";
    $endDate = isset($block_attributes["endDate"]) ? $block_attributes["endDate"] : "";
    $startTime = isset($block_attributes["startTime"]) ? $block_attributes["startTime"] : "";
    $endTime = isset($block_attributes["endTime"]) ? $block_attributes["endTime"] : "";
    $localTimezone = isset($block_attributes["localTimezone"]) ? $block_attributes["localTimezone"] : "";
    $localTimezoneLabel = isset($block_attributes["localTimezoneLabel"]) ? $block_attributes["localTimezoneLabel"] : "";
    $location = isset($block_attributes["location"]) ? $block_attributes["location"] : "";
    $cost = isset($block_attributes["cost"]) ? $block_attributes["cost"] : "";

    // Testing API integration
    // $example_text = get_option( 'cagov_design_system_event_detail_example_text' );
    // '<p class="cagov-event-detail-example">' . $example_text . '</p>' .

    // @TODO The text string labels don't belong in this code & need a translated string registry. 
    return '<div class="wp-block-ca-design-system-event-detail-block cagov-event-detail-block cagov-stack">
        <div>
            <h3>' . $title . '</h3>
            <div class="wp-block-ca-design-system-event-detail cagov-event-detail cagov-stack">' .
            cagov_design_system_event_detail_get_date_time_block($string_date_time, $startDate, $endDate, $startTime, $endTime, $localTimezoneLabel) .
            cagov_design_system_event_detail_get_location_block($string_location, $location) .
            cagov_design_system_event_detail_get_cost_block($string_cost, $cost) .
            cagov_design_system_event_detail_get_more_info_block($block_attributes, $content) .
        '</div>' .
        '</div>
    </div>';
}

function cagov_design_system_event_detail_get_date_time_block($string_date_time, $startDate, $endDate, $startTime, $endTime, $localTimezoneLabel)
{
    $block_date = "";

    if ("" !== $startDate && "" !== $endDate && $startDate !== $endDate) {
        $block_date = '<div class="start-date">
            <span class="start-date field-data">' . $startDate . '</span>' .
            '<span class="end-date field-data">' . $endDate . '</span>' .
            '</div> <br />';
    } else if ("" !== $startDate && $startDate === $endDate) {
        $block_date = '<div class="start-date">
            <span class="start-date field-data">' . $startDate . '</span>' .
            '</div> <br />';
    }

    $block_time = "";
    if ("" !== $startTime && "" !== $endTime && $startTime !== $endTime) {
        $block_time = '<div class="start-time">
            <span class="start-time field-data">' . $startTime . '</span>
            <span class="end-time field-data">' . $endTime . '</span>
        </div>';
    } else if ("" !== $startTime && $startTime && $endTime) {
        $block_time = '<div class="start-time">
            <span class="start-time field-data">' . $startTime . '</span>
            <span class="timezone-label">' . $localTimezoneLabel  . '</span>
        </div>';
    }

    return '<div class="detail-section">
        <h4>' . $string_date_time . '</h4>' .
        $block_date .
        $block_time .
        '</div>';
}

function cagov_design_system_event_detail_get_location_block($string_location, $location) {
    if ("" !== $location) {
    return  '<div class="detail-section">
        <h4>' . $string_location . '</h4>
        <div class="location field-data">' . $location . '</div>
    </div>';
    }
    return "";
}

function cagov_design_system_event_detail_get_cost_block($string_cost, $cost) {
    if ("" !== $cost) {
        return  '<div class="detail-section">
            <h4>' . $string_cost . '</h4>
            <div class="cost field-data">' . $cost . '</div>
        </div>';
    }
    return "";
}

function cagov_design_system_event_detail_get_more_info_block($block_attributes, $content) {
    $body = isset( $block_attributes['body'] ) ? $block_attributes['body'] : '';
    $inner_blocks = do_blocks( $content );
    
    if ("" !== $inner_blocks) {
        return  '<div class="detail-section-more-info">
        <div class="more-info field-data">' . $inner_blocks . '</div>
        </div>' ;
    }
    return "";
}
