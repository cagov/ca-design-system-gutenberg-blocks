<?php

/**
 * Add custom Gutenberg Blocks from the CA Design System
 *
 * @package CADesignSystem
 */

cagov_gutenberg_blocks_init();

function cagov_gutenberg_blocks_init()
{

    // Load all block dependencies and files.
    cagov_gutenberg_blocks_load_block_dependencies();

    // Create special categories for design system blocks
    cagov_gutenberg_blocks_load_block_pattern_categories();
    cagov_gutenberg_blocks_load_block_category();

    // Get all scripts
    add_action('wp_enqueue_scripts', 'cagov_gutenberg_blocks_build_scripts_frontend', 100);
    add_action('enqueue_block_editor_assets', 'cagov_gutenberg_blocks_build_scripts_editor');

    add_action('rest_api_init', 'cagov_gutenberg_blocks_register_rest_field');
}

/**
 * Add additional metadata to API for headless rendering
 *
 * @return void
 */
function cagov_gutenberg_blocks_register_rest_field()
{
    // @TODO some of this will be scoped to the theme/plugin
    // Starting with block content for API then will do other assets
    register_rest_field(
        'post',
        'design_system_fields',
        array(
            'get_callback'    => 'cagov_gutenberg_blocks_get_custom_fields',
            'update_callback' => null,
            'schema'          => null, // @TODO look up what our options are here
        )
    );
}

/**
 * Handle custom fields in API
 *
 * @param [type] $object
 * @param [type] $field_name
 * @param [type] $request
 * @return void
 */
function cagov_gutenberg_blocks_get_custom_fields($object, $field_name, $request)
{
    global $post;
    // print_r($post);
    // $cagov_content_menu_sidebar = get_post_meta($post->ID, '_cagov_content_menu_sidebar', true);
    $caweb_custom_post_title_display = get_post_meta($post->ID, '_ca_custom_post_title_display', true);
    // $caweb_default_post_date_display = get_post_meta($post->ID, '_ca_default_post_date_display', true);

    // Get events fields

    // $caweb_custom_css = wp_unslash(get_option('ca_custom_css'));
    // $meta_display_title = array(
    //     'type'         => 'string',
    //     'description'  => 'If the title should be visible.',
    //     'single'       => true,
    //     'show_in_rest' => true,
    // );
    // register_post_meta( 'page', 'my_meta_key', $meta_args );
    // register_post_meta( 'post', 'my_meta_key', $meta_args );
    // register_post_meta( 'post', 'display_title', $meta_display_title );

    // featured_media: 841,
    // template name


    // $term_meta = get_option('autodescription-term-meta');

    return array(
        'display_title' => $caweb_custom_post_title_display === "on" ? true : false,
        // 'term' => $term_meta
    );
}

/**
 * Load all patterns and blocks.
 */
function cagov_gutenberg_blocks_load_block_dependencies()
{

    // CA Design System BLOCKS
    // Requires webcomponents from external design system
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/accordion/plugin.php';

    // Uses local webcomponents not yet integrated with external design system
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/announcement-list/plugin.php'; // Block, uses post-list webcomponent
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/event-list/plugin.php'; // Block, uses post-list webcomponent
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/post-list/plugin.php'; // Utility block

    // CA Design System PATTERNS
    // - Load patterns, order of loading is order of appearance in patterns list.
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . 'patterns/event-pattern/plugin.php';

    // Default Gutenberg block construction method
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/page-alert/plugin.php'; // Renamed

    // (Not sure right now)
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/card/plugin.php'; // Planning to rename to: 'call-to-action-button' - Renamed in GB interface labels but not code
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/card-grid/plugin.php'; // Planning to rename to: 'call-to-action-grid' - Renamed in GB interface labels but not code
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/hero/plugin.php'; // Planning to rename to feature-card - Renamed in GB interface labels but not code

    // CA Design System: UTILITY BLOCKS, default Gutenberg block construction method
    // - These appear in child patterns, content editors do not need to interact with these.
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/content-navigation/plugin.php';

    // Compiled Gutenberg block construction method
    // - Requires npm start for develoment and npm run build to compile into build/index.js.
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/event-detail/plugin.php';
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/event-materials/plugin.php';
}

/**
 * Add required WP block scripts to front end pages.
 *
 * NOTE: This is NOT optimized for performance or file loading.
 */
