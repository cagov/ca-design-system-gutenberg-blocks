<?php

/**
 * Plugin Name: Accordion
 * Plugin URI: TBD
 * Description: An expandable section of content. Can be used on any standard content page. Allows information that is not applicable to the majority of readers to be initially hidden, and opened on demand. Includes accordion label, button, and body content. The label can be a question or a title.
 * Version: 1.1.0
 * Author: California Office of Digital Innovation
 * @package ca-design-system
 * @depends https://github.com/cagov/design-system/tree/main/components/accordion
 */

defined('ABSPATH') || exit;

/**
 * Load all translations for our plugin from the MO file.
 */
add_action('init', 'cagov_accordion');

function cagov_accordion()
{
	load_plugin_textdomain('ca-design-system', false, basename(__DIR__) . '/languages');
}

function cagov_accordion_dynamic_render_callback($block_attributes, $content)
{
	$title = isset($block_attributes["title"]) ? $block_attributes["title"] : "";
	return <<<EOT
		<cagov-accordion>
			<div class="cagov-accordion-card">
			<button class="accordion-card-header accordion-alpha" type="button" aria-expanded="false">
				<div class="accordion-title">$title</div>
				<div class="plus-minus">
				<cagov-plus></cagov-plus>
				<cagov-minus></cagov-minus>
				</div>
			</button>
			<div class="accordion-card-container">
				<div class="card-body">
					$content
				</div>
			</div>
			</div>
		</cagov-accordion>
	EOT;
}

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function ca_design_system_register_accordion()
{

	if (!function_exists('register_block_type')) {
		// Gutenberg is not active.
		return;
	}

	wp_register_script(
		'ca-design-system-accordion',
		plugins_url('block.js', __FILE__),
		array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'),
		filemtime(plugin_dir_path(__FILE__) . 'block.js'),
	);

	wp_register_style(
		'ca-design-system-accordion-editor-style',
		plugins_url('editor.css', __FILE__),
		array(),
		filemtime(plugin_dir_path(__FILE__) . 'editor.css')
	);

	register_block_type('ca-design-system/accordion', array(
		'editor_style' => 'ca-design-system-accordion-editor-style',
		'editor_script' => 'ca-design-system-accordion',
		'render_callback' => 'cagov_accordion_dynamic_render_callback'
	));
}
add_action('init', 'ca_design_system_register_accordion');
