<?php

/**
 * Add custom Gutenberg Blocks from the CA Design System
 *
 * @package CADesignSystem
 */

cagov_agency_content_load();

function cagov_agency_content_load()
{
    // Load all block dependencies and files.
    cagov_agency_content_load_block_dependencies();

}

/**
 * Load all patterns and blocks.
 */
function cagov_agency_content_load_block_dependencies()
{
    // include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-agency-content/blocks/branding/plugin.php';
    // include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-agency-content/blocks/external-links/plugin.php';
    // include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-agency-content/blocks/go-to-top/plugin.php';
    // include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-agency-content/blocks/headless-preview/plugin.php';
    // include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-agency-content/blocks/insights/plugin.php';
    // include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-agency-content/blocks/menu/plugin.php';
    // include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-agency-content/blocks/page-templates/plugin.php';
    // include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-agency-content/blocks/pagination/plugin.php';
    // include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-agency-content/blocks/pdf-icon/plugin.php';
    // include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-agency-content/blocks/skip-to-content/plugin.php';
}

/**
 * Initialize Gutenberg blocks
 */

function cagov_agency_content_init()
{


}
add_action('init', 'cagov_agency_content_init');
