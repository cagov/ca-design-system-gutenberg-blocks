<?php

/**
 * Add custom Gutenberg Blocks from the CA Design System
 *
 * @package CADesignSystem
 */

cagov_design_system_posts_detail__init();

function cagov_design_system_posts_detail__init()
{
    // Add post detail metadata to WP-API

    add_action('rest_api_init', 'cagov_design_system_posts_register_custom_rest_fields');
    
    add_filter( 'rest_post_collection_params', 'cagov_design_system_filter_posts_add_rest_orderby_params', 10, 2 );

    add_filter( 'rest_post_query', 'cagov_design_system_filter_posts_add_rest_post_query', 10, 3);
}

function cagov_design_system_posts_register_custom_rest_fields() {
    register_rest_field(
        'post',
        'custom_post_date',
        array(
            'get_callback'    => 'cagov_design_system_rest_custom_post_date',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    
    register_rest_field(
        'post',
        'meta',
        array(
            'get_callback'    => 'cagov_design_system_get_post_custom_fields',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function cagov_design_system_posts_get_custom_fields()
{
    global $post;
    $custom_fields = cagov_design_system_get_post_custom_fields($post);
    return  $custom_fields;
}

function cagov_design_system_get_post_custom_fields($post)
{
    global $post;
    try {
        $custom_post_link = get_post_meta($post->ID, '_ca_custom_post_link', true);
        $custom_post_date = get_post_meta($post->ID, '_ca_custom_post_date', true);
        $custom_post_location = get_post_meta($post->ID, '_ca_custom_post_location', true);
    
        return array(
            'custom_post_link' => $custom_post_link,
            'custom_post_date' => $custom_post_date,
            'custom_post_location' => $custom_post_location,
        );
        
    } catch (Exception $e) {
    } finally {
    }
    return null;
}

function cagov_design_system_rest_custom_post_date($post)
{
    global $post;
    try {
        $custom_post_date = get_post_meta($post->ID, '_ca_custom_post_date', true);
        return $custom_post_date;
    } catch (Exception $e) {
    } finally {
    }
    return null;
}
// eg. wp-json/wp/v2/posts?categories=7&orderby=custom_post_date
function cagov_design_system_filter_posts_add_rest_orderby_params ( $params ) {
    if (isset($params) && is_array($params)) {
        $params['custom_post_date'] = array(
            'description'        => __( 'Custom post date' ),
            'type'               => 'string',
        );        
        $params["orderby"]['enum'][] = "custom_post_date";
    }
	return $params;
}

function cagov_design_system_filter_posts_add_rest_post_query($query_args, $request) {
    if ( null !== $request['orderby'] && null !== $request['custom_post_date_sort'] ) {
        $query_args['meta_key'] = "_ca_custom_post_date";
        $query_args['orderby'] = "meta_value";
        $query_args['order'] = "DESC";
    }
    return $query_args;
}

