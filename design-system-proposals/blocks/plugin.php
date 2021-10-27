<?php

/**
 * Add custom Gutenberg Blocks from the CA Design System
 *
 * @package CADesignSystem
 */

cagov_cannabis_library_init();

function cagov_cannabis_library_init()
{
    // Load all block dependencies and files.
    cagov_cannabis_library_load_block_dependencies();

    // Get all scripts
    add_action('wp_enqueue_scripts', 'cagov_cannabis_library_build_scripts_frontend', 100);
    add_action('enqueue_block_editor_assets', 'cagov_cannabis_library_build_scripts_editor', 100);
}

/**
 * Load all patterns and blocks.
 */
function cagov_cannabis_library_load_block_dependencies()
{
    
    // @TODO WHEN WE HAVE NEW FEATURES NOT IN DESIGN SYSTEM, add them here
    // include_once plugin_dir_path(__FILE__) . 'new-component/plugin.php';
}

/**
 * Add required WP block scripts to front end pages.
 *
 * NOTE: This is NOT optimized for performance or file loading.
 */
function cagov_cannabis_library_build_scripts_frontend()
{
    if (!is_admin()) {

        // Javascript bundles

        // Make sure external webcomponents are available.
        // Make sure blocks that are not web components based have what they need to render.

        /* 
            Compiled dynamic blocks. 
            - Used for more complex blocks with more UI interaction. 
            - Generated using npm run build from src folder, which builds child blocks. 
        */

        // Add local web components without triggering render blocking

        // add_action('wp_footer', 'cagov_cannabis_register_post_list_web_component_callback');
        // add_action('wp_footer', 'cagov_cannabis_register_content_navigation_web_component_callback');

        // PERFORMANCE OPTION (re render blocking): inlining our CSS 
        // Note: only bother with this if a plugin isn't available to automatically doing this, and also change this rendering for our blocks
        // $critical_css = file_get_contents(CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'styles/page.css');
        // echo '<style>' . $critical_css . '</style>';
    }
}

/**
 * Add compiled external web components (for rapid development without requiring plugin release)
 *
 * @param [type] $tag
 * @param [type] $handle
 * @param [type] $src
 * @return void
 */
function cagov_cannabis_library_build_scripts_editor()
{
    /* Compiled dynamic blocks. Used for more complex blocks with more UI interaction. Generated using npm run build from src folder, which builds child blocks. */
    wp_enqueue_script(
        'ca-design-system-blocks',
        CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'build/index.js',
        // array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-date', 'wp-compose', 'underscore', 'moment', 'wp-data'), // Performance bottleneck
    );

    wp_enqueue_style('cagov-gutenberg-blocks-editor',  CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'styles/editor.css', false);
}
