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
    include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-design-system/blocks/regulatory-outline/plugin.php';
    include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-design-system/blocks/step-list/plugin.php';
    include_once CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/cagov-design-system/blocks/scrollable-card/plugin.php';

}
/**
 * Create special categories for design system blocks
 *
 * @return void
 */
function cagov_design_system_init()
{
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
        // PERFORMANCE OPTION (re render blocking): inlining CSS 
        // @NOTE We hope to avoid this & only require editor CSS for this plugin.
        $theme = wp_get_theme();
        // If we are using the CAWeb theme (hosted on Flywheel)
        // These styles are moved into the performant theme for new version.
        if ( 'CAWeb' == $theme->name) {
            $critical_css = file_get_contents(CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'styles/page.css');
            echo '<style>' . $critical_css . '</style>';

            // Let's try versioning these changes going forward so that we start to build more communication with updates & releases of design system code and package changes. We will need some smoother way to bring in code without requiring node_modules, can be as simple as popping a dist file in the plugin & testing it. 
            
            wp_enqueue_style('ca-design-system-caweb-override-css-style',  CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'cagov-design-system/blocks/styles/manual/manual-caweb.v1.0.2.css', false);

            // wp_enqueue_style('ca-design-system-base-css-style',  CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'cagov-design-system/blocks/styles/dist/index.css', false); Need base css for pantheon version, no need for caweb override.

            wp_enqueue_style('ca-design-system-design-system-color-scheme-css-style',  CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'cagov-design-system/blocks/styles/manual/colorscheme-cannabis.v1.0.8.min.css', false);            


            

            // wp_enqueue_style('ca-design-system-design-system-compiled-components-css-style',  CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'cagov-design-system/build/index.css', false);

            // local overrides
            wp_enqueue_style('ca-design-system-design-system-components-css-style',  CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'cagov-design-system/blocks/styles/components/index.css', false);


            // @TODO anything to do with these?
            // import './../node_modules/@cagov/ds-feedback/dist/index.js';
            // import './../node_modules/@cagov/ds-minus/index.js';
            // import './../node_modules/@cagov/ds-pagination/dist/index.js';
            // import './../node_modules/@cagov/ds-pdf-icon/src/index.js';
            // import './../node_modules/@cagov/ds-plus/index.js';
        }

        // Add compiled, versioned design system web component code. 
        // Requires compilation with npm, see README notes. @DOCS
        // wp_enqueue_script(
        //     'ca-design-system-blocks-web-components',
        //     CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'cagov-design-system/build/index.js',
        //     array()
        // );



        // This needs to load after page is rendered.
    wp_register_script(
        'ca-design-system-blocks-web-components',
        // plugins_url('behavior.js', __FILE__),
        CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'cagov-design-system/build/index.js',
        array(), "1.1.12.11", true
    );

    wp_enqueue_script('ca-design-system-blocks-web-components');



        // This is what's compiled from cannabis.ca.gov
        // wp_enqueue_script(
        //     'ca-design-system-blocks-web-components-accordion-not-broken',
        //     CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'cagov-design-system/blocks/styles/dist/index.min.covid19.js',
        //     array()
        // );

        // wp_enqueue_script(
        //     'ca-design-system-blocks-web-components',
        //     CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'cagov-design-system/styles/design-system/dist/built.js',
        //     array()
        // );
    }
}

/**
 * Add editor CSS
 *
 * @param [type] $tag
 * @param [type] $handle
 * @param [type] $src
 * @return void
 */
function cagov_design_system_build_scripts_editor()
{
    // Editor-only styles
    wp_enqueue_style('cagov-gutenberg-blocks-editor',  CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__ADMIN_URL . 'styles/editor.css', false);
}
