<?php

/**
 * Load Gutenberg blocks scripts
 */



/**
 * Add custom Gutenberg Blocks from the CA Design System
 *
 * @package CADesignSystem
 */

cagov_design_system_load();

function cagov_design_system_load()
{
    // Load all block dependencies and files.
    cagov_design_system_load_block_dependencies();

    // Get all scripts
    add_action('wp_enqueue_scripts', 'cagov_design_system_build_scripts_frontend', 100);
    add_action('enqueue_block_editor_assets', 'cagov_design_system_build_scripts_editor', 100);
}



/**
 * Load all patterns and blocks.
 */
function cagov_design_system_load_block_dependencies()
{
    // CA Design System BLOCKS
    // Requires webcomponents from external design system
    include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-design-system/blocks/accordion/plugin.php';
    include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-design-system/blocks/card/plugin.php'; // Planning to rename to: 'call-to-action-button' - Renamed in GB interface labels but not code
    include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-design-system/blocks/card-grid/plugin.php'; // Planning to rename to: 'call-to-action-grid' - Renamed in GB interface labels but not code
    include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-design-system/blocks/content-navigation/plugin.php';
    
    include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-design-system/blocks/feature-card/plugin.php';
    include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-design-system/blocks/page-alert/plugin.php';
    
    include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-design-system/blocks/promotional-card/plugin.php';
    include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-design-system/blocks/step-list/plugin.php';
    include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-design-system/blocks/scrollable-card/plugin.php';

}

function cagov_design_system_init()
{
    // Create special categories for design system blocks
    cagov_design_system_load_block_pattern_categories();
    cagov_design_system_load_block_category();
}

add_action('init', 'cagov_design_system_init');

/**
 * Register Custom Block Pattern Category.
 */
function cagov_design_system_load_block_pattern_categories()
{
    if (function_exists('register_block_pattern_category')) {
        register_block_pattern_category(
            'ca-design-system',
            array('label' => esc_html__('CA Design System', 'ca-design-system'))
        );
    }
}

/**
 * Register Custom Block Category.
 */
function cagov_design_system_load_block_category()
{
    // This doesn't load a normal plugin function (probably syntax recommendation or scoping issue.)
    add_filter(
        'block_categories_all',
        function ($categories, $post) {
            return array_merge(
                array(
                    array(
                        'slug'  => 'ca-design-system',
                        'title' => 'CA Design System',
                    ),
                ),
                array(
                    array(
                        'slug'  => 'ca-design-system-utilities',
                        'title' => 'CA Design System: Utilities',
                    ),
                ),
                $categories,
            );
        },
        10,
        2
    );
}

/**
 * Add required WP block scripts to front end pages.
 *
 * NOTE: This is NOT optimized for performance or file loading.
 */
function cagov_design_system_build_scripts_frontend()
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

        // add_action('wp_footer', 'cagov_gutenberg_register_post_list_web_component_callback');

        // PERFORMANCE OPTION (re render blocking): inlining CSS 
        // NOTE We hope to avoid this & only require editor CSS for this plugin.
        $critical_css = file_get_contents(CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'styles/page.css');
        echo '<style>' . $critical_css . '</style>';
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
function cagov_design_system_build_scripts_editor()
{
    /* Compiled dynamic blocks. Used for more complex blocks with more UI interaction. Generated using npm run build from src folder, which builds child blocks. */
    // wp_enqueue_script(
    //     'ca-design-system-blocks',
    //     CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'build/index.js',
    //     // array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-date', 'wp-compose', 'underscore', 'moment', 'wp-data'), // Performance bottleneck
    // );

    wp_enqueue_style('cagov-gutenberg-blocks-editor',  CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'styles/editor.css', false);
}
