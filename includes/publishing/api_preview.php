<?php


// Add metadata to WP-API
add_action('rest_api_init', 'cagov_gb_register_preview');

/**
 * Add additional metadata to API for headless rendering
 *
 * @return void
 */
function cagov_gb_register_preview()
{
    register_rest_field(
        'post',
        'headless_preview',
        array(
            'get_callback'    => 'cagov_gb_meta_preview',
            'update_callback' => null,
            'schema'          => null,
        )
    );

    register_rest_field(
        'page',
        'headless_preview',
        array(
            'get_callback'    => 'cagov_gb_meta_preview',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function cagov_gb_meta_preview($object, $field_name, $request)
{
    // try {

    // } catch (Exception $e) {
    // } finally {
    // }
    return array();
}
