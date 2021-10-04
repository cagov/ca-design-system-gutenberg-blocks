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
        'og_meta',
        array(
            'get_callback'    => 'cagov_autodescription_meta',
            'update_callback' => null,
            'schema'          => null,
        )
    );

    register_rest_field(
        'page',
        'og_meta',
        array(
            'get_callback'    => 'cagov_autodescription_meta',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function cagov_autodescription_page_meta($post,  $featured_media_url, $tsf, $tsf_post_meta) {
    $title = $post->post_title;
    $description = get_bloginfo('description');
    $social_image_url = "";
    if (is_front_page()) {
        $title = $tsf->get_option( 'homepage_title' );
        $description = "" !== $tsf->get_option( 'homepage_description' ) ? $tsf->get_option( 'homepage_description' ) : $description;
        if (isset($featured_media_url) && false !== $featured_media_url) { 
            $social_image_url = $featured_media_url;
        } else {
            $social_image_url = $tsf->get_option( 'social_image_fb_url' );
        }
    } else {
        $title = $post->post_title;
        $description = isset($post->post_excerpt) && "" !== $post->post_excerpt ? $post->post_excerpt : $description;

        if (isset($featured_media_url) && false !== $featured_media_url) { 
            $social_image_url = $featured_media_url;
        }

        if ("" == $social_image_url) {
            // Page social image settings
            $social_image_url = "" !== $tsf_post_meta['_social_image_url'] ? $tsf_post_meta['_social_image_url'] :$social_image_url;
        }

        // Re use homepage fall back url
        if ("" == $social_image_url) {
            $social_image_url = "" !== $tsf->get_option( 'social_image_fb_url' ) ? $tsf->get_option( 'social_image_fb_url' ) : $social_image_url;
        }

        // $social_image_url = "" !== $tsf_post_meta['_social_image_url'] ? $tsf_post_meta['_social_image_url'] : null;
    }
    // $social_image_id = 1200;
    $social_image_width = 1200;
    $social_image_height = 630;
    $social_image_alt = "";

    return array(
        'page_title' => $title,
        'page_description' => $description,
        'page_social_image_url' => $social_image_url,
        'page_social_image_width' => $social_image_width,
        'page_social_image_height' => $social_image_height,
        'page_social_image_alt' => $social_image_alt,
        // 'page_social_image_id' => $social_image_id,
    );
}

function cagov_autodescription_meta($object, $field_name, $request)
{
    global $post;
    
    // $post_meta = get_post_meta($post->ID);
    try {
        if (function_exists('the_seo_framework')) {
            $tsf = \the_seo_framework();
            $tsf_post_meta =  $tsf->get_post_meta($post->ID);
            // /wp-content/plugins/autodescription/inc/classes/site-options.class.php
            // Data converted to common og meta schema
            // @TODO Get large size of featured media
            // featured_media: 9845
            $featured_media_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            $page_meta = cagov_autodescription_page_meta($post, $featured_media_url, $tsf, $tsf_post_meta);
            return array(
                'editor' => array(
                    'platform' => 'WordPress',
                    'plugin' => 'autodescription',
                    'plugin_name' => 'The SEO Framework',
                    'plugin_version' => '4.1.5.1',
                    'editor_url' => get_bloginfo('wpurl'),
                ),
                'site_name' => get_bloginfo('name'),
                'site_description' => get_bloginfo('description'),
                'site_url' => get_bloginfo('url'),
                'canonical_url' => get_permalink($post->ID),
                'page_title' => $page_meta['page_title'],
                'page_description' => $page_meta['page_description'],
                'page_social_image_url' => $page_meta['page_social_image_url'],
                'page_social_image_width' => $page_meta['page_social_image_width'],
                'page_social_image_height' => $page_meta['page_social_image_height'],
                'page_social_image_alt' => $page_meta['page_social_image_alt'],
                'meta_title' => "" !== $tsf_post_meta['_genesis_title'] ? $tsf_post_meta['_genesis_title'] : $page_meta['page_title'],
                'meta_description' => "" !== $tsf_post_meta['_genesis_description'] ? $tsf_post_meta['_genesis_description'] : $page_meta['page_description'],
                'meta_canonical_url' => "" !== $tsf_post_meta['_genesis_canonical_uri'] ? $tsf_post_meta['_genesis_canonical_uri'] :  get_permalink($post->ID),
                'open_graph_title' => "" !== $tsf_post_meta['_open_graph_title'] ? $tsf_post_meta['_open_graph_title'] : $page_meta['page_title'],
                'open_graph_description' => "" !== $tsf_post_meta['_open_graph_description'] ? $tsf_post_meta['_open_graph_description'] : $page_meta['page_description'],
                'twitter_title' => "" !== $tsf_post_meta['_twitter_title'] ? $tsf_post_meta['_twitter_title'] : $page_meta['page_title'],
                'twitter_description' => "" !== $tsf_post_meta['_twitter_description'] ? $tsf_post_meta['_twitter_description'] : $page_meta['page_description'],
            );
        } else {
            $featured_media_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            return array(
                'editor' => array(
                    'platform' => 'WordPress',
                    'plugin' => 'none',
                    'plugin_name' => 'Core WordPress',
                    'plugin_version' => '5.7.*',
                    'editor_url' => get_bloginfo('wpurl'),
                ),
                'site_name' => get_bloginfo('name'),
                'site_description' => get_bloginfo('description'),
                'site_url' => get_bloginfo('url'),
                'canonical_url' => get_permalink($post->ID),
                'page_title' => $post->post_title,
                'page_description' => get_bloginfo('description'),
                'page_social_image_url' => $featured_media_url,
                'page_social_image_width' => "", // @TODO Try to access this
                'page_social_image_height' => "", // @TODO Try to access this
                'page_social_image_alt' => "", // @TODO Try to access this
                'meta_title' => "" !== $post->post_title,
                'meta_description' => get_bloginfo('description'),
                'meta_canonical_url' => $featured_media_url,
                'open_graph_title' => $post->post_title,
                'open_graph_description' => get_bloginfo('description'),
                'twitter_title' => $post->post_title,
                'twitter_description' => get_bloginfo('description'),
            );
        }
    } catch (Exception $e) {
    } finally {
    }
    return array();
}
