<?php

/**
 * Plugin Name: Promotional card
 * Plugin URI: TBD
 * Description: Card that highlights content. Designed for page content. Provides image asset, name, description and hyperlink.
 * Version: 1.0.0
 * Author: California Office of Digital Innovation
 * @package cagov-design-system
 */

defined('ABSPATH') || exit;

/**
 * Load all translations for our plugin from the MO file.
 */
add_action('init', 'cagov_design_system_gutenberg_block_promotional_card');

function cagov_design_system_gutenberg_block_promotional_card()
{
    load_plugin_textdomain('cagov-design-system', false, basename(__DIR__) . '/languages');
}

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function cagov_design_system_register_promotional_card()
{

    if (!function_exists('register_block_type')) {
        // Gutenberg is not active.
        return;
    }

    wp_register_script(
        'ca-design-system-promotional-card-block',
        plugins_url('block.js', __FILE__),
        array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore'),
        filemtime(plugin_dir_path(__FILE__) . 'block.js')
    );

    wp_register_style(
        'ca-design-system-promotional-card-style-editor',
        plugins_url('editor.css', __FILE__),
        array('wp-edit-blocks'),
        filemtime(plugin_dir_path(__FILE__) . 'editor.css')
    );

    wp_register_style('ca-design-system-promotional-card-style', false);
    $style_css = file_get_contents(plugin_dir_path(__FILE__) . '/style.css', __FILE__);
    wp_add_inline_style('ca-design-system-promotional-card-style', $style_css);

    register_block_type('cagov/promotional-card', array(
        'style' => 'ca-design-system-promotional-card-style',
        'editor_style' => 'ca-design-system-promotional-card-style-editor',
        'editor_script' => 'ca-design-system-promotional-card-block',
        'render_callback' => 'cagov_promotional_card_dynamic_render_callback',
    ));
}

add_action( 'init', 'cagov_design_system_register_promotional_card' );

function cagov_promotional_card_dynamic_render_callback( $block_attributes, $content )
{
    $title = isset( $block_attributes['title'] ) ? $block_attributes['title'] : '';
    // $card_date = isset( $block_attributes['date'] ) ? $block_attributes['date'] : '';
    $body = isset( $block_attributes['body'] ) ? $block_attributes['body'] : '';
    
    return '<div class="cagov-promotional-card cagov-block cagov-block">CONTENT' . $title . htmlentities( $body ) . '</div>';
}
