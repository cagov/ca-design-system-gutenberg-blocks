<?php

/**
 * Plugin Name: Announcement list
 * Plugin URI: TBD
 * Description: List of recent announcements. Appears on the homepage. Allows people to see the most recent announcements with the "Announcements" tag. Includes title, hyperlink to full announcement, date, and a view all link to see longer list.
 * Version: 1.1.0
 * Author: California Office of Digital Innovation
 * @package ca-design-system
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load all translations for our plugin from the MO file.
 */
add_action( 'init', 'cagov_announcement_list' );

function cagov_announcement_list() {
    load_plugin_textdomain( 'ca-design-system', false, basename( __DIR__ ) . '/languages' );
}

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function ca_design_system_register_announcement_list() {

    if ( ! function_exists( 'register_block_type' ) ) {
        // Gutenberg is not active.
        return;
    }

    // Register custom web component
    // wp_register_script(
    //     'ca-design-system-announcement-list-web-component',
    //     plugins_url( 'web-component.js', __FILE__ ),
    //     array( ),
    //     filemtime( plugin_dir_path( __FILE__ ) . 'web-component.js' ),
    // );

    wp_register_script(
        'ca-design-system-announcement-list',
        plugins_url( 'block.js', __FILE__ ),
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore', 'moment'),
        filemtime( plugin_dir_path( __FILE__ ) . 'block.js' ),
    );

    wp_register_style( 'ca-design-system-announcement-list-style', false );
    $style_css = file_get_contents(plugin_dir_path(__FILE__) . '/index.css', __FILE__);
    wp_add_inline_style('ca-design-system-announcement-list-style', $style_css);

    register_block_type( 'ca-design-system/announcement-list', array(
        'style' => 'ca-design-system-announcement-list-style',
        'editor_script' => 'ca-design-system-announcement-list',
        'render_callback' => 'cagov_announcement_dynamic_render_callback'
    ) );
}

add_action( 'init', 'ca_design_system_register_announcement_list' );


function cagov_register_announcement_list_web_component_callback()
{

    // Depends on post-list component.
    // Alt idea: do_action('...')
    wp_register_style(
        'ca-design-system-announcement-list',
        plugins_url('index.css', __FILE__),
        array('moment'),
        filemtime(plugin_dir_path(__FILE__) . 'index.css')
    );

    wp_enqueue_style('ca-design-system-announcement-list');
}

add_action('cagov_register_announcement_list_web_component', 'cagov_register_announcement_list_web_component_callback', 10, 2);


function cagov_announcement_dynamic_render_callback($block_attributes, $content)
{

    $host = "http://";
    if( isset($_SERVER['HTTPS'] ) ) {
        $host = "https://";
    }

    $domain = $host . $_SERVER['HTTP_HOST'];
    $title = isset($block_attributes["title"]) ? $block_attributes["title"] : "Announcements";
    $count = isset($block_attributes["count"]) ? $block_attributes["count"] : "5";
    $order = isset($block_attributes["order"]) ? $block_attributes["order"] : "desc";
    $category = isset($block_attributes["category"]) ? $block_attributes["category"] : "announcements,press-releases";
    $endpoint = isset($block_attributes["endpoint"]) ? $block_attributes["endpoint"] : "$domain/wp-json/wp/v2";
    $readMore = isset($block_attributes["readMore"]) ? esc_html($block_attributes["readMore"]) : "";
    $noResults = isset($block_attributes["noResults"]) ? $block_attributes["noResults"] : "No posts found";
    $showExcerpt = isset($block_attributes["showExcerpt"]) ? $block_attributes["showExcerpt"] : "false";
    $showPublishedDate = isset($block_attributes["showPublishedDate"]) ? $block_attributes["showPublishedDate"] : "true";
    $showPagination = isset($block_attributes["showPagination"]) ? $block_attributes["showPagination"] : "false";

    return <<<EOT
    <div class="wp-block-ca-design-system-announcement-list cagov-announcement-list cagov-block">
        <h2>$title</h2>    
    
            
            <cagov-post-list 
                class="post-list cagov-stack" 
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
            </cagov-post-list>

    </div>
    EOT;
}