<?php

/**
 * Preview button
 * - pairs with api.php right now
 * - should become separate plugin but keeping here for initial code sketching
 */

 // add_filter( 'preview_post_link', 'cagov_headless_preview' );

function cagov_headless_preview() {
    global $post;
    $post_ID = $post->post_parent;
    $post_slug = get_post_field( 'post_name', $post_ID );
    // This needs to be a variable
    $site_url = get_bloginfo('url');
    $wp_url = get_bloginfo('wpurl');
    // $preview_url = get_blog_info('preview_url'); // @TODO store site meta & retreive it
    
    return $site_url
        . 'preview?slug='
        . $post_slug . '&wpnonce='
        . wp_create_nonce('wp_rest');
}

// New metabox, toggle button or check box to start

// Setting a custom field

// Render an API endpoint with that data

// Revision preview link?

// alternate draft mode

// Internal queue page for WP


