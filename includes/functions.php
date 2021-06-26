<?php
/**
 * CADesignSystem Helper Functions
 *
 * @package CADesignSystem
 */



/**
 * Return templates located in the plugins templates folder.
 *
 * @return array
 */
function cagov_get_page_post_templates() {
	$templates = array();

	foreach ( glob( CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/templates/*.php' ) as $file ) {
		// Gets Template Name from the file.
		$filedata = get_file_data(
			$file,
			array(
				'Template Name' => 'Template Name',
			)
		);

		$templates[ $file ] = $filedata['Template Name'];
	}

	return $templates;
}



// public function cagov_excerpt($excerpt)
//     {
//         global $post;
//         $meta = get_post_meta($post->ID);
//         $details = $excerpt;
//         try {
//             // if (str_contains($meta['_wp_page_template'][0], "event")) {
//             // if (isset($meta['_wp_page_template'][0]) &&  == $meta['_wp_page_template'][0] === "/Users/chachasikes/Work/ca.gov/wordpress/wordpress/wp-content/plugins/ca-design-system-gutenberg-blocks/includes/templates/template-single-event.php" || isset($meta['_wp_page_template'][0]) === "/Users/chachasikes/Work/ca.gov/wordpress/wordpress/wp-content/plugins/ca-design-system-gutenberg-blocks/includes/templates/template-single-event.php") {
//             //     $blocks = parse_blocks($post->post_content);
//             //     $event_date_display = "";
//             //     $event_time = "";
//             //     $materials = "";
//             //     try {
//             //         $event_details = $blocks[0]['innerBlocks'][1]['innerBlocks'][0]['attrs'];

//             //         //@TODO escape && ISO format: "2025-07-21T19:00-05:00"; // @TODO reconstruct from event-detail saved data in post body.
    
//             //         $start_date = $event_details['startDate'];
//             //         // $end_date = $event_details['endDate'];
//             //         $start_time = $event_details['startTime'];
//             //         $end_time = $event_details['endTime'];
//             //         $event_time_detail = $start_time;
    
//             //         if ($end_time) {
//             //             $event_time_detail = $event_time_detail . " – " . $end_time;
//             //         }

//             //         $event_date_display = "<div class=\"event-date\">" . $start_date . "</div>";
//             //         $event_time = "<div class=\"event-time\">" . $event_time_detail . "</div>";
//             //     } catch (Exception $e) {
//             //     } finally {
//             //     }
               


//             //     try {
//             //         $event_materials = $blocks[0]['innerBlocks'][1]['innerBlocks'][0]['attrs'];
//             //         // $event_materials_agenda = $event_materials['agenda'];
//             //         $event_materials_materials = $event_materials['materials'];
//             //         $materials = "<div class=\"event-materials\">" . $event_materials_materials . "</div>";
//             //     } catch (Exception $e) {
//             //     } finally {
//             //     }

//             //     // ORIGINAL: return $excerpt;

//             //     // @TODO smarter date handling, we can convert to ISO on date entering in GB
//             //     // For now will be text entry

//             //     $details = "<div class=\"event-details\">" . $event_date_display . $event_time . $materials . "</div>";
//             // }
//         } catch (Exception $e) {
//         } finally {
//         }
//         return $details;
//     }


// function _load_default_page_template_styles()
// {
// 	add_action('wp_enqueue_scripts', array($this, 'cagov_default_page_template_styles'), 100);
// }

// public function cagov_default_page_template_styles()
// {
// 	wp_register_style('ca-design-system-gutenberg-blocks-page', plugins_url('styles/page.css', __DIR__), false, '1.0.7.2');
// 	wp_enqueue_style('ca-design-system-gutenberg-blocks-page');
// }

