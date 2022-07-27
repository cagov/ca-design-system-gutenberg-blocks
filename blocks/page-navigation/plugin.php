<?php

/**
 * Plugin Name: Content Navigation
 * Plugin URI: TBD
 * Description: TBD
 * Version: 1.1.0
 * Author: California Office of Data and Innovation
 * @package ca-design-system
 */

defined('ABSPATH') || exit;

add_action('init', 'cagov_register_content_navigation');

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function cagov_register_content_navigation()
{
    if (!function_exists('register_block_type')) {
        // Gutenberg is not active.
        return;
    }

    // wp_register_script(
    //     'ca-design-system-page-navigation-web-component',
    //     plugins_url('index.js', __FILE__),
    //     array(),
    //     filemtime(plugin_dir_path(__FILE__) . 'index.js'),
    // );

    wp_register_script(
        'ca-design-system-page-navigation-editor',
        plugins_url('block.js', __FILE__),
        array('wp-blocks', 'wp-i18n', 'wp-element', 'ca-design-system-page-navigation-web-component'),
        filemtime(plugin_dir_path(__FILE__) . 'block.js'),
    );

    wp_register_style(
        'ca-design-system-page-navigation-editor-style',
        plugins_url('editor.css', __FILE__),
        false,
        filemtime(plugin_dir_path(__FILE__) . 'editor.css')
    );

    register_block_type('ca-design-system/page-navigation', array(
        'script' => 'ca-design-system-page-navigation-web-component',
        'style' => 'ca-design-system-page-navigation-style',
        'editor_script' => 'ca-design-system-page-navigation-editor',
        'editor_style' => 'ca-design-system-page-navigation-editor-style',
        'render_callback' => 'cagov_design_system_register_content_navigation_dynamic_render_callback'
    ));
}

add_action('cagov_design_system_register_content_navigation_dynamic_render', 'cagov_design_system_register_content_navigation_dynamic_render_callback', 10, 2);

function cagov_design_system_register_content_navigation_dynamic_render_callback($block_attributes, $content)
{
    return <<<EOT
    <div class="wp-block-ca-design-system-page-navigation cagov-stack">
    <div>
    <cagov-page-navigation 
        class="page-navigation" 
        data-selector="article" 
        data-editor=".edit-post-visual-editor"
        data-label="On this page"
    ></cagov-page-navigation>
    </div>
    </div>
    EOT;
}