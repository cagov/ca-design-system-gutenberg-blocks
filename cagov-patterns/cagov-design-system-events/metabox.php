<?php

/**
 * Rest API integration for custom fields 
 * Requires post type
 */

// https://wholesomecode.ltd/guides/options-settings-data-wordpress-gutenberg/

/**
 * Page Option Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function cagov_event_detail_page_identifier_metabox_callback($post)
{
    $custom_event_date = get_post_meta($post->ID, '_ca_custom_event_date', true);
    $custom_event_end_date = get_post_meta($post->ID, '_ca_custom_event_end_date', true);
    $custom_event_start_time = get_post_meta($post->ID, '_ca_custom_event_start_time', true);
    $custom_event_end_time = get_post_meta($post->ID, '_ca_custom_event_end_time', true);

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
function cagov_event_detail_save_post($post_id, $post)
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

    $ca_custom_event_date = isset($_POST['ca_custom_event_date']) ? sanitize_text_field(wp_unslash($_POST['ca_custom_event_date'])) : '';

    update_post_meta($post->ID, '_ca_custom_event_date', $ca_custom_event_date);

    $ca_custom_event_end_date = isset($_POST['ca_custom_event_end_date']) ? sanitize_text_field(wp_unslash($_POST['ca_custom_event_end_date'])) : '';

    update_post_meta($post->ID, '_ca_custom_event_end_date', $ca_custom_event_end_date);


    $ca_custom_event_start_time = isset($_POST['ca_custom_event_start_time']) ? sanitize_text_field(wp_unslash($_POST['ca_custom_event_start_time'])) : '';

    update_post_meta($post->ID, '_ca_custom_event_start_time', $ca_custom_event_start_time);

    $ca_custom_event_end_time = isset($_POST['ca_custom_event_end_time']) ? sanitize_text_field(wp_unslash($_POST['ca_custom_event_end_time'])) : '';

    update_post_meta($post->ID, '_ca_custom_event_end_time', $ca_custom_event_end_time);
}

 // Connect to API

 function cagov_event_detail_meta_init() {
	add_action( 'rest_api_init', 'cagov_event_detail_meta_fields', 0);
	add_filter( 'cagov_event_detail_register_fields', 'cagov_event_detail_post_fields' );
   
 }

function cagov_event_detail_meta_fields() {
	$fields_array = apply_filters( 'sgf_register_fields', [] );
	foreach ( $fields_array as $field ) {
		// Ensure post type exists and field name is valid
		if ( ! $field['post_type'] || ! post_type_exists( $field['post_type'] ) || ! $field['meta_key'] || ! is_string( $field['meta_key'] ) ) {
			return;
		}

		// Using Null Coalesce Operator to set defaults
		register_post_meta( $field['post_type'], $field['meta_key'], [
			'type'         => $field['type'] ?? 'string',
			'single'       => $field['single'] ?? true,
			'default'      => $field['default'] ?? '',
			'show_in_rest' => $field['show_in_rest'] ?? true,
			'control'      => $field['control'] ?? 'text'
		] );
	}
}

// Register operator fields
function cagov_event_detail_post_fields( $fields_array ) {
//Simple text field
	$fields_array[] = [
		'meta_key' => 'publisher',
	];

// Number field with default
	$fields_array[] = [
		'meta_key' => 'sales',
		'type'     => 'number',
		'default'  => 100,
	];

// Select with default

	$month_options = array_map( function ( $value ) {
		$label = date( 'F', strtotime( date( 'Y' ) . "-" . str_pad( $value, 2, '0', STR_PAD_LEFT ) . "-01" ) );

		return [ 'value' => $value, 'label' => $label ];
	}, range( 1, 12 ) );

	$fields_array[] = [
		'meta_key' => 'month',
		'default'  => (int) date( 'F' ),
		'control'  => 'select',
		'options'  => $month_options,
		'type'     => 'number',
	];

// Simple repeater
	$fields_array[] = [
		'meta_key'     => 'books',
		'control'      => 'repeater',
		'type'         => 'array',
		'default'      => [ [ 'title' => '' ] ],
		'show_in_rest' => [
			'schema' => [
				'items' => [
					'type'       => 'object',
					'properties' => [
						'title' => [
							'type' => 'string',
						],
					],
				],
			],
		],
	];

// Repeater with multiple fields
	$fields_array[] = [
		'meta_key'     => 'external_reviews',
		'control'      => 'repeater',
		'type'         => 'array',
		'default'      => [],
		'show_in_rest' => [
			'schema' => [
				'items' => [
					'type'       => 'object',
					'properties' => [
						'url'       => [
							'type' => 'string',
						],
						'site_name' => [
							'type' => 'string',
						],
					],
				]
			],
		],
	];

// Color fields in separate panel
	$fields_array[] = [
		'meta_key' => 'footer_override_color',
		'control'  => 'color',
		'panel'    => 'override_styles',
	];
	$fields_array[] = [
		'meta_key' => 'sidebar_override_color',
		'control'  => 'color',
		'panel'    => 'override_styles',
	];

// Image field in separate panel
	$fields_array[] = [
		'meta_key' => 'footer_override_background_image',
		'type'     => 'integer',
		'default'  => 0,
		'control'  => 'media',
		'panel'    => 'override_background_image',
	];

	$fields_array[] = [
		'meta_key' => 'sidebar_override_background_image',
		'type'     => 'integer',
		'default'  => 0,
		'control'  => 'media',
		'panel'    => 'override_background_image',
	];

	$fields_array = array_map( function ( $field ) {
		$field['post_type'] = $field['post_type'] ?? 'post';
		$field['control']   = $field['control'] ?? 'text';
		$field['panel']     = $field['panel'] ?? 'custom-fields';
		$field['label']     = ucfirst( str_replace( '_', ' ', $field['meta_key'] ) );

		return $field;
	}, $fields_array );

	return $fields_array;
}
