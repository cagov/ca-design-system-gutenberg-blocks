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

	foreach ( glob( CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/templates/*.php' ) as $file ) {
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

