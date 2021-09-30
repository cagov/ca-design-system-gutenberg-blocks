<?php


/**
 * Handle custom fields in API
 *
 * @param [type] $object
 * @param [type] $field_name
 * @param [type] $request
 * @return void
 */
function cagov_gutenberg_register_custom_rest_fields() {
    // Starting with block content for API then will do other assets
    register_rest_field(
        'post',
        'design_system_fields',
        array(
            'get_callback'    => 'cagov_gutenberg_get_custom_fields',
            'update_callback' => null,
            'schema'          => null, // @TODO look up what our options are here
        )
    );
    
    register_rest_field(
        'page',
        'design_system_fields',
        array(
            'get_callback'    => 'cagov_gutenberg_get_custom_fields',
            'update_callback' => null,
            'schema'          => null, // @TODO look up what our options are here
        )
    );
}
add_action('init', 'cagov_gutenberg_register_custom_rest_fields');


function cagov_gutenberg_get_custom_fields($object, $field_name, $request)
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
        return array(
            // 'display_title' => true, // $caweb_custom_post_title_display === "on" ? true : false,
            'template' => $current_template,
        );
    } else {
        return array(
            // 'display_title' => true, // $caweb_custom_post_title_display === "on" ? true : false,
            'template' => $current_template,
        );
    }
}
