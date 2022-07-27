<?php

/**
 * Add custom Gutenberg Blocks from the CA Design System
 *
 * @package CADesignSystem
 */

cagov_design_system_posts_init();

function cagov_design_system_posts_init()
{
    // Load all block dependencies and files.
    cagov_design_system_posts_load_block_dependencies();
}

/**
 * Load all patterns and blocks.
 */
function cagov_design_system_posts_load_block_dependencies()
{
    include_once plugin_dir_path(__FILE__) . 'blocks/announcement-list/plugin.php'; // Block, uses post-list webcomponent
    include_once plugin_dir_path(__FILE__) . 'blocks/post-list/plugin.php'; // Block, uses post-list webcomponent
    include_once plugin_dir_path(__FILE__) . 'metabox.php';
    include_once plugin_dir_path(__FILE__) . 'api.php';
}
