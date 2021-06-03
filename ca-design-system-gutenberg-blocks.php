<?php
/**
 * Plugin Name: ca.gov Design System - Gutenberg Blocks
 * Plugin URI: TBD
 * Description: TBD
 * Author: 
 * Author URI: 
 * Version: 1.0.0
 * License: TBD
 * License URI: TBD
 * Text Domain: cagov-design-system
 * @package cagov-design-system
 */
if (!defined('ABSPATH')) {
    exit;
}
// Constants
define('CAGOV_DESIGN_SYSTEM_VERSION', '1.0.0');
define('CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH', plugin_dir_path(__FILE__));
define('CAGOV_DESIGN_SYSTEM_ADMIN_URL', plugin_dir_url(__FILE__));
define('CAGOV_DESIGN_SYSTEM_FILE', __FILE__);

add_action( 'admin_init', 'cagov_design_system_admin_init' );

/**
 * Admin Init
 *
 * Triggered before any other hook when a user accesses the admin area.
 * Note, this does not just run on user-facing admin screens.
 * It runs on admin-ajax.php and admin-post.php as well.
 *
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/admin_init
 * @return void
 */
function cagov_design_system_admin_init(){
    include_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/core/class-cagov-design-system-plugin-update.php';
}

if( ! class_exists('CAGOVDesignSystem') ) {
    require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/includes/class-cagov-design-system.php';
}

CAGOVDesignSystem::get_instance();
