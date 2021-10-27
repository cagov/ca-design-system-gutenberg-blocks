<?php

/**
 * Plugin Name: Event list
 * Plugin URI: TBD
 * Description: List of recent events. Block for event pages. Allows people to see the most recent events with the "Events" tag. Includes title, hyperlink to full event, date, and a view all link to see longer list.
 * Version: 1.0.0
 * Author: California Office of Digital Innovation
 * @package ca-design-system
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load all translations for our plugin from the MO file.
 */
add_action( 'init', 'cagov_event_list' );

function cagov_event_list() {
    load_plugin_textdomain( 'ca-design-system', false, basename( __DIR__ ) . '/languages' );
}

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function ca_design_system_register_event_list() {

    if ( ! function_exists( 'register_block_type' ) ) {
        // Gutenberg is not active.
        return;
    }

    // Register custom web component
    // wp_register_script(
    //     'ca-design-system-event-list-web-component',
    //     plugins_url( 'web-component.js', __FILE__ ),
    //     array( ),
    //     filemtime( plugin_dir_path( __FILE__ ) . 'web-component.js' ),
    // );

    wp_register_script(
        'ca-design-system-event-list',
        plugins_url( 'block.js', __FILE__ ),
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore', 'moment'),
        filemtime( plugin_dir_path( __FILE__ ) . 'block.js' ),
    );

    wp_register_style( 'ca-design-system-event-list-style', false );
    $style_css = file_get_contents(plugin_dir_path(__FILE__) . '/index.css', __FILE__);
    wp_add_inline_style('ca-design-system-event-list-style', $style_css);

    register_block_type( 'ca-design-system/event-list', array(
        'style' => 'ca-design-system-event-list-style',
        'editor_script' => 'ca-design-system-event-list',
        'render_callback' => 'cagov_event_list_dynamic_render_callback'
    ) );
}

add_action( 'init', 'ca_design_system_register_event_list' );


function cagov_register_event_list_web_component_callback()
{

    // Depends on post-list component.
    // Alt idea: do_action('...')
    wp_register_style(
        'ca-design-system-event-list',
        plugins_url('index.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'index.css')
    );

    wp_enqueue_style('ca-design-system-event-list');
}

add_action('cagov_register_event_list_web_component', 'cagov_register_event_list_web_component_callback', 10, 2);


function cagov_event_list_dynamic_render_callback($block_attributes, $content)
{

    $host = "http://";
    if( isset($_SERVER['HTTPS'] ) ) {
        $host = "https://";
    }

    $domain = $host . $_SERVER['HTTP_HOST'];
    $title = isset($block_attributes["title"]) ? $block_attributes["title"] : "Upcoming events";
    $count = isset($block_attributes["count"]) ? $block_attributes["count"] : "3";
    $order = isset($block_attributes["order"]) ? $block_attributes["order"] : "desc";
    $category = isset($block_attributes["category"]) ? $block_attributes["category"] : "events";
    $endpoint = isset($block_attributes["endpoint"]) ? $block_attributes["endpoint"] : "$domain/wp-json/wp/v2";
    $readMore = isset($block_attributes["readMore"]) ? esc_html($block_attributes["readMore"]) : "";
    $noResults = isset($block_attributes["noResults"]) ? $block_attributes["noResults"] : "No upcoming events found";
    $showExcerpt = isset($block_attributes["showExcerpt"]) ? $block_attributes["showExcerpt"] : "true";
    $showPublishedDate = "false"; // don't use date, special date is set in block isset($block_attributes["showPublishedDate"]) ? $block_attributes["showPublishedDate"] : "true";
    $showPagination = isset($block_attributes["showPagination"]) ? $block_attributes["showPagination"] : "false";

    // today-or-after or before-yesterday for events - Name the type of filtering so it's easy to set & easy to change/test.
    // Add fields for comparison
    // data-filter[0]=
    // data-filter-field[0]=
    // data-filter[1]=
    // data-filter-field[1]=

    return <<<EOT
    <div class="wp-block-ca-design-system-event-list cagov-event-list cagov-stack">
        <div>
            <cagov-event-post-list 
                class="post-list" 
                data-category="$category"
                data-count="$count"
                data-order="$order"
                data-endpoint="$endpoint"
                data-show-excerpt="$showExcerpt"
                data-show-published-date="$showPublishedDate"
                data-no-results="$noResults"
                data-show-pagination="$showPagination"
                data-read-more="$readMore"
                data-filter="today-or-after"
            >
            </cagov-event-post-list>
        </div>
    </div>
    EOT;
}