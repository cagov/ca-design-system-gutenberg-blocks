<?php

/**
 * Add custom Gutenberg Blocks from the CA Design System
 *
 * @package CADesignSystem
 */

cagov_design_system_events_detail__init();

function cagov_design_system_events_detail__init()
{
    // Add event detail metadata to WP-API
    add_action('rest_api_init', 'cagov_design_system_events_register_custom_rest_fields');
    
    // Adjust excerpt behavior to return intended excerpts
    add_filter('get_the_excerpt', 'cagov_design_system_events_detail_excerpt');
    
    add_filter( 'rest_post_collection_params', 'cagov_design_system_filter_add_rest_orderby_params', 10, 2 );
}

function cagov_design_system_events_register_custom_rest_fields() {
    register_rest_field(
        'post', // @TODO change to event type
        'event',
        array(
            'get_callback'    => 'cagov_design_system_get_custom_fields',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function cagov_design_system_get_custom_fields()
{
    global $post;
    $custom_fields = cagov_design_system_get_event_custom_fields($post);
    return  $custom_fields;
}

function cagov_design_system_get_event_custom_fields($post)
{
    $blocks = parse_blocks($post->post_content);
    try {
        if (isset($blocks[0]['innerBlocks']) && isset($blocks[0]['innerBlocks'][1])) {
            $event_details = $blocks[0]['innerBlocks'][1]['innerBlocks'][0]['attrs'];
            return $event_details;
        }
        
    } catch (Exception $e) {
    } finally {
    }
    return null;
}

function cagov_design_system_events_detail_excerpt($excerpt)
{
    global $post;
    $meta = get_post_meta($post->ID);
    $details = $excerpt;
    // Only run this if a page has event template, 
    // @TODO this can be replaced by event page type
    try {
        if (isset($meta['_wp_page_template']) && 0 < mb_strpos(strval($meta['_wp_page_template'][0]), "event")) {
            $details = cagov_design_system_excerpt_event($post, $meta, $excerpt);
        }
    } catch (Exception $e) {
    } finally {
    }
    return $details;
}

function cagov_design_system_excerpt_event($post, $meta, $excerpt)
{
    $blocks = parse_blocks($post->post_content);
    $event_date_display = "";
    $event_time = "";
    $materials = "";
    $event_excerpt = $excerpt;
    try {
        if (isset($blocks[0]['innerBlocks']) && isset($blocks[0]['innerBlocks'][1])) {
            $event_details = $blocks[0]['innerBlocks'][1]['innerBlocks'][0]['attrs'];

            // @TODO escape && ISO format: "2025-07-21T19:00-05:00"; // @TODO reconstruct from event-detail saved data in post body.
            // Note: there is also startDateTimeUTC available, but the PST display values are precalculated.
            $start_date = isset($event_details['startDate']) ? $event_details['startDate'] : "";
            $end_date = isset($event_details['endDate']) ? $event_details['endDate'] : "";
            $start_time = isset($event_details['startTime']) ? $event_details['startTime'] : "";
            $end_time = isset($event_details['endTime']) ? $event_details['endTime'] : "";
            $event_location = isset($event_details['location']) ? $event_details['location'] : "";
            $localTimezoneLabel = isset($event_details['localTimezoneLabel']) ? $event_details['localTimezoneLabel'] : "";


            // $start_datetime_utc = new DateTime($event_details['startDateTimeUTC']);
            // $start_datetime_pst = $start_datetime_utc->setTimezone(new DateTimeZone('North America/Los Angeles'));
            // $start_date = $start_datetime_pst; // date_format($start_datetime_pst, "Y-m-d"); // H:i:s


            $date_display = $start_date . " - " . $end_date;
            $time_display = $start_time . " - " . $end_time;
            if ($start_date === $end_date) {
                $date_display = $start_date;
            }
            if ($start_time === $end_time) {
                $time_display = $start_time;
            }
            $event_date_display = '<div class="event-date">' . $date_display . '</div>';
            $event_time_display = '<div class="event-time">' . $time_display . ' ' . $localTimezoneLabel . '</div>';

            $event_excerpt = '<div class="event-details">' .
                $event_date_display .
                '<br />' .
                $event_time_display .
                '<br />' .
                '<div class="event-location">' .
                $event_location .
                '</div>' .
                '</div>';
        }
    } catch (Exception $e) {
    } finally {
    }
    return $event_excerpt;
}



function cagov_design_system_filter_add_rest_orderby_params ( $params ) {
    if (isset($params) && is_array($params)) {
	$params["orderby"] = array("event.startDateTimeUTC" => "asc");
    }
	return $params;
}
