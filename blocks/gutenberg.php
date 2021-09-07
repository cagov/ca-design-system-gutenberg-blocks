<?php

/**
 * Add custom Gutenberg Blocks from the CA Design System
 *
 * @package CADesignSystem
 */

cagov_gb_init();

function cagov_gb_init()
{
    // Load all block dependencies and files.
    cagov_gb_load_block_dependencies();

    // Create special categories for design system blocks
    cagov_gb_load_block_pattern_categories();
    cagov_gb_load_block_category();

    // Get all scripts
    add_action('wp_enqueue_scripts', 'cagov_gb_build_scripts_frontend', 100);
    add_action('enqueue_block_editor_assets', 'cagov_gb_build_scripts_editor', 100);

    // Add metadata to WP-API
    add_action('rest_api_init', 'cagov_gb_register_rest_field');
    add_filter('get_the_excerpt', 'cagov_gb_excerpt');

    // Performance experiment    
    // add_action( 'wp_enqueue_scripts', 'cagov_remove_wp_block_library_css', 100 );
    // add_action('init', 'cagov_remove_wp_embed_and_jquery');

    // remove_action('wp_print_styles', 'print_emoji_styles');
    // remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    // remove_action( 'admin_print_styles', 'print_emoji_styles' );

}

function cagov_remove_wp_block_library_css(){
    // wp_dequeue_style( 'wp-block-library' ); // Needed for WP layouts
    // wp_dequeue_style( 'wp-block-library-theme' );
} 


// Experimental code removal
function cagov_remove_wp_embed_and_jquery() {
	if (!is_admin()) {
		// wp_deregister_script('wp-embed'); // 
        // wp_deregister_script('wp-emoji-release');
		// wp_deregister_script('jquery');  // Bonus: remove jquery too if it's not required
        // remove_action('wp_head', 'print_emoji_detection_script', 7);
	}
}

/**
 * Load all patterns and blocks.
 */
function cagov_gb_load_block_dependencies()
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
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . 'patterns/events/plugin.php';

    // Default Gutenberg block construction method
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/page-alert/plugin.php'; // Renamed
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/card/plugin.php'; // Planning to rename to: 'call-to-action-button' - Renamed in GB interface labels but not code
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/card-grid/plugin.php'; // Planning to rename to: 'call-to-action-grid' - Renamed in GB interface labels but not code
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/feature-card/plugin.php'; // Planning to rename to feature-card - Renamed in GB interface labels but not code
    
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/scrollable-card/plugin.php';
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/promotional-card/plugin.php'; 

    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/step-list/plugin.php'; 
    
    // CA Design System: UTILITY BLOCKS, default Gutenberg block construction method
    // - These appear in child patterns, content editors do not need to interact with these.
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/content-navigation/plugin.php';

    // Compiled Gutenberg block construction method
    // - Requires npm start for develoment and npm run build to compile into build/index.js.
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/event-detail/plugin.php';
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/event-materials/plugin.php';
}

/**
 * Register Custom Block Pattern Category.
 */
function cagov_gb_load_block_pattern_categories()
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
function cagov_gb_load_block_category()
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
function cagov_gb_build_scripts_frontend()
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
        
        add_action('wp_footer', 'cagov_gb_load_web_components_callback');
        add_action('wp_footer', 'cagov_gb_register_post_list_web_component_callback' );
        add_action('wp_footer', 'cagov_gb_register_content_navigation_web_component_callback' );

        // PERFORMANCE OPTION (re render blocking): inlining our CSS 
        // Note: only bother with this if a plugin isn't available to automatically doing this, and also change this rendering for our blocks
        $critical_css = file_get_contents(CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/page.css');
        echo '<style>' . $critical_css . '</style>';
    }
}

function cagov_gb_load_web_components_callback() {
    // wp_enqueue_script(
    //     'ca-design-system-npm-web-components-bundle',
    //     "https://files.covid19.ca.gov/js/components/bundle/v1/index.min.js",
    //     array(),
    // );
}

