<?php

/**
 * Plugin Name: CA Design System Agenda Pattern
 * Plugin URI: TBD
 * Description: Plain-text meeting agendas and links to PDF files.
 * Version: 1.0.0
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
function ca_design_system_custom_wp_block_pattern_agenda()
{

    if (!function_exists('register_block_pattern')) {
        // Gutenberg is not active.
        return;
    }

    /**
     * Register Block Pattern
     */
    register_block_pattern(
        'ca-design-system/agenda',
        array(
            'title'       => __('Agenda', 'ca-design-system'),
            'description' => __('Agenda layout', 'Block pattern description', 'ca-design-system'),
            'content' => '<!-- wp:columns -->
            <div class="wp-block-columns has-2-columns">
                <!-- wp:column {"width":"66.66%"} -->
                    <div id="main-content" class="wp-block-column" style="flex-basis:66.66%">
                
                    </div>
                <!-- /wp:column -->

                <!-- wp:column {"width":"33.33%"} -->
                    <div class="wp-block-column" style="flex-basis:33.33%">

                    </div>
                <!-- /wp:column --> 
        </div><!-- /wp:columns -->',
            "categories" => array('ca-design-system'),
        )
    );
}

add_action('init', 'ca_design_system_custom_wp_block_pattern_agenda');
