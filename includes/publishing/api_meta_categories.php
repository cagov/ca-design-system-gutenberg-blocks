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

    // register_rest_field(
    //     'attachment',
    //     'headless_categories',
    //     array(
    //         'get_callback'    => 'cagov_meta_categories',
    //         'update_callback' => null,
    //         'schema'          => null, // @TODO look up what our options are here
    //     )
    // );
}

function cagov_meta_categories($object, $field_name, $request)
{
    try {
        $categories = get_the_category($object['id']);
        $category_response = array();
        // Reduce the category data. 
        // Avoid "count" unless absolutely necessary because it creates git change noise.
        if (isset($categories)) {
            foreach ($categories as $category) {
                if (isset( $category )) {
                    unset($category->count);
                    unset($category->category_count);
                    $category_response[] = $category;
                }
            }
        }
        return $category_response;
    } catch (Exception $e) {
    } finally {
    }
    return array();
}


            // $category_response[] = array(
            // 'term_id' => $category['term_id'],
        //     name: "Action",
        //     slug: "action",
        //     term_group: 0,
        //     term_taxonomy_id: 2,
        //     taxonomy: "category",
        //     description: "",
        //     parent: 0,
        //     count: 7,
        //     filter: "raw",
        //     cat_ID: 2,
        //     category_count: 7,
        //     category_description: "",
        //     cat_name: "Action",
        //     category_nicename: "action",
        //     category_parent: 0
            // );