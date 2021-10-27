<?php

/**
 * Plugin Name: EventPost list
 * Plugin URI: TBD
 * Description: List of recent posts. Appears on the homepage. Allows people to see the most recent announcements with the ""Announcement"" tag. Includes title, hyperlink to full announcement, date, and a view all link to see longer list.
 * Version: 1.1.1
 * Author: California Office of Digital Innovation
 * @package ca-design-system
 */

defined('ABSPATH') || exit;

/**
 * Load all translations for our plugin from the MO file.
 */

add_action('init', 'cagov_design_system_register_event_post_list');

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function cagov_design_system_register_event_post_list()
{

    if (!function_exists('register_block_type')) {
        // Gutenberg is not active.
        return;
    }

    // Register custom web component with dependencies.
    wp_register_script(
        'ca-design-system-event-post-list-web-component',
        plugins_url('web-component.js', __FILE__),
        array('moment'),
        filemtime(plugin_dir_path(__FILE__) . 'web-component.js'),
    );
    
    wp_register_script(
        'ca-design-system-event-post-list-editor-script',
        plugins_url( 'block.js', __FILE__ ),
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore', 'moment', 'ca-design-system-event-post-list-web-component'),
        filemtime( plugin_dir_path( __FILE__ ) . 'block.js' ),
    );

    wp_register_style(
        'ca-design-system-event-post-list-editor-style',
        plugins_url( 'editor.css', __FILE__ ),
        array( 'wp-edit-blocks' ),
        filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' )
    );

    wp_register_style( 'ca-design-system-event-post-list-style', false );
    $style_css = file_get_contents(plugin_dir_path(__FILE__) . '/index.css', __FILE__);
    wp_add_inline_style('ca-design-system-event-post-list-style', $style_css);

    register_block_type('ca-design-system/event-post-list', array(
        'script' => 'ca-design-system-event-post-list-web-component',
        'editor_script' => 'ca-design-system-event-post-list-editor-script',
        'style' => 'ca-design-system-event-post-list-style', // Not performant/render blocking by default
        'editor_style' => 'ca-design-system-event-post-list-editor-style',
        'render_callback' => 'cagov_design_system_event_post_list_dynamic_render_callback'
    ));
}

function cagov_design_system_event_post_list_dynamic_render_callback($block_attributes, $content)
{
    $host = "http://";
    if( isset($_SERVER['HTTPS'] ) ) {
        $host = "https://";
    }

    $domain = $host . $_SERVER['HTTP_HOST'];
    $title = isset($block_attributes["title"]) ? $block_attributes["title"] : "Recent Posts";
    $count = isset($block_attributes["count"]) ? $block_attributes["count"] : "10";
    $order = isset($block_attributes["order"]) ? $block_attributes["order"] : "desc";
    $category = isset($block_attributes["category"]) ? $block_attributes["category"] : "announcements,press-releases";
    $endpoint = isset($block_attributes["endpoint"]) ? $block_attributes["endpoint"] : "$domain/wp-json/wp/v2";
    $readMore = isset($block_attributes["readMore"]) ? esc_html($block_attributes["readMore"]) : "";
    $noResults = isset($block_attributes["noResults"]) ? $block_attributes["noResults"] : "No posts found";
    $showExcerpt = isset($block_attributes["showExcerpt"]) ? $block_attributes["showExcerpt"] : "true";
    $showPublishedDate = isset($block_attributes["showPublishedDate"]) ? $block_attributes["showPublishedDate"] : "true";
    $showPagination = isset($block_attributes["showPagination"]) ? $block_attributes["showPagination"] : "true";


    return <<<EOT
    <div class="wp-block-ca-design-system-event-post-list cagov-event-post-list cagov-stack">
        <div>
        
            <h3>$title</h3>
            <cagov-event-post-list 
                class="event-post-list" 
                data-category="$category"
                data-count="$count"
                data-order="$order"
                data-endpoint="$endpoint"
                data-show-excerpt="$showExcerpt"
                data-show-published-date="$showPublishedDate"
                data-no-results="$noResults"
                data-show-pagination="$showPagination"
                data-read-more="$readMore"
                data-filter="none"
            >
            </cagov-event-post-list>
        </div>
    </div>
    EOT;
}

function cagov_design_system_gb_register_event_post_list_web_component_callback()
{

    wp_register_script(
        'ca-design-system-event-post-list-web-component',
        plugins_url('web-component.js', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'web-component.js'),
    );

    wp_enqueue_script('ca-design-system-event-post-list-web-component');
}

