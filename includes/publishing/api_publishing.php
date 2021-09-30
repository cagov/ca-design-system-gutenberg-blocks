<?php


// Add metadata to WP-API
add_action('rest_api_init', 'cagov_gb_register_publishing');

/**
 * Add additional metadata to API for headless rendering
 *
 * @return void
 */
function cagov_gb_register_publishing()
{
    register_rest_field(
        'post',
        'headless_publishing',
        array(
            'get_callback'    => 'cagov_gb_meta_publishing',
            'update_callback' => null,
            'schema'          => null,
        )
    );

    register_rest_field(
        'page',
        'headless_publishing',
        array(
            'get_callback'    => 'cagov_gb_meta_publishing',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function cagov_gb_meta_publishing($object, $field_name, $request)
{
    // try {

    // } catch (Exception $e) {
    // } finally {
    // }
    return array();
}
