<?php

/**
 * Plugin Name: CA Design System Events
 * Plugin URI: TBD
 * Description: TBD
 * Version: 1.1.0
 * Author: California Office of Digital Innovation
 * @package ca-design-system
 */

defined('ABSPATH') || exit;

/**
 * Add custom Gutenberg Blocks from the CA Design System
 *
 * @package CADesignSystem
 */

cagov_design_system_events_init();

function cagov_design_system_events_init()
{
    // Load all block dependencies and files.
    cagov_design_system_events_load_block_dependencies();
}

/**
 * Load all patterns and blocks.
 */
function cagov_design_system_events_load_block_dependencies()
{
    include_once plugin_dir_path(__FILE__) . 'blocks/event-list/plugin.php'; // Block, uses post-list webcomponent
    include_once plugin_dir_path(__FILE__) . 'blocks/event-post-list/plugin.php'; // Block, uses post-list webcomponent
   
    // Compiled Gutenberg block construction method
    // - Requires npm start for develoment and npm run build to compile into build/index.js.
    include_once plugin_dir_path(__FILE__) . 'blocks/event-detail/plugin.php';
    include_once plugin_dir_path(__FILE__) . 'blocks/event-materials/plugin.php';

    include_once plugin_dir_path(__FILE__) . 'api.php';
    // include_once plugin_dir_path(__FILE__) . 'metabox.php';

}

add_action('init', 'cagov_design_system_custom_wp_block_pattern_event');

/**
 * Add compiled external web components (for rapid development without requiring plugin release)
 *
 * @param [type] $tag
 * @param [type] $handle
 * @param [type] $src
 * @return void
 */
function cagov_design_system_events_build_scripts_editor()
{
    /* Compiled dynamic blocks. Used for more complex blocks with more UI interaction. Generated using npm run build from src folder, which builds child blocks. */
    wp_enqueue_script(
        'ca-design-system-blocks',
        plugin_dir_url(__FILE__) . 'build/index.js',
        array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-date', 'wp-compose', 'underscore', 'moment', 'wp-data'),

    );
}

add_action('init', 'cagov_design_system_events_build_scripts_editor');

 
/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function cagov_design_system_custom_wp_block_pattern_event()
{
    if (!function_exists('register_block_pattern')) {
        // Gutenberg is not active.
        return;
    }

    /**
     * Register Block Pattern
     */
    register_block_pattern(
        'ca-design-system/event-pattern',
        array(
            'title'       => __('Event Pattern', 'ca-design-system'),
            'description' => __('Page layout with dynamic content navigation sidebar', 'Block pattern description', 'ca-design-system'),
            'content' => '<!-- wp:columns -->
            <div class="wp-block-columns has-2-columns">
                
                <!-- wp:column {"width":"66.66%"} -->
                <div id="main-content" class="wp-block-column" style="flex-basis:66.66%">
               
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"width":"33.33%"} -->
                    <div class="wp-block-column" style="flex-basis:33.33%">
                    <!-- wp:ca-design-system/event-detail {
                        "title": "Event Details",
                        "startDate":"",
                        "endDate":"",
                        "startTime":"",
                        "endTime":"",
                        "location:"",
                        "cost": "",
                    } -->
                    <div class="wp-block-ca-design-system-event-detail"><div class="cagov-card-body-content"></div></div>
                    <!-- /wp:ca-design-system/event-detail -->
                    </div>
                <!-- /wp:column --> 
        </div><!-- /wp:columns -->',
            "categories" => array('ca-design-system'),
        )
    );
}


// function create_post_type() {
//     $labels = array(
//       'name'               => 'Events',
//       'singular_name'      => 'Event',
//       'menu_name'          => 'Events',
//       'name_admin_bar'     => 'Event',
//       'add_new'            => 'Add New',
//       'add_new_item'       => 'Add New Event',
//       'new_item'           => 'New Event',
//       'edit_item'          => 'Edit Event',
//       'view_item'          => 'View Event',
//       'all_items'          => 'All Events',
//       'search_items'       => 'Search Events',
//       'parent_item_colon'  => 'Parent Event',
//       'not_found'          => 'No Events Found',
//       'not_found_in_trash' => 'No Events Found in Trash'
//     );
  
//     $args = array(
//       'labels'              => $labels,
//       'public'              => true,
//       'exclude_from_search' => false,
//       'publicly_queryable'  => true,
//       'show_ui'             => true,
//       'show_in_nav_menus'   => true,
//       'show_in_menu'        => true,
//       'show_in_admin_bar'   => true,
//       'menu_position'       => 5,
//       'menu_icon'           => 'dashicons-admin-appearance',
//       'capability_type'     => 'post',
//       'hierarchical'        => false,
//       'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
//       'has_archive'         => true,
//       'rewrite'             => array( 'slug' => 'events' ),
//       'query_var'           => true
//     );
  
//     register_post_type( 'cagov_event', $args );
//   }
