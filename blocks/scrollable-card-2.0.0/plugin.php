<?php

/**
 * Plugin Name:       DS Scrollable Card
 * Description:       Card for content. Designed for page content. Provides image asset, name, description and hyperlink.
 * Plugin URI:        https://github.com/cagov/design-system-contrib/components/scrollable-card
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Version:           1.0.0
 * Author:            California Office of Data & Innovation | https://innovation.ca.gov
 * @package           cagov-design-system
 */


/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function cagov_design_system_ds_scrollable_card_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'cagov_design_system_ds_scrollable_card_block_init' );



/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function cagov_design_system_ds_page_navigation_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'cagov_design_system_ds_page_navigation_block_init' );



defined('ABSPATH') || exit;

/**
 * Load all translations for our plugin.
 */
add_action('init', 'cagov_design_system_gutenberg_block_scrollable_card');

function cagov_design_system_gutenberg_block_scrollable_card()
{
    load_plugin_textdomain('cagov-design-system', false, basename(__DIR__) . '/languages');
}

/**
 * Register all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 */
function cagov_design_system_register_scrollable_card()
{
    if (!function_exists('register_block_type')) {
        // Gutenberg is not active.
        return;
    }

    wp_register_script(
        'ca-design-system-behavior-glider-js',
        plugins_url('dist/glider.js/glider.min.js', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'dist/glider.js/glider.min.js')
    );
    wp_enqueue_script('ca-design-system-behavior-glider-js');

    wp_register_style(
        'ca-design-system-behavior-glider-css',
        plugins_url('dist/glider.js/glider.min.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'dist/glider.js/glider.min.css')
    );
    wp_enqueue_style('ca-design-system-behavior-glider-css');

    wp_register_script(
        'ca-design-system-scrollable-card-block',
        plugins_url('build/block.js', __FILE__),
        array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore'),
        filemtime(plugin_dir_path(__FILE__) . 'build/block.js')
    );

    wp_register_style(
        'ca-design-system-scrollable-card-style-editor',
        plugins_url('build/editor.css', __FILE__),
        array('wp-edit-blocks'),
        filemtime(plugin_dir_path(__FILE__) . 'build/editor.css')
    );

    wp_register_style('ca-design-system-scrollable-card-style', false);
    
    $style_css = file_get_contents(plugin_dir_path(__FILE__) . '/build/index.css', __FILE__);
    wp_add_inline_style('ca-design-system-scrollable-card-style', $style_css);

    wp_register_script(
        'ca-design-system-scrollable-card-behavior',
        plugins_url('build/index.js', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'build/index.js')
    );

    wp_enqueue_script('ca-design-system-scrollable-card-behavior');

    register_block_type('ca-design-system/scrollable-card', array(
        'style' => 'ca-design-system-scrollable-card-style',
        'editor_style' => 'ca-design-system-scrollable-card-style-editor',
        'editor_script' => 'ca-design-system-scrollable-card-block',
        'render_callback' => 'cagov_scrollable_card_dynamic_render_callback'
    ));
}

add_action('init', 'cagov_design_system_register_scrollable_card');

function cagov_scrollable_card_wp_get_attachment($attachment_id, $size = 'thumbnail')
{
    $attachment = get_post($attachment_id);
    if (isset($attachment)) {
        $media_object = wp_get_attachment_metadata($attachment_id);
        // print_r($media_object);

        if (isset($media_object['sizes'][$size])) {
            return array(
                'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
                'caption' => $attachment->post_excerpt,
                'description' => $attachment->post_content,
                'src' => wp_get_attachment_image_url($attachment_id, $size),
                'title' => $attachment->post_title,
                'width' => $media_object['sizes'][$size]['width'],
                'height' => $media_object['sizes'][$size]['height'],
            );
        }
    }
    return null;
}

function cagov_scrollable_card_dynamic_render_callback($block_attributes, $content)
{
    $title = isset($block_attributes['title']) ? $block_attributes['title'] : '';

    // Most recent media content
    $media_id = isset($block_attributes['mediaID']) ? $block_attributes['mediaID'] : null;
    if (null !== $media_id) {
        $media_object_thumbnail = cagov_scrollable_card_wp_get_attachment($media_id, 'thumbnail');
    }

    $image_html_thumbnail = '';
    if (isset($media_object_thumbnail)) {
        if (null !== $media_object_thumbnail['src']) {
            $image_html_thumbnail = '<img src="' . $media_object_thumbnail['src'] . '" alt="' . $media_object_thumbnail['alt'] . '" width="' . $media_object_thumbnail['width'] . '" height="' . $media_object_thumbnail['height'] . '" />';
        }
    }

    $card_image = null;
    if ('' !== $image_html_thumbnail) {
        $card_link = isset($block_attributes['cardLink']) ? $block_attributes['cardLink'] : null;
        if (null !== $card_link) {
            $card_image = '<div class="cagov-card-image">' . '<a href="' . $card_link . '">' . $image_html_thumbnail . '</a>' . '</div>';
        } else {
            $card_image = '<div class="cagov-card-image">' . $image_html_thumbnail . '</div>';
        }
    }

    $body = isset($block_attributes['body']) ? $block_attributes['body'] : '';
    $inner_blocks = do_blocks($content);

    return '<div class="wp-block-ca-design-system-scrollable-card cagov-scrollable-card cagov-stack">' .
        $card_image .
        '<div class="cagov-card-content">' .
        '<h3>' . $title . '</h3>' .
        $inner_blocks .
        '</div></div>';
}
 