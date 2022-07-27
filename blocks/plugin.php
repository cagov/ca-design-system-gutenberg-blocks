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

    // Requires webcomponents from external design system
    include_once CAGOV_DESIGN_SYSTEM_GUTENBERG__DIR_PATH . '/blocks/accordion/plugin.php';
    include_once CAGOV_DESIGN_SYSTEM_GUTENBERG__DIR_PATH . '/blocks/card/plugin.php';
    include_once CAGOV_DESIGN_SYSTEM_GUTENBERG__DIR_PATH . '/blocks/card-grid/plugin.php';
    include_once CAGOV_DESIGN_SYSTEM_GUTENBERG__DIR_PATH . '/blocks/page-navigation/plugin.php';
    include_once CAGOV_DESIGN_SYSTEM_GUTENBERG__DIR_PATH . '/blocks/feature-card/plugin.php';
    include_once CAGOV_DESIGN_SYSTEM_GUTENBERG__DIR_PATH . '/blocks/page-alert/plugin.php';
    include_once CAGOV_DESIGN_SYSTEM_GUTENBERG__DIR_PATH . '/blocks/promotional-card/plugin.php';
    include_once CAGOV_DESIGN_SYSTEM_GUTENBERG__DIR_PATH . '/blocks/regulatory-outline/plugin.php';
    include_once CAGOV_DESIGN_SYSTEM_GUTENBERG__DIR_PATH . '/blocks/step-list/plugin.php';
    include_once CAGOV_DESIGN_SYSTEM_GUTENBERG__DIR_PATH . '/blocks-archive/scrollable-card/plugin.php';
    // include_once CAGOV_DESIGN_SYSTEM_GUTENBERG__DIR_PATH . '/blocks/scrollable-card-2.0.0/plugin.php';
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
    add_action( 'admin_enqueue_scripts', 'cagov_design_system_add_admin_scripts', 10, 1 );

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

    global $wp_version;

    $is_under_5_8 = version_compare($wp_version, "5.8", '<');

    if ($is_under_5_8) {
        add_filter('block_categories', function ($categories, $post) {
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
        }, 10, 2);
    } else {
        add_filter('block_categories_all', function ($categories, $post) {
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
        }, 10, 2);
    }
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
        if ('CAWeb' == $theme->name) {
   
            // Locally override css.
            wp_enqueue_style('ca-design-system-design-system-components-css-style',  CAGOV_DESIGN_SYSTEM_GUTENBERG__ADMIN_URL . 'blocks/styles/components/index.css', array(), "1.1.7.1");
        }

        // This needs to load after page is rendered.
        wp_register_script(
            'ca-design-system-blocks-web-components',
            CAGOV_DESIGN_SYSTEM_GUTENBERG__ADMIN_URL . 'components/build/components/build/cagov-design-system-core.1.1.7.js',
            array(),
            "1.1.7.1",
            true
        );

        wp_enqueue_script('ca-design-system-blocks-web-components');
    }
}

function cagov_design_system_add_admin_scripts( $hook ) {

    global $post;

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'post' === $post->post_type || 'page' === $post->post_type ) {     
            wp_register_script(
                'ca-design-system-blocks-web-components-editor',
                CAGOV_DESIGN_SYSTEM_GUTENBERG__ADMIN_URL . 'build/index.js',
                array(),
                "1.1.7.1",
                true
            );
       
    
            wp_enqueue_script('ca-design-system-blocks-web-components-editor');
            
        }
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
    wp_enqueue_style('cagov-gutenberg-blocks-editor',  CAGOV_DESIGN_SYSTEM_GUTENBERG__ADMIN_URL . 'styles/editor.css', false);
}