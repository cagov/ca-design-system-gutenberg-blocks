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
    $custom_post_link = get_post_meta($post->ID, '_ca_custom_post_link', true);
    $custom_post_date = get_post_meta($post->ID, '_ca_custom_post_date', true);
    $custom_post_location = get_post_meta($post->ID, '_ca_custom_post_location', true);
    $custom_event_date = get_post_meta($post->ID, '_ca_custom_event_date', true);
    $custom_event_end_date = get_post_meta($post->ID, '_ca_custom_event_end_date', true);
    $custom_event_start_time = get_post_meta($post->ID, '_ca_custom_event_start_time', true);
    $custom_event_end_time = get_post_meta($post->ID, '_ca_custom_event_end_time', true);

    if ('' === get_post_meta($post->ID, '_ca_custom_post_link', true)) {
        update_post_meta($post->ID, '_ca_custom_post_link', get_option('_ca_custom_post_link'));
    }

    if ('' === get_post_meta($post->ID, '_ca_custom_post_date', true)) {
        update_post_meta($post->ID, '_ca_custom_post_date', get_option('_ca_custom_post_date'));
    }

    if ('' === get_post_meta($post->ID, '_ca_custom_post_location', true)) {
        update_post_meta($post->ID, '_ca_custom_post_location', get_option('_ca_custom_post_location'));
    }

    if ('' === get_post_meta($post->ID, '_ca_custom_event_date', true)) {
        update_post_meta($post->ID, '_ca_custom_event_date', get_option('_ca_custom_event_date'));
    }

    if ('' === get_post_meta($post->ID, '_ca_custom_event_end_date', true)) {
        update_post_meta($post->ID, '_ca_custom_event_end_date', get_option('_ca_custom_event_end_date'));
    }

    if ('' === get_post_meta($post->ID, '_ca_custom_event_start_time', true)) {
        update_post_meta($post->ID, '_ca_custom_event_start_time', get_option('_ca_custom_event_start_time'));
    }

    if ('' === get_post_meta($post->ID, '_ca_custom_event_end_time', true)) {
        update_post_meta($post->ID, '_ca_custom_event_end_time', get_option('_ca_custom_event_end_time'));
    }

    wp_nonce_field(basename(__FILE__), 'cagov_page_meta_item_identifier_nonce');
?>

    <p>Data for posts can be set here or in block pattern.</p> 


    <label for="ca_custom_post_link">Post redirects to URL</label><br />
    <input type="text" id="ca_custom_post_link" name="ca_custom_post_link" value="<?php print $custom_post_link; ?>" /><br />

    
    <label for="ca_custom_post_date">Date posted</label><br />
    <input type="text" id="ca_custom_post_date" name="ca_custom_post_date" value="<?php print $custom_post_date; ?>" />
    <br />

    <label for="ca_custom_post_location">Post location</label><br />
    <input type="text" id="ca_custom_post_location" name="ca_custom_post_location" value="<?php print $custom_post_location; ?>" /><br />

    <label for="ca_custom_event_date">Event start date</label><br />
    <input type="text" id="ca_custom_event_date" name="ca_custom_event_date" value="<?php print $custom_event_date; ?>" /><br />

    <label for="ca_custom_event_end_date">Event end date</label><br />
    <input type="text" id="ca_custom_event_end_date" name="ca_custom_event_end_date" value="<?php print $custom_event_end_date; ?>" /><br />

    <label for="ca_custom_event_start_time">Event start time</label><br />
    <input type="text" id="ca_custom_event_start_time" name="ca_custom_event_start_time" value="<?php print $custom_event_start_time; ?>" /><br />

    <label for="ca_custom_event_end_time">Event end time</label><br />
    <input type="text" id="ca_custom_event_end_time" name="ca_custom_event_end_time" value="<?php print $custom_event_end_time; ?>" /><br />
    
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


    $ca_custom_event_date = isset($_POST['ca_custom_event_date']) ? sanitize_text_field(wp_unslash($_POST['ca_custom_event_date'])) : '';

    update_post_meta($post->ID, '_ca_custom_event_date', $ca_custom_event_date);

    $ca_custom_event_end_date = isset($_POST['ca_custom_event_end_date']) ? sanitize_text_field(wp_unslash($_POST['ca_custom_event_end_date'])) : '';

    update_post_meta($post->ID, '_ca_custom_event_end_date', $ca_custom_event_end_date);


    $ca_custom_event_start_time = isset($_POST['ca_custom_event_start_time']) ? sanitize_text_field(wp_unslash($_POST['ca_custom_event_start_time'])) : '';

    update_post_meta($post->ID, '_ca_custom_event_start_time', $ca_custom_event_start_time);

    $ca_custom_event_end_time = isset($_POST['ca_custom_event_end_time']) ? sanitize_text_field(wp_unslash($_POST['ca_custom_event_end_time'])) : '';

    update_post_meta($post->ID, '_ca_custom_event_end_time', $ca_custom_event_end_time);
}
?>