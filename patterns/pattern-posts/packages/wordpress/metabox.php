<?php

/**
 * CADesignSystem Metaboxes
 *
 * @package CADesignSystem
 */

add_action('add_meta_boxes', 'cagov_add_meta_boxes');
add_action('save_post', 'cagov_save_post', 10, 2);

/**
 * Add CADesignSystem Metaboxes
 *
 * @return void
 */
function cagov_add_meta_boxes()
{

    /* Page Meta Box */
    // Disabling until someone requests this feature.
    add_meta_box(
        'cagov_page_meta_box',
        'CA Design System Post Settings',
        'cagov_page_identifier_metabox_callback',
        array('post'),
        'side',
        'high'
    );
    remove_meta_box('generate_layout_options_meta_box', array('post', 'page'), 'side');
}


/**
 * Page Option Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function cagov_page_identifier_metabox_callback($post)
{
    // @NOTE: We may move this around & try to associate this with a press release pattern
    $custom_post_link = get_post_meta($post->ID, '_ca_custom_post_link', true);
    $custom_post_date = get_post_meta($post->ID, '_ca_custom_post_date', true);
    $custom_post_location = get_post_meta($post->ID, '_ca_custom_post_location', true);

    if ('' === get_post_meta($post->ID, '_ca_custom_post_link', true)) {
        update_post_meta($post->ID, '_ca_custom_post_link', get_option('_ca_custom_post_link'));
    }

    if ('' === get_post_meta($post->ID, '_ca_custom_post_date', true)) {
        update_post_meta($post->ID, '_ca_custom_post_date', get_option('_ca_custom_post_date'));
    }

    if ('' === get_post_meta($post->ID, '_ca_custom_post_location', true)) {
        update_post_meta($post->ID, '_ca_custom_post_location', get_option('_ca_custom_post_location'));
    }

    wp_nonce_field(basename(__FILE__), 'cagov_page_meta_item_identifier_nonce');
?>

    <label for="ca_custom_post_link">Post redirects to URL</label><br />
    <input type="text" id="ca_custom_post_link" name="ca_custom_post_link" value="<?php print $custom_post_link; ?>" /><br />

    
    <label for="ca_custom_post_date">Date posted</label><br />
    <input type="date" id="ca_custom_post_date" name="ca_custom_post_date" value="<?php print $custom_post_date; ?>">
    <br />

    <label for="ca_custom_post_location">Post location</label><br />
    <input type="text" id="ca_custom_post_location" name="ca_custom_post_location" value="<?php print $custom_post_location; ?>" /><br />
    
<?php
}

/**
 * Save post meta on the 'save_post' hook.
 * Fires once a post has been saved.
 *
 * @link https://developer.wordpress.org/reference/hooks/save_post/
 *
 * @param  int     $post_id Post ID.
 * @param  WP_POST $post Post object.
 *
 * @return int
 */
function cagov_save_post($post_id, $post)
{

    /* Verify the nonce before proceeding. */
    if (
        !isset($_POST['cagov_page_meta_item_identifier_nonce']) ||
        !wp_verify_nonce(sanitize_key($_POST['cagov_page_meta_item_identifier_nonce']), basename(__FILE__))
    ) {
        return $post_id;
    }

    /* skip auto save */
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    $ca_custom_post_link = isset($_POST['ca_custom_post_link']) ? sanitize_text_field(wp_unslash($_POST['ca_custom_post_link'])) : '';

    update_post_meta($post->ID, '_ca_custom_post_link', $ca_custom_post_link);


    $ca_custom_post_date = isset($_POST['ca_custom_post_date']) ? sanitize_text_field(wp_unslash($_POST['ca_custom_post_date'])) : '';

    update_post_meta($post->ID, '_ca_custom_post_date', $ca_custom_post_date);


    $ca_custom_post_location = isset($_POST['ca_custom_post_location']) ? sanitize_text_field(wp_unslash($_POST['ca_custom_post_location'])) : '';

    update_post_meta($post->ID, '_ca_custom_post_location', $ca_custom_post_location);
}
?>