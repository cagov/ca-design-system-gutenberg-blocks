<?php

/**
 * Plugin Name: Post list
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
add_action('init', 'ca_design_system_gutenberg_block_post_list');

function ca_design_system_gutenberg_block_post_list()
{
    load_plugin_textdomain('ca-design-system', false, basename(__DIR__) . '/languages');
}

function ca_design_system_gutenberg_blocks_post_list_dynamic_render_callback($block_attributes, $content)
{

    $title = isset($block_attributes["title"]) ? $block_attributes["title"] : "";
    $count = isset($block_attributes["count"]) ? $block_attributes["count"] : "";
    $order = isset($block_attributes["order"]) ? $block_attributes["order"] : "";
    $category = isset($block_attributes["category"]) ? $block_attributes["category"] : "";
    $endpoint = isset($block_attributes["endpoint"]) ? $block_attributes["endpoint"] : "";
    $readMore = isset($block_attributes["readMore"]) ? $block_attributes["readMore"] : "";
    $showExcerpt = "true";
    $showPublishedDate = "true";

    return <<<EOT
    <div class="wp-block-ca-design-system-post-list cagov-post-list cagov-stack">
        <div>
            <h3>$title</h3>
            <cagov-post-list 
                class="post-list" 
                data-category="$category"
                data-count="$count"
                data-order="$order"
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

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function ca_design_system_gutenberg_blocks_register_post_list()
{
    if (!function_exists('register_block_type')) {
        // Gutenberg is not active.
        return;
    }

    // Register custom web component
    wp_register_script(
        'ca-design-system-post-list-web-component',
        plugins_url('web-component.js', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'web-component.js'),
    );

    wp_register_script(
        'ca-design-system-post-list',  // @TODO this scope will conflict & multiply with all component - probably needs to be registered up one level - will move when blocks are more stabilized.
        plugins_url('block.js', __FILE__),
        array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore', 'moment', 'ca-design-system-post-list-web-component'),
        filemtime(plugin_dir_path(__FILE__) . 'block.js'),
    );

    wp_register_style(
        'ca-design-system-post-list-editor',
        plugins_url( 'editor.css', __FILE__ ),
        array( 'wp-edit-blocks' ),
        filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' )
    );

    wp_register_style(
        'ca-design-system-post-list',
        plugins_url('style.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'style.css')
    );

    register_block_type('ca-design-system/post-list', array(
        'style' => 'cagov-post-list',
        'editor_style' => 'ca-design-system-post-list-editor',
        'editor_script' => 'ca-design-system-post-list',
        'render_callback' => 'ca_design_system_gutenberg_blocks_post_list_dynamic_render_callback'
    ));
}
add_action('init', 'ca_design_system_gutenberg_blocks_register_post_list');

function ca_design_system_gutenberg_blocks_register_post_list_web_component_callback()
{
    wp_register_script(
        'ca-design-system-post-list-web-component',
        plugins_url('web-component.js', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'web-component.js'),
    );

    wp_register_style(
        'ca-design-system-post-list',
        plugins_url('style.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'style.css')
    );

    wp_enqueue_script('ca-design-system-post-list-web-component');
    wp_enqueue_style('ca-design-system-post-list');
}

add_action('ca_design_system_gutenberg_blocks_register_post_list_web_component', 'ca_design_system_gutenberg_blocks_register_post_list_web_component_callback', 10, 2);
