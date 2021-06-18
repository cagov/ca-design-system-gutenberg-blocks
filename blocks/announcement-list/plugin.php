<?php

/**
 * Plugin Name: Announcement list
 * Plugin URI: TBD
 * Description: List of recent announcements. Appears on the homepage. Allows people to see the most recent announcements with the "Announcement" tag. Includes title, hyperlink to full announcement, date, and a view all link to see longer list.
 * Version: 1.1.0
 * Author: California Office of Digital Innovation
 * @package ca-design-system
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load all translations for our plugin from the MO file.
 */
add_action( 'init', 'ca_design_system_gutenberg_block_announcement_list' );

function ca_design_system_gutenberg_block_announcement_list() {
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

    wp_register_style(
        'ca-design-system-announcement-list',
        plugins_url( 'style.css', __FILE__ ),
        array( ),
        filemtime( plugin_dir_path( __FILE__ ) . 'style.css' )
    );

    register_block_type( 'ca-design-system/announcement-list', array(
        'style' => 'cagov-announcement-list',
        'editor_script' => 'ca-design-system-announcement-list',
        'render_callback' => 'ca_design_system_gutenberg_blocks_announcement_dynamic_render_callback'
    ) );
}

add_action( 'init', 'ca_design_system_register_announcement_list' );


function ca_design_system_gutenberg_blocks_register_announcement_list_web_component_callback()
{

    // Depends on post-list component.
    // Alt idea: do_action('...')
    wp_register_style(
        'ca-design-system-announcement-list',
        plugins_url('style.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'style.css')
    );

    wp_enqueue_style('ca-design-system-announcement-list');
}

add_action('ca_design_system_gutenberg_blocks_register_announcement_list_web_component', 'ca_design_system_gutenberg_blocks_register_announcement_list_web_component_callback', 10, 2);



function ca_design_system_gutenberg_blocks_announcement_dynamic_render_callback($block_attributes, $content)
{

    $title = $block_attributes["title"];
    $count = $block_attributes["count"];
    $order = $block_attributes["order"];
    $category = $block_attributes["category"];
    $endpoint = $block_attributes["endpoint"];
    $readMore = $block_attributes["readMore"];
    $showExcerpt = "false";
    $showPublishedDate = "true";

    return <<<EOT
    <div class="wp-block-ca-design-system-announcement-list cagov-announcement-list cagov-stack">
        <div>
            <h2>$title</h2>
            <cagov-post-list 
                class="post-list" 
                data-category="$category"
                data-count="5"
                data-order="desc"
                data-endpoint="$endpoint"
                data-show-excerpt="$showExcerpt"
                data-show-published-date="$showPublishedDate"
            >
            </cagov-post-list>

            <div class="read-more">
            $readMore
            </div>
        </div>
    </div>
    EOT;
}