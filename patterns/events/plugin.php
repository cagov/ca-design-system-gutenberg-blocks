<?php

/**
 * Plugin Name: CA Design System Event Pattern
 * Plugin URI: TBD
 * Description: TBD
 * Version: 1.1.0
 * Author: California Office of Digital Innovation
 * @package ca-design-system
 */

defined('ABSPATH') || exit;

function ca_design_system_custom_wp_block_pattern_event_pattern_set_meta_data () {
    // @TODO change the category if this pattern is selected.
}


add_action('init', 'ca_design_system_custom_wp_block_pattern_event');


/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function ca_design_system_custom_wp_block_pattern_event()
{
    if (!function_exists('register_block_pattern')) {
        // Gutenberg is not active.
        return;
    }

    /**
     * Register Block Pattern
     */
    register_block_pattern(
        'ca-design-system/event-pattern',
        array(
            'title'       => __('Event Pattern', 'ca-design-system'),
            'description' => __('Page layout with dynamic content navigation sidebar', 'Block pattern description', 'ca-design-system'),
            'content' => '<!-- wp:columns -->
            <div class="wp-block-columns has-2-columns">
                
                <!-- wp:column {"width":"66.66%"} -->
                <div id="main-content" class="wp-block-column" style="flex-basis:66.66%">
               
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"width":"33.33%"} -->
                    <div class="wp-block-column" style="flex-basis:33.33%">
                    <!-- wp:ca-design-system/event-detail {
                        "title": "Event Details",
                        "startDate":"",
                        "endDate":"",
                        "startTime":"",
                        "endTime":"",
                        "location:"",
                        "cost": "",
                    } -->
                    <div class="wp-block-ca-design-system-event-detail"><div class="cagov-card-body-content"></div></div>
                    <!-- /wp:ca-design-system/event-detail -->
                    </div>
                <!-- /wp:column --> 
        </div><!-- /wp:columns -->',
            "categories" => array('ca-design-system'),
        )
    );
}

