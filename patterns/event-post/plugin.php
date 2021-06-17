<?php

/**
 * Plugin Name: CA Design System Event Post Pattern
 * Plugin URI: TBD
 * Description: TBD
 * Version: 1.1.0
 * Author: California Office of Digital Innovation
 * @package ca-design-system
 */

defined('ABSPATH') || exit;


/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function ca_design_system_custom_wp_block_pattern_event_post()
{

    if (!function_exists('register_block_pattern')) {
        // Gutenberg is not active.
        return;
    }

    /**
     * Register Block Pattern
     */
    register_block_pattern(
        'ca-design-system/event-post',
        // @TODO Update div & markup
        // @TODO Add css style (enqueue)
        // Add field reference

        // Great reference: https://fullsiteediting.com/lessons/introduction-to-block-patterns/
        array(
            'title'       => __('Event Post', 'ca-design-system'),
            'description' => __('Page layout with dynamic content navigation sidebar', 'Block pattern description', 'ca-design-system'),
            'content' => '<!-- wp:columns -->
            <div class="wp-block-columns has-2-columns">
                
                <!-- wp:column {"width":"66.66%"} -->
                <div id="main-content" class="wp-block-column" style="flex-basis:66.66%">
               
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"width":"33.33%"} -->
                    <div class="wp-block-column" style="flex-basis:33.33%">
                    <!-- wp:ca-design-system/event-detail -->
                    <div class="wp-block-ca-design-system-event-detail cagov-event-detail  cagov-stack">
                    <div>
                    
                    <h3>Event Details</h3>
                    
                    <div class="wp-block-ca-design-system-event-detail cagov-event-detail cagov-stack">
                        <div class="startDate"></div>
                        <div class="startTime"></div>
                        <div class="endTime"></div>
                        <div class="location"></div>
                        <div class="cost"></div>
                    </div>
                        
                    </div>
                </div>
                    <!-- /wp:ca-design-system/event-detail -->
                    </div>
                <!-- /wp:column --> 
        </div><!-- /wp:columns -->',
            "categories" => array('ca-design-system'),
        )
    );
}

add_action('init', 'ca_design_system_custom_wp_block_pattern_event_post');
