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

	foreach ( glob( CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__DIR_PATH . '/templates-pantheon/*.php' ) as $file ) {
		// Gets Template Name from the file.
		$filedata = get_file_data(
			$file,
			array(
				'Template Name' => 'Template Name',
				'Template Post Type' => 'Template Post Type',
                'Template Machine Name' => 'Template Machine Name',
			)
		);

		$templates[ $filedata['Template Machine Name'] ] = $filedata['Template Name'];
	}

	return $templates;
}

