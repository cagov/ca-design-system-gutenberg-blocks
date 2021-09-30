<?php

/**
 * Plugin Name: ca.gov Design System Headless Wordpress
 * Plugin URI: https://github.com/cagov/ca-design-system-gutenberg-blocks
 * Description: Create content with the California Design System.
 * Author: Office of Digital Innovation
 * Author URI: https://digital.ca.gov
 * Version: 1.1.0
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: ca-design-system
 *
 * @package  CAGOVDesignSystemHeadlessWordPress
 * @author   Office of Digital Innovation <info@digital.ca.gov>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/cagov/ca-design-system-gutenberg-blocks#README
 */

if (!defined('ABSPATH')) {
	exit;
}

// Plugin Constants.
define('CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__VERSION', '1.1.0');
define('CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH', plugin_dir_path(__FILE__));
define('CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL', plugin_dir_url(__FILE__));
define('CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__FILE', __FILE__);

/**
 * Plugin API/Action Reference
 * Actions Run During an Admin Page Request.
 *
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference#Actions_Run_During_an_Admin_Page_Request
 */
add_action('admin_init', 'cagov_design_system_headless_wordpress_admin_init');

/**
 * Admin Init
 *
 * Triggered before any other hook when a user accesses the admin area.
 * Note, this does not just run on user-facing admin screens.
 * It runs on admin-ajax.php and admin-post.php as well.
 * 
 * This pings the latest GitHub release and makes it available to plugin users to pull down changes.
 * For scheduling updates, please refer to GitHub. 
 * https://github.com/cagov/ca-design-system-gutenberg-blocks#README 
 * @NOTE will rename to https://github.com/cagov/cagov-design-system-headless-wordpress
 *
 * @category add_action( 'init', 'cagov_design_system_headless_wordpress_admin_init' );
 * @link   https://codex.wordpress.org/Plugin_API/Action_Reference/admin_init
 * @return void
 */
function cagov_design_system_headless_wordpress_admin_init()
{
	include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/core/class-ca-design-system-gutenberg-blocks-update.php';
}

/* Include publishing system integrations and features */
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/api_autodescription.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/api_page_templates.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/api_meta_categories.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/api_rest_api_headless.php'; // Clean up api
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/api_meta_tags.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/api_publishing.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/api_preview.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/preview_button.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/site_options.php';

/* Include Gutenberg blocks and patterns. */
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-design-system/blocks/plugin.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-agency-content/plugin.php';
// Will can create these as separately managed components for all sites & split this out sensibly for new theme (keeping an eye on the structured data & migratability/flexibility)
// require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-statewide/plugin.php';
// require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-systems-feedback/plugin.php';
// require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-systems-translations/plugin.php';
// require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-systems-search/plugin.php';

require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-patterns/cagov-design-system-events/plugin.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-patterns/cagov-design-system-posts/plugin.php';
// Future home of campaign toolkits. Unpublish from design system until it actually lives in design system.
// require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-patterns/cagov-design-system-campaigns/plugin.php';

// @TODO, we will allow agencies to extend the block library. Make sure this works with render order.

// Add page templates
if (!class_exists('CAGOVDesignSystemHeadlessWordPress_Plugin_Templates_Loader')) {
	include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/class-ca-design-system-gutenberg-blocks-templates.php';
}

CAGOVDesignSystemHeadlessWordPress_Plugin_Templates_Loader::get_instance();

// Overrides for CAWeb theme
include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/caweb-page-resources.php';
include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/caweb-filters.php';
include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/caweb-functions.php';

// Future
// - namespace rename migration function
// - Convert all blocks to static HTML

// Add cannabis only code (subplugin needs some work)
include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-cannabis-headless-wordpress/plugin.php';