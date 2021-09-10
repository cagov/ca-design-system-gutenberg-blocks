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
    // Adjust excerpt behavior to return intended excerpts.
    add_filter('get_the_excerpt', 'cagov_gb_excerpt');
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
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/regulatory-outline/plugin.php';

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
        add_action('wp_footer', 'cagov_gb_register_post_list_web_component_callback');
        add_action('wp_footer', 'cagov_gb_register_content_navigation_web_component_callback');

        // PERFORMANCE OPTION (re render blocking): inlining our CSS 
        // Note: only bother with this if a plugin isn't available to automatically doing this, and also change this rendering for our blocks
        $critical_css = file_get_contents(CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/page.css');
        echo '<style>' . $critical_css . '</style>';
    }
}

function cagov_gb_load_web_components_callback()
{
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
        'autodescription_meta',
        array(
            'get_callback'    => 'cagov_autodescription_meta',
            'update_callback' => null,
            'schema'          => null, // @TODO look up what our options are here
        )
    );

    register_rest_field(
        'post',
        'redirection_meta',
        array(
            'get_callback'    => 'cagov_redirection_meta',
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
        'autodescription_meta',
        array(
            'get_callback'    => 'cagov_autodescription_meta',
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

    register_rest_field(
        'page',
        'redirection_meta',
        array(
            'get_callback'    => 'cagov_redirection_meta',
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
            } else if ($post->post_type === "page") {
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


function cagov_post_fields($post)
{
    // print_r($post);
    $custom_post_link = get_post_meta($post->ID, '_ca_custom_post_link', true);
    $custom_post_date = get_post_meta($post->ID, '_ca_custom_post_date', true);
    $custom_post_location = get_post_meta($post->ID, '_ca_custom_post_location', true);
    $custom_fields = cagov_gb_get_post_custom_fields($post);
    return array(
        'post_link' => $custom_post_link,
        'post_date' => $custom_post_date,
        'locale' => get_locale(),
        'gmt_offset' => get_option('gmt_offset'),
        'timezone' => get_option('timezone_string'),
        'post_published_date_display' => array(
            'i18n_locale_date' => date_i18n('F j, Y',  strtotime($post->post_date), false),
            'i18n_locale_date_gmt' => date_i18n('F j, Y', strtotime($post->post_date_gmt), true),
            'i18n_locale_date_time' => date_i18n('F j, Y g:i a',  strtotime($post->post_date), false),
            'i18n_locale_date_time_gmt' => date_i18n('F j, Y g:i a', strtotime($post->post_date_gmt), true),
        ),
        'post_modified_date_display' => array(
            'i18n_locale_date' => date_i18n('F j, Y',  strtotime($post->post_modified), false),
            'i18n_locale_date_gmt' => date_i18n('F j, Y', strtotime($post->post_modified_gmt), true),
            'i18n_locale_date_time' => date_i18n('F j, Y g:i a',  strtotime($post->post_modified), false),
            'i18n_locale_date_time_gmt' => date_i18n('F j, Y g:i a', strtotime($post->post_modified_gmt), true),
        ),
        'post_location' => $custom_post_location,
        'custom_fields' => $custom_fields,
    );
}

function cagov_site_settings($object, $field_name, $request)
{
    return array(
        'site_name' => get_bloginfo('name'),
        'site_description' => get_bloginfo('description'),
        'url' => get_bloginfo('url'),
        'wpurl' => get_bloginfo('wpurl'),
    );
}
function cagov_redirection_meta($object, $field_name, $request)
{
    return array(
        'redirects' => ''
    );
}

function cagov_autodescription_meta($object, $field_name, $request)
{
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
        if (isset($meta['_wp_page_template']) && 0 < mb_strpos(strval($meta['_wp_page_template'][0]), "event")) {
            $details = cagov_gb_excerpt_event($post, $meta, $excerpt);
        }
    } catch (Exception $e) {
    } finally {
    }
    return $details;
}

function cagov_gb_get_post_custom_fields($post)
{
    global $post;
    $meta = get_post_meta($post->ID);
    try {
        if (isset($meta['_wp_page_template']) && 0 < mb_strpos(strval($meta['_wp_page_template'][0]), "event")) {
            return cagov_gb_custom_fields_event($post);
        }
    } catch (Exception $e) {
    } finally {
    }
    return null;
}

function cagov_gb_custom_fields_event($post)
{
    $blocks = parse_blocks($post->post_content);
    try {
        if (isset($blocks[0]['innerBlocks']) && isset($blocks[0]['innerBlocks'][1])) {
            $event_details = $blocks[0]['innerBlocks'][1]['innerBlocks'][0]['attrs'];
            return $event_details;
        }
        
    } catch (Exception $e) {
    } finally {
    }
    return null;
}
// https://wordpress.stackexchange.com/questions/251037/wp-rest-api-order-posts-by-meta-value-acf
// function cagov_gb_add_meta_vars ($current_vars) {
//     $current_vars = array_merge ($current_vars, array ('meta_key', 'meta_value'));
//     return $current_vars;
// }
// add_filter ('rest_query_vars', 'my_add_meta_vars');

// function order_rest_user_query($query_vars, $request) {
//     $orderby = $request->get_param('orderby');
//     if (isset($orderby) && $orderby === 'activo') {
//         $query_vars["orderby"] = "meta_value";
//         $query_vars["meta_key"] = "activo";
//     }
//     if (isset($orderby) && $orderby === 'fecha_alta') {
//         $query_vars["orderby"] = "meta_value_num";
//         $query_vars["meta_key"] = "fecha_alta";
//     }
//     return $query_vars;
// }

// add_filter( 'rest_user_query', 'order_rest_user_query', 10, 2);

function cagov_gb_excerpt_event($post, $meta, $excerpt)
{
    $blocks = parse_blocks($post->post_content);
    $event_date_display = "";
    $event_time = "";
    $materials = "";
    $event_excerpt = $excerpt;
    try {
        if (isset($blocks[0]['innerBlocks']) && isset($blocks[0]['innerBlocks'][1])) {
            $event_details = $blocks[0]['innerBlocks'][1]['innerBlocks'][0]['attrs'];

            // @TODO escape && ISO format: "2025-07-21T19:00-05:00"; // @TODO reconstruct from event-detail saved data in post body.
            // Note: there is also startDateTimeUTC available, but the PST display values are precalculated.
            $start_date = isset($event_details['startDate']) ? $event_details['startDate'] : "";
            $end_date = isset($event_details['endDate']) ? $event_details['endDate'] : "";
            $start_time = isset($event_details['startTime']) ? $event_details['startTime'] : "";
            $end_time = isset($event_details['endTime']) ? $event_details['endTime'] : "";
            $event_location = isset($event_details['location']) ? $event_details['location'] : "";
            $localTimezoneLabel = isset($event_details['localTimezoneLabel']) ? $event_details['localTimezoneLabel'] : "";


            // $start_datetime_utc = new DateTime($event_details['startDateTimeUTC']);
            // $start_datetime_pst = $start_datetime_utc->setTimezone(new DateTimeZone('North America/Los Angeles'));
            // $start_date = $start_datetime_pst; // date_format($start_datetime_pst, "Y-m-d"); // H:i:s


            $date_display = $start_date . " - " . $end_date;
            $time_display = $start_time . " - " . $end_time;
            if ($start_date === $end_date) {
                $date_display = $start_date;
            }
            if ($start_time === $end_time) {
                $time_display = $start_time;
            }
            $event_date_display = '<div class="event-date">' . $date_display . '</div>';
            $event_time_display = '<div class="event-time">' . $time_display . ' ' . $localTimezoneLabel . '</div>';

            $event_excerpt = '<div class="event-details">' .
                $event_date_display .
                '<br />' .
                $event_time_display .
                '<br />' .
                '<div class="event-location">' .
                $event_location .
                '</div>' .
                '</div>';
        }
    } catch (Exception $e) {
    } finally {
    }
    return $event_excerpt;
}