function cagov_gutenberg_blocks_build_scripts_frontend()
{
    if (!is_admin()) {
        /* Compiled dynamic blocks. Used for more complex blocks with more UI interaction. Generated using npm run build from src folder, which builds child blocks. */
        wp_enqueue_script(
            'ca-design-system-blocks',
            plugins_url('/build/index.js', dirname(__FILE__)),
            array(),
        );

        wp_register_style('ca-design-system-gutenberg-blocks-page', CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/page.css', false, '1.0.10');
        wp_enqueue_style('ca-design-system-gutenberg-blocks-page');
    
        // PERFORMANCE OPTION (re render blocking): inlining our CSS 
        // Note: only bother with this if a plugin isn't available to automatically doing this, and also change this rendering for our blocks
        // $critical_css = file_get_contents(CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/page.css');
        // echo '<style>' . $critical_css . '</style>';

        /**
         * Register web-component from Block child plugins. 
         * Plugins creates hooks that lets us load that component as needed.
         */
        // do_action("ca_design_system_gutenberg_blocks_register_announcement_list_web_component");
        do_action("ca_design_system_gutenberg_register_post_list_web_component");
        do_action("ca_design_system_gutenberg_register_content_navigation_web_component");

        // Front end display

        // Make sure external webcomponents are available.
        // Make sure blocks that are not web components based have what they need to render.

        /* 
            Compiled dynamic blocks. 
            - Used for more complex blocks with more UI interaction. 
            - Generated using npm run build from src folder, which builds child blocks. 
        */

        // wp_enqueue_script(
        // 	'ca-design-system-npm-web-components-bundle',
        // 	"https://cagov.github.io/cannabis.ca.gov/src/js/index.min.js",
        // 	array(),
        // );

        // wp_enqueue_script(
        //     'ca-design-system-blocks',
        //     CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'build/index.js',
        //     array(),
        //     // array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-date', 'wp-compose', 'underscore', 'moment', 'wp-data' ),
        // );



        /**
         * Register web-component from Block child plugins.
         * Plugins creates hooks that lets us load that component as needed.
         * As design system converges, these web components will move into full design system & bundle.
         * For Wordpress iteration and development of the components, blocks can include actions to include web component code.
         */
        // @TODO manage wp dependencies, WP's method of adding React elements causes performance hits, trying to mitigate this.
        // do_action('cagov_register_announcement_list_web_component');
        // do_action('cagov_register_post_list_web_component');
        // do_action('cagov_register_content_navigation_web_component');
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



function cagov_gutenberg_blocks_build_scripts_editor()
{
    // ***THIS IS A PERFORMANCE BOTTLENECK***
    wp_enqueue_script(
        'ca-design-system-blocks',
        plugins_url('/build/index.js', dirname(__FILE__)),
        array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-date', 'wp-compose', 'underscore', 'moment', 'wp-data'),
    );

    wp_enqueue_style('ca-design-system-gutenberg-blocks-editor',  CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/editor.css', false);
}

/**
 * Register Custom Block Pattern Category.
 */
function cagov_gutenberg_blocks_load_block_pattern_categories()
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
function cagov_gutenberg_blocks_load_block_category()
{
    // This doesn't load a normal plugin function (probably syntax recommendation or scoping issue.)
    add_filter(
        'block_categories',
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



// NOTES

// @TODO Add script as a module
// function cagov_gutenberg_blocks_add_type_attribute($tag, $handle, $src) {
//     // if not your script, do nothing and return original $tag
//     if ( 'ca-design-system-externally-compiled-developement-web-components' !== $handle ) {
//         return $tag;
//     }

// 	// Override This snippet is inserted into the custom js section of the WordPress CAWeb theme in order to deliver the bundle of client side web components. 
// 	// This bundle is created in the github.com/cagov/cannabis.ca.gov repository.
// 	// let newScript = document.createElement("script");
// 	// newScript.type="module";
// 	// newScript.src = "https://cagov.github.io/cannabis.ca.gov/src/js/index.min.js";
// 	// document.querySelector('head').appendChild(newScript);

//     // change the script tag by adding type="module" and return it.
//     $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
//     return $tag;
// }

// function add_type_attribute($tag, $handle, $src) {
//     // if not your script, do nothing and return original $tag
//     if ( 'your-script-handle' !== $handle ) {
//         return $tag;
//     }
//     // change the script tag by adding type="module" and return it.
//     $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
//     return $tag;
// }