/**
 * Add compiled external web components (for rapid development without requiring plugin release)
 *
 * @param [type] $tag
 * @param [type] $handle
 * @param [type] $src
 * @return void
 */
function cagov_gb_build_scripts_editor()
{
    /* Compiled dynamic blocks. Used for more complex blocks with more UI interaction. Generated using npm run build from src folder, which builds child blocks. */
    wp_enqueue_script(
        'ca-design-system-blocks',
        CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'build/index.js',
        // array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-date', 'wp-compose', 'underscore', 'moment', 'wp-data'), // Performance bottleneck
    );
    
    wp_enqueue_style('ca-design-system-gutenberg-blocks-editor',  CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/editor.css', false);
}

/**
 * Add additional metadata to API for headless rendering
 *
 * @return void
 */
function cagov_gb_register_rest_field()
{
    // @TODO some of this will be scoped to the theme/plugin
    // Starting with block content for API then will do other assets
    register_rest_field(
        'post',
        'design_system_fields',
        array(
            'get_callback'    => 'cagov_gb_get_custom_fields',
            'update_callback' => null,
            'schema'          => null, // @TODO look up what our options are here
        )
    );

    register_rest_field(
        'post',
        'site_settings',
        array(
            'get_callback'    => 'cagov_site_settings',
            'update_callback' => null,
            'schema'          => null, // @TODO look up what our options are here
        )
    );

    register_rest_field(
        'post',
        'og_meta',
        array(
            'get_callback'    => 'cagov_og_meta',
            'update_callback' => null,
            'schema'          => null, // @TODO look up what our options are here
        )
    );


    register_rest_field(
        'page',
        'design_system_fields',
        array(
            'get_callback'    => 'cagov_gb_get_custom_fields',
            'update_callback' => null,
            'schema'          => null, // @TODO look up what our options are here
        )
    );

    register_rest_field(
        'page',
        'og_meta',
        array(
            'get_callback'    => 'cagov_og_meta',
            'update_callback' => null,
            'schema'          => null, // @TODO look up what our options are here
        )
    );

    register_rest_field(
        'page',
        'site_settings',
        array(
            'get_callback'    => 'cagov_site_settings',
            'update_callback' => null,
            'schema'          => null, // @TODO look up what our options are here
        )
    );

    // $meta_args = array(
    //     'type'         => 'string',
    //     'description'  => 'A meta key associated with a string meta value.',
    //     'single'       => true,
    //     'show_in_rest' => true,
    // );
    // register_post_meta( 'page', 'my_meta_key', $meta_args );

}

/**
 * Handle custom fields in API
 *
 * @param [type] $object
 * @param [type] $field_name
 * @param [type] $request
 * @return void
 */
function cagov_gb_get_custom_fields($object, $field_name, $request)
{
    global $post;
    
    $caweb_custom_post_title_display = get_post_meta($post->ID, '_ca_custom_post_title_display', true);

    $template_name = "page"; // Default template for any post.
    try {
        $current_page_template = get_page_template_slug();
        
        if (isset($current_page_template) && "" === $current_page_template) {
            if ($post->post_type === "post") {
                $current_template = "post";
            } else if  ($post->post_type === "page") {
                $current_template = "page";
            }
        } else {
            $split_template_path = isset($current_page_template) ? preg_split("/\//", $current_page_template) : "page";
            $template_file = $split_template_path[count($split_template_path) - 1];
            
            $template_name = preg_split("/\./", $template_file);
            $current_template = $template_name[0];

            if ($current_template === "cagov-content-page") {
                $current_template = "page";
            } else if ($current_template === "cagov-content-single") {
                $current_template = "post";
            } else if ($current_template === "template-page-landing") {
                $current_template = "landing";
            }
        }
    } catch (Exception $e) {
    } finally {
    }

    if ($post->post_type === "post") {
        $post_settings = cagov_post_fields($post);
        return array(
            // 'display_title' => true, // $caweb_custom_post_title_display === "on" ? true : false,
            'template' => $current_template,
            'post' => $post_settings,
        );
    } else {
        return array(
            // 'display_title' => true, // $caweb_custom_post_title_display === "on" ? true : false,
            'template' => $current_template,
        );
    }
}


function cagov_post_fields($post) {
    // print_r($post);
    $custom_post_link = get_post_meta($post->ID, '_ca_custom_post_link', true);
    $custom_post_date = get_post_meta($post->ID, '_ca_custom_post_date', true);
    $custom_post_location = get_post_meta($post->ID, '_ca_custom_post_location', true);
    $custom_event_date = get_post_meta($post->ID, '_ca_custom_event_date', true);
    $custom_event_end_date = get_post_meta($post->ID, '_ca_custom_event_end_date', true);
    $custom_event_start_time = get_post_meta($post->ID, '_ca_custom_event_start_time', true);
    $custom_event_end_time = get_post_meta($post->ID, '_ca_custom_event_end_time', true);

    return array(
        'post_link' => $custom_post_link,
        'post_date' => $custom_post_date,
        'locale' => get_locale(),
        'gmt_offset' => get_option('gmt_offset'),
        'timezone' => get_option('timezone_string'),
        'post_published_date_display' => array(
            'i18n_locale_date' => date_i18n('F j, Y',  strtotime( $post->post_date ) , false ),
            'i18n_locale_date_gmt' => date_i18n('F j, Y', strtotime( $post->post_date_gmt ) , true ),
            'i18n_locale_date_time' => date_i18n('F j, Y g:i a',  strtotime( $post->post_date ) , false ),
            'i18n_locale_date_time_gmt' => date_i18n('F j, Y g:i a', strtotime( $post->post_date_gmt ) , true ),
        ),
        'post_modified_date_display' => array(
            'i18n_locale_date' => date_i18n('F j, Y',  strtotime( $post->post_modified ) , false ),
            'i18n_locale_date_gmt' => date_i18n('F j, Y', strtotime( $post->post_modified_gmt ) , true ),
            'i18n_locale_date_time' => date_i18n('F j, Y g:i a',  strtotime( $post->post_modified ) , false ),
            'i18n_locale_date_time_gmt' => date_i18n('F j, Y g:i a', strtotime( $post->post_modified_gmt ) , true ),
            
        ),
        'post_location' => $custom_post_location,
        'event_date' => $custom_event_date,
        'event_end_date' => $custom_event_end_date,
        'event_start_time' => $custom_event_start_time,
        'event_end_time' => $custom_event_end_time
    );
}

function cagov_site_settings($object, $field_name, $request) {
    return array(
        'site_name' => get_bloginfo('name'),
        'site_description' => get_bloginfo('description'),
        'url' => get_bloginfo('url'),
        'wpurl' => get_bloginfo('wpurl'),
    );
}

function cagov_og_meta($object, $field_name, $request) {
    global $post;
    $post_meta = get_post_meta($post->ID);
        $seo_framework_output = "";
    try {
        if (function_exists('the_seo_framework')) {
            $tsf = \the_seo_framework();
            $seo_framework_output = $tsf->the_description()
            . $tsf->og_image()
            . $tsf->og_locale()
            . $tsf->og_type()
            . $tsf->og_title()
            . $tsf->og_description()
            . $tsf->og_url()
            . $tsf->og_sitename()
            . $tsf->facebook_publisher()
            . $tsf->facebook_author()
            . $tsf->facebook_app_id()
            . $tsf->article_published_time()
            . $tsf->article_modified_time()
            . $tsf->twitter_card()
            . $tsf->twitter_site()
            . $tsf->twitter_creator()
            . $tsf->twitter_title()
            . $tsf->twitter_description()
            . $tsf->twitter_image()
            . $tsf->theme_color()
            . $tsf->shortlink()
            . $tsf->canonical()
            . $tsf->paged_urls()
            . $tsf->ld_json()
            . $tsf->google_site_output()
            . $tsf->bing_site_output()
            . $tsf->yandex_site_output()
            . $tsf->baidu_site_output()
            . $tsf->pint_site_output()
            . $tsf->get_social_image_url_from_seo_settings();
        }
    } catch (Exception $e) {
        
    } finally {
    }

    // /wp-content/plugins/autodescription/inc/classes/site-options.class.php
    return array(
        "_genesis_title" => isset($post_meta["_genesis_title"]) ? $post_meta["_genesis_title"] : "",
        "_genesis_description" => isset($post_meta["_genesis_description"]) ? $post_meta["_genesis_description"] : "",
        "_genesis_canonical_uri" => isset($post_meta["_genesis_canonical_uri"]) ? $post_meta["_genesis_canonical_uri"] : "",
        "_social_image_url" => isset($post_meta["_social_image_url"]) ? $post_meta["_social_image_url"] : "",
        // "_homepage_social_image_url" => isset($post_meta["_homepage_social_image_url"]) ? $post_meta["_homepage_social_image_url"] : "",
        "_open_graph_title" => isset($post_meta["_open_graph_title"]) ? $post_meta["_open_graph_title"] : "",
        "_open_graph_description" => isset($post_meta["_open_graph_description"]) ? $post_meta["_open_graph_description"] : "",
        "_twitter_title" => isset($post_meta["_twitter_title"]) ? $post_meta["_twitter_title"] : "",
        " _tsf_title_no_blogname" => isset($post_meta[" _tsf_title_no_blogname"]) ? $post_meta[" _tsf_title_no_blogname"] : "",
        "og_rendered" => $seo_framework_output

    );
}


function cagov_gb_excerpt($excerpt)
{
    global $post;
    $meta = get_post_meta($post->ID);
    $details = $excerpt;
    try {
        // if (str_contains($meta['_wp_page_template'][0], "event")) {
        // if (isset($meta['_wp_page_template'][0]) &&  == $meta['_wp_page_template'][0] === "/Users/chachasikes/Work/ca.gov/wordpress/wordpress/wp-content/plugins/ca-design-system-gutenberg-blocks/includes/templates/template-single-event.php" || isset($meta['_wp_page_template'][0]) === "/Users/chachasikes/Work/ca.gov/wordpress/wordpress/wp-content/plugins/ca-design-system-gutenberg-blocks/includes/templates/template-single-event.php") {
        //     $blocks = parse_blocks($post->post_content);
        //     $event_date_display = "";
        //     $event_time = "";
        //     $materials = "";
        //     try {
        //         $event_details = $blocks[0]['innerBlocks'][1]['innerBlocks'][0]['attrs'];

        //         //@TODO escape && ISO format: "2025-07-21T19:00-05:00"; // @TODO reconstruct from event-detail saved data in post body.

        //         $start_date = $event_details['startDate'];
        //         // $end_date = $event_details['endDate'];
        //         $start_time = $event_details['startTime'];
        //         $end_time = $event_details['endTime'];
        //         $event_time_detail = $start_time;

        //         if ($end_time) {
        //             $event_time_detail = $event_time_detail . " – " . $end_time;
        //         }

        //         $event_date_display = "<div class=\"event-date\">" . $start_date . "</div>";
        //         $event_time = "<div class=\"event-time\">" . $event_time_detail . "</div>";
        //     } catch (Exception $e) {
        //     } finally {
        //     }
            


        //     try {
        //         $event_materials = $blocks[0]['innerBlocks'][1]['innerBlocks'][0]['attrs'];
        //         // $event_materials_agenda = $event_materials['agenda'];
        //         $event_materials_materials = $event_materials['materials'];
        //         $materials = "<div class=\"event-materials\">" . $event_materials_materials . "</div>";
        //     } catch (Exception $e) {
        //     } finally {
        //     }

        //     // ORIGINAL: return $excerpt;

        //     // @TODO smarter date handling, we can convert to ISO on date entering in GB
        //     // For now will be text entry

        //     $details = "<div class=\"event-details\">" . $event_date_display . $event_time . $materials . "</div>";
        // }
    } catch (Exception $e) {
    } finally {
    }
    return $details;
}
