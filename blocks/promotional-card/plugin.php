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

    register_block_type('ca-design-system/promotional-card', array(
        'style' => 'ca-design-system-promotional-card-style',
        'editor_style' => 'ca-design-system-promotional-card-style-editor',
        'editor_script' => 'ca-design-system-promotional-card-block',
        'render_callback' => 'cagov_promotional_card_dynamic_render_callback'
    ));
}

add_action( 'init', 'cagov_design_system_register_promotional_card' );

function cagov_promotional_card_wp_get_attachment( $attachment_id, $size = 'large')
{
    $attachment = get_post( $attachment_id );
    $media_object = wp_get_attachment_metadata($attachment_id);
    // print_r($media_object);

    return array(
        'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'src' => wp_get_attachment_image_url( $attachment_id, $size ),
        'title' => $attachment->post_title,
        'width' => $media_object['sizes'][$size]['width'],
        'height' => $media_object['sizes'][$size]['height'],
    );
}

function cagov_promotional_card_dynamic_render_callback( $block_attributes, $content )
{
    $title = isset( $block_attributes['title'] ) ? $block_attributes['title'] : '';
    // Get media object
    if ( !function_exists('wp_get_attachment') ) {
    }

    // Most recent media content
    $media_id = isset( $block_attributes['mediaID'] ) ? $block_attributes['mediaID'] : null;
    if ($media_id !== null) {
        $media_object_large = cagov_promotional_card_wp_get_attachment($media_id, 'large');
        $media_object_medium = cagov_promotional_card_wp_get_attachment($media_id, 'medium');
    }
    $image_html_large = '';
    if (isset($media_object_large)) {
        if ($media_object_large['src'] !== null) {
            $image_html_large = '<img src="' . $media_object_large['src'] . '" alt="' . $media_object_large['alt'] . '" width="' . $media_object_large['width'] . '" height="' . $media_object_large['height'] . '" />';
        }
    }

    $image_html_medium = '';
    if (isset($media_object_medium)) {
        if ($media_object_medium['src'] !== null) {
            $image_html_medium = '<img src="' . $media_object_medium['src'] . '" alt="' . $media_object_medium['alt'] . '" width="' . $media_object_medium['width'] . '" height="' . $media_object_medium['height'] . '" />';
        }
    }

    $card_date = isset( $block_attributes['date'] ) ? $block_attributes['date'] : '';
    $body = isset( $block_attributes['body'] ) ? $block_attributes['body'] : '';
    // $buttonURL = isset( $block_attributes['buttonurl'] ) ? $block_attributes['buttonurl'] : '';
    // $buttonText = isset( $block_attributes['buttontext'] ) ? $block_attributes['buttontext'] : '';
    $innerBlocks = do_blocks( $content );
    
    return '<div>' . $image_html_large . '<h2>' . $title . '</h2>' . htmlentities($body) . $card_date . $innerBlocks . '</div>';
}
