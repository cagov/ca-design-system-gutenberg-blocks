<?php


// Add metadata to WP-API
add_action('rest_api_init', 'cagov_gb_register_meta_categories_fields');

/**
 * Add additional metadata to API for headless rendering
 *
 * @return void
 */
function cagov_gb_register_meta_categories_fields()
{
    register_rest_field(
        'post',
        'headless_categories',
        array(
            'get_callback'    => 'cagov_meta_categories',
            'update_callback' => null,
            'schema'          => null, // @TODO look up what our options are here
        )
    );

    register_rest_field(
        'page',
        'headless_categories',
        array(
            'get_callback'    => 'cagov_meta_categories',
            'update_callback' => null,
            'schema'          => null, // @TODO look up what our options are here
        )
    );
}

function cagov_meta_categories($object, $field_name, $request)
{
    try {
        $categories = get_the_category($object['id']);
        return $categories;
    } catch (Exception $e) {
    } finally {
    }
    return array();
}
