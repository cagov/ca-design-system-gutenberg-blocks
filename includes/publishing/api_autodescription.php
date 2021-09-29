<?php


// Add metadata to WP-API
add_action('rest_api_init', 'cagov_gb_register_autodescription_fields');

/**
 * Add additional metadata to API for headless rendering
 *
 * @return void
 */
function cagov_gb_register_autodescription_fields()
{
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
        'page',
        'autodescription',
        array(
            'get_callback'    => 'cagov_autodescription_meta',
            'update_callback' => null,
            'schema'          => null, // @TODO look up what our options are here
        )
    );
}

function cagov_autodescription_meta($object, $field_name, $request)
{
    global $post;
    $post_meta = get_post_meta($post->ID);
    try {
        if (function_exists('the_seo_framework')) {
            $tsf = \the_seo_framework();
            $tsf_post_meta =  $tsf->get_post_meta($post->ID);
            // /wp-content/plugins/autodescription/inc/classes/site-options.class.php
            $wordpress_site_defaults = array(
                'title' => $post->post_title,
                'description' => $post->post_excerpt,
                'canonical_url' =>  get_bloginfo('url') . "/" . $post->post_name,
                'site_name' => get_bloginfo('name'),
                'site_description' => get_bloginfo('description'),
                'site_url' => get_bloginfo('url'),
                'wp_url' => get_bloginfo('wpurl'),
            );
            return array(
                'tsf_post_meta' => $tsf_post_meta,
                'site_defaults' => $wordpress_site_defaults
            );
        }
    } catch (Exception $e) {
    } finally {
    }
    return array();
}
