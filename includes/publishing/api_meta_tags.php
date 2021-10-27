<?php


// Add metadata to WP-API
add_action('rest_api_init', 'cagov_gb_register_meta_tags_fields');

/**
 * Add additional metadata to API for headless rendering
 *
 * @return void
 */
function cagov_gb_register_meta_tags_fields()
{
    register_rest_field(
        'post',
        'headless_tags',
        array(
            'get_callback'    => 'cagov_meta_tags',
            'update_callback' => null,
            'schema'          => null, // @TODO look up what our options are here
        )
    );

    register_rest_field(
        'page',
        'headless_tags',
        array(
            'get_callback'    => 'cagov_meta_tags',
            'update_callback' => null,
            'schema'          => null, // @TODO look up what our options are here
        )
    );
}

function cagov_meta_tags($object, $field_name, $request)
{
    try {
        // print_r($object['id']);
        $tags = get_the_tags($object['id']);
        if (false !== $tags) {
            $tags_response = array();
            // Reduce the category data. 
            // Avoid "count" unless absolutely necessary because it creates git change noise.
            if (isset($tags)) {
                foreach ($tags as $tag) {
                    if (isset( $tag )) {
                        unset($tag->count);
                        $tags_response[] = $tag;
                    }
                }
            }
            return $tags_response;
        }
        // return $tags;
    } catch (Exception $e) {
    } finally {
    }
    return array();
}
