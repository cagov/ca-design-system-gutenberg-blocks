<?php

/**
 * Plugin Name: CA Design System Standard Page Pattern
 * Plugin URI: TBD
 * Description: TBD
 * Version: 1.1.0
 * Author: California Office of Digital Innovation
 * @package ca-design-system
 */

defined( 'ABSPATH' ) || exit;


/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function ca_design_system_custom_wp_block_pattern_standard_page() {

	if ( ! function_exists( 'register_block_pattern' ) ) {
		// Gutenberg is not active.
		return;
	}

    /**
     * Register Block Pattern
     */
    register_block_pattern(
        'ca-design-system/standard-page',
        // @TODO Update div & markup
        // @TODO Add css style (enqueue)
        // Add field reference

        // Great reference: https://fullsiteediting.com/lessons/introduction-to-block-patterns/
        array(
            'title'       => __( 'Standard Page', 'ca-design-system' ),
            'description' => __( 'Page layout with dynamic content navigation sidebar', 'Block pattern description', 'ca-design-system' ),
            'content' => '<!-- wp:columns -->
                <div class="wp-block-columns has-2-columns">
                    <!-- wp:column {"width":"33.33%"} -->
                        <div class="wp-block-column" style="flex-basis:33.33%">
                        <!-- wp:ca-design-system/content-navigation -->
                        <div class="wp-block-ca-design-system-content-navigation cagov-content-navigation  cagov-stack">
                        <div>
                            <cagov-content-navigation class="content-navigation" data-selector="#main-content" data-editor="textarea.block-editor-plain-text" data-callback="(content) =&gt; content"></cagov-content-navigation>
                        </div>
                    </div>
                        <!-- /wp:ca-design-system/content-navigation -->
                        </div>
                    <!-- /wp:column --> 
                    <!-- wp:column {"width":"66.66%"} -->
                    <div id="main-content" class="wp-block-column" style="flex-basis:66.66%">
                   
                    </div>
                    <!-- /wp:column -->
            </div><!-- /wp:columns -->',
            "categories" => array('ca-design-system'),
        )
    );

}

add_action( 'init', 'ca_design_system_custom_wp_block_pattern_standard_page' );

function ca_design_system_web_component_scripts() {
    // Global dependencies
    wp_enqueue_script(
        'moment'
    );

    // @TODO sort of in wrong place but actually this is the better place (page scope)
    // Custom web components javascript and css
    wp_enqueue_script(
        'ca-design-system-post-list-web-component',
        plugins_url( '/blocks/announcement-list/web-component.js', dirname( __FILE__ ) ),
        array( ),
    );
    // @TODO this is acting strangely, figure out why.
    // wp_enqueue_style(
    //     'ca-design-system-post-list',
    //     plugins_url( '/blocks/announcement-list/style.css', dirname( __FILE__ ) ),
    //     array( )
    // );

    wp_enqueue_script(
        'ca-design-system-content-navigation-web-component',
        plugins_url( '/blocks/content-navigation/web-component.js', dirname( __FILE__ ) ),
        array( ),
    );
}


add_action('wp_enqueue_scripts', 'ca_design_system_web_component_scripts');

//             'content' => '<div class="ca-gov-columns">
//                 <div class="ca-gov-column">
//                     <cagov-content-navigation></cagov-content-navigation>
//                 </div>

//                 <div class="ca-gov-column">
//                     <div id="main-content">
//                         <!-- wp:html -->
// <h2>Title 1</h2>
// <p>Lorem 1</p>
// <h3>Title 1</h3>
// <p>Lorem 2</p>
//                         <!-- /wp:html -->
//                     </div>
//                 </div>
//             </div>',

            
// <!-- wp:columns --><div class="wp-block-columns has-2-columns">
// 
    
//     <div class="wp-block-column" style="flex-basis:33.33%">
        
            
//             <!-- wp:column {"width":"33.33%"} -->
//             <!-- /wp:column -->
//     </div>
   

//     <!-- wp:column {"width":"66.66%"} -->
//     <div class="wp-block-column" style="flex-basis:66.66%">
//         <div id="main-content">
//             <!-- wp:html -->
//                 <h2>Title 1</h2>
//                 <p>Lorem 1</p>
//                 <h3>Title 1</h3>
//                 <p>Lorem 2</p>
//             <!-- /wp:html -->
//         </div>
//     </div>
//     <!-- /wp:column -->
// </div> <!-- /wp:columns -->