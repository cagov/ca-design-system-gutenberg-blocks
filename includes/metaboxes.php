<?php
/**
 * CADesignSystem Metaboxes
 *
 * @package CADesignSystem
 */

add_action( 'add_meta_boxes', 'cagov_add_meta_boxes' );
add_action( 'save_post', 'cagov_save_post', 10, 2 );

/**
 * Add CADesignSystem Metaboxes
 *
 * @return void
 */
function cagov_add_meta_boxes() {

    /* Page Meta Box */
    // Disabling until someone requests this feature.
    // add_meta_box(
    //     'cagov_page_meta_box',
    //     'CA Design System Page Settings',
    //     'cagov_page_identifier_metabox_callback',
    //     array( 'page' ),
    //     'side',
    //     'high'
    // );
}

/**
 * Page Option Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function cagov_page_identifier_metabox_callback( $post ) {

    $cagov_content_menu_sidebar = get_post_meta( $post->ID, '_cagov_content_menu_sidebar', true );

    wp_nonce_field( basename( __FILE__ ), 'cagov_page_meta_item_identifier_nonce' );

    ?>

        <label for="cagov_content_menu_sidebar">
        <input type="checkbox" id="cagov_content_menu_sidebar" name="cagov_content_menu_sidebar"<?php print empty( $cagov_content_menu_sidebar ) || 'on' === $cagov_content_menu_sidebar ? ' checked' : ''; ?>>
        Display Content Navigation Sidebar
        </label>

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
function cagov_save_post( $post_id, $post ) {

    /* Verify the nonce before proceeding. */
    if ( ! isset( $_POST['cagov_page_meta_item_identifier_nonce'] ) ||
    ! wp_verify_nonce( sanitize_key( $_POST['cagov_page_meta_item_identifier_nonce'] ), basename( __FILE__ ) ) ) {
        return $post_id;
    }

    /* skip auto save */
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    $cagov_content_menu_sidebar = isset( $_POST['cagov_content_menu_sidebar'] ) ? sanitize_text_field( wp_unslash( $_POST['cagov_content_menu_sidebar'] ) ) : 'off';
    
    update_post_meta( $post->ID, '_cagov_content_menu_sidebar', $cagov_content_menu_sidebar );

}
?>
