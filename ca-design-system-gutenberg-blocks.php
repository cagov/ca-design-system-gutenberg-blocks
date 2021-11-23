<?php

/**
 * Plugin Name: ca.gov Design System Headless Wordpress
 * Plugin URI: https://github.com/cagov/ca-design-system-gutenberg-blocks
 * Description: Create content with the California Design System.
 * Author: Office of Digital Innovation
 * Author URI: https://digital.ca.gov
 * Version: 1.1.3
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
define('CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__VERSION', '1.1.3');
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
	include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/core/class-ca-design-system-gutenberg-blocks-plugin-update.php';
}

/* Include publishing system integrations and features */
// Convert The SEO Framework data to OG_meta spec for the design system
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/api_autodescription.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/api_redirection.php';

// Deliver page template names in safe location that does not break the WP API
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/api_page_templates.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/api_meta_categories.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/api_rest_api_headless.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/api_meta_tags.php';
// Headless publishing features
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/api_publishing.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/api_preview.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/preview_button.php';
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/publishing/site_options.php';

/* Include Gutenberg blocks and patterns. */
// Core design system blocks (periodically synced with design system changes)
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-design-system/blocks/plugin.php';
// Connect content modules/patterns 
// Patterns have more data & API requirements and multiple layouts.
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-patterns/cagov-design-system-events/plugin.php'; // @TODO NEW Fix event api sorting
require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-patterns/cagov-design-system-posts/plugin.php';


// Future campaign toolkits may require more, but currently we are including the components in the design system, so disabling this interface for now.
// require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-patterns/cagov-design-system-campaigns/plugin.php';

// Add design system proposals
// include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/design-system-proposals/plugin.php';

// An agency could also create a new plugin similar to this one & include agency specific blocks, services and patterns as needed.

// @PLACEHOLDER for connecting agency specific site settings without CAWeb theme.
// require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/_proposed/cagov-agency-content/plugin.php';
// @PLACEHOLDER Statewide integrations
// require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/_proposed/cagov-statewide/plugin.php';
// @SUGGESTION: Services integrations
// require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/_proposed/cagov-services-feedback/plugin.php';
// require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/_proposed/cagov-services-translations/plugin.php';
// require_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/_proposed/cagov-services-search/plugin.php';

// We host this plugin on multiple platforms and WordPress base installs. Accomodate the differences in themes, and support monolithic WordPress as well as ODI Publishing headless wordpress.

include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/roles.php';

$theme = wp_get_theme();

// If we are using the CAWeb theme (hosted on Flywheel)
if ( 'CAWeb' == $theme->name) {
	// Add page templates
	if (!class_exists('CAGOVDesignSystemHeadlessWordPress_Plugin_Templates_Loader')) {
		include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/class-ca-design-system-gutenberg-blocks-templates.php';
	}

	CAGOVDesignSystemHeadlessWordPress_Plugin_Templates_Loader::get_instance();
	include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/caweb-page-resources.php';
	include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/caweb-filters.php';
	include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/caweb-functions.php';
} else {
	// @NOTE: if there is a third theme option or version number of the theme, we can handle that around here.
	// Add page templates for "Pantheon version" of theme (currently: @cagov/cagov-wp-theme-generate-press)
	if (!class_exists('CADesignSystemGutenbergBlocks_Plugin_Templates_Loader_Pantheon')) {
		include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/class-ca-design-system-gutenberg-blocks-templates-pantheon.php';
	}

	CADesignSystemGutenbergBlocks_Plugin_Templates_Loader_Pantheon::get_instance();
	include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/pantheon-filters.php';
	include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/includes/pantheon-functions.php';
}
