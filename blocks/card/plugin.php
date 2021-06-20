<?php

/**
 * Plugin Name: Card
 * Plugin URI: TBD
 * Description: TBD
 * Version: 1.1.0
 * Author: California Office of Digital Innovation
 * @package ca-design-system
 */

defined('ABSPATH') || exit;

/**
 * Load all translations for our plugin from the MO file.
 */
add_action('init', 'ca_design_system_gutenberg_blocks_card');

function ca_design_system_gutenberg_blocks_card()
{
    load_plugin_textdomain('ca-design-system', false, basename(__DIR__) . '/languages');
}

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function ca_design_system_gutenberg_blocks_card_dynamic_render_callback($block_attributes, $content)
{
    $title = isset($block_attributes["title"]) ? $block_attributes["title"] : "";
    $url = isset($block_attributes["url"]) ? $block_attributes["url"] : null;
    return <<<EOT
        <a href="$url" class="wp-block-ca-design-system-card no-deco cagov-card">
            <span class="card-text">$title</span>
            <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><g><path d="M0,0h24v24H0V0z" fill="none"></path></g><g><polygon points="6.23,20.23 8,22 18,12 8,2 6.23,3.77 14.46,12"></polygon></g></svg>
        </a>
    EOT;
}

function ca_design_system_gutenberg_blocks_register_card()
{

    if (!function_exists('register_block_type')) {
        // Gutenberg is not active.
        return;
    }

    wp_register_script(
        'california-design-system', // @TODO this scope will conflict & multiply with all component - probably needs to be registered up one level - will move when blocks are more stabilized.
        plugins_url('block.js', __FILE__),
        array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore'),
        filemtime(plugin_dir_path(__FILE__) . 'block.js')
    );

    wp_register_style(
        'ca-design-system-card-editor',
        plugins_url('editor.css', __FILE__),
        array('wp-edit-blocks'),
        filemtime(plugin_dir_path(__FILE__) . 'editor.css')
    );

    wp_register_style(
        'ca-design-system-card',
        plugins_url('style.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'style.css')
    );

    register_block_type('ca-design-system/card', array(
        'style' => 'ca-design-system-card',
        'editor_style' => 'ca-design-system-card-editor',
        'editor_script' => 'california-design-system',
        'render_callback' => 'ca_design_system_gutenberg_blocks_card_dynamic_render_callback'
    ));
}
add_action('init', 'ca_design_system_gutenberg_blocks_register_card');
