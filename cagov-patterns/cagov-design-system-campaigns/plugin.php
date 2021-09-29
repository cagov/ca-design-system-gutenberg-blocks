<?php

/**
 * Plugin Name: CA Design System Campaigns
 * Plugin URI: TBD
 * Description: TBD
 * Version: 1.1.0
 * Author: California Office of Digital Innovation
 * @package ca-design-system
 */

defined('ABSPATH') || exit;

/**
 * Add custom Gutenberg Blocks from the CA Design System
 *
 * @package CADesignSystem
 */

// cagov_design_system_campaigns_init(); // On pause

function cagov_design_system_campaigns_init()
{
    // Load all block dependencies and files.
    cagov_design_system_campaigns_load_block_dependencies();
}

/**
 * Load all patterns and blocks.
 */
function cagov_design_system_campaigns_load_block_dependencies()
{
    // include_once plugin_dir_path(__FILE__) . 'blocks/promotional-card/plugin.php';
    // include_once plugin_dir_path(__FILE__) . 'blocks/scrollable-card/plugin.php';
}

/**
 * Add compiled external web components (for rapid development without requiring plugin release)
 *
 * @param [type] $tag
 * @param [type] $handle
 * @param [type] $src
 * @return void
 */
function cagov_design_system_campaigns_build_scripts_editor()
{
    /* Compiled dynamic blocks. Used for more complex blocks with more UI interaction. Generated using npm run build from src folder, which builds child blocks. */
    wp_enqueue_script(
        'ca-design-system-blocks',
        plugin_dir_url(__FILE__) . 'build/index.js',
        array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-date', 'wp-compose', 'underscore', 'moment', 'wp-data'),

    );
}

add_action('init', 'cagov_design_system_campaigns_build_scripts_editor');
