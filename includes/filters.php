<?php
/**
 * CADesignSystem Filters
 *
 * @package CADesignSystem
 */

/* WP Filters */
add_filter( 'get_post_metadata', 'cagov_modify_ca_custom_post_title_display', 100, 3 );
add_filter( 'theme_page_templates', 'cagov_register_page_post_templates', 20 );
add_filter( 'theme_post_templates', 'cagov_register_page_post_templates', 20 );
add_filter( 'template_include', 'cagov_page_template_filter' );
add_filter( 'body_class', 'cagov_body_class', 20 );
add_filter( 'post_class', 'cagov_body_class', 20 );

/* CAWeb Theme Filters */
add_filter( 'caweb_page_title_class', 'cagov_page_title_class');
add_filter( 'caweb_post_title_class', 'cagov_post_title_class');
add_filter( 'caweb_page_container_class', 'cagov_page_container_class');
add_filter( 'caweb_main_content_class', 'cagov_main_content_class');

/**
 * Overrides CAWeb Theme Custom Post Title Display Meta Data
 *
 * @param  mixed $metadata The meta data.
 * @param  mixed $object_id Post ID.
 * @param  mixed $meta_key The meta key being retrieved.
 * @return string
 */
function cagov_modify_ca_custom_post_title_display( $metadata, $object_id, $meta_key ) {
	if ( 'ca_custom_post_title_display' === $meta_key && get_option( 'cagov_force_post_title', true ) ) {
		return 'on';
	}
	return $metadata;
}

/**
 * CADesignSystem Page/Post Templates
 * Adds CADesignSystem page/post templates.
 *
 * @link https://developer.wordpress.org/reference/hooks/theme_page_templates/
 * @param  array $theme_templates Array of page templates. Keys are filenames, values are translated names.
 *
 * @return array
 */
function cagov_register_page_post_templates( $theme_templates ) {
	return array_merge( $theme_templates, cagov_get_page_post_templates() );
}

/**
 * Include plugin's template if there's one chosen for the rendering page.
 *
 * @param  string $template Array of page templates. Keys are filenames, values are translated names.
 * @link https://developer.wordpress.org/reference/hooks/template_include/
 * @return string The path of the template to include.
 */
function cagov_page_template_filter( $template ) {
	global $post;

	$user_selected_template = get_page_template_slug( $post->ID );
	$file_name              = pathinfo( $user_selected_template, PATHINFO_BASENAME );
	$template_dir           = CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . 'templates/';

	if ( file_exists( $template_dir . $file_name ) ) {
		$is_plugin = true;
	}

	if ( '' !== $user_selected_template && $is_plugin ) {
		$template = $user_selected_template;
	}

	if ( is_category() && $is_plugin ) {
		$template = $template_dir . 'category-template.php';
	}

	return $template;
}

/**
 *
 * Filters the list of CSS body class names for the current page/post.
 *
 * @link https://developer.wordpress.org/reference/hooks/body_class/
 * @link https://developer.wordpress.org/reference/hooks/post_class/
 * @param  array $wp_classes An array of body class names.
 *
 * @category {
 * add_filter( 'body_class','caweb_body_class' , 20 );
 * add_filter( 'post_class','caweb_body_class' , 20 );
 * }
 * @return array
 */
function cagov_body_class( $wp_classes ) {
	global $post;

	/* List of the classes that need to be removed */
	$blacklist = array('divi_builder');

	/* List of extra classes that need to be added to the body */
	$whitelist = array('non_divi_builder');

	/* Remove any classes in the blacklist from the wp_classes */
	$wp_classes = array_diff( $wp_classes, $blacklist );

	/* Return filtered wp class */
	return array_merge( $wp_classes, (array) $whitelist );
}

/**
 * Filters the CAWeb Theme Page Title Class
 *
 * @param  string $class Page Title class.
 * @return string
 */
function cagov_page_title_class( $class ){
	return $class . ' wide-page-title';
}

/**
 * Filters the CAWeb Theme Post Title Class
 *
 * @param  string $class Post Title class.
 * @return string
 */
function cagov_post_title_class( $class ){
	$caweb_padding = get_option('ca_default_post_date_display', false ) ? ' pb-0' : '';
	return $class . $caweb_padding;
}

/**
 * Filters the CAWeb Theme Page Container Class
 *
 * @param  string $class Page Container class.
 * @return string
 */
function cagov_page_container_class( $class ){
	global $post;
	$cagov_content_menu_sidebar_class = '';
	
	// if not FrontPage
	if( ! is_front_page() ){
		$cagov_content_menu_sidebar = get_post_meta( $post->ID, '_cagov_content_menu_sidebar', true );

		// if display content menu sidebar
		if( 'on' === $cagov_content_menu_sidebar ){
			$cagov_content_menu_sidebar_class = ' with-sidebar has-sidebar-left';
		}
	}

	return "page-container-ds$cagov_content_menu_sidebar_class" ;
}


/**
 * Filters the CAWeb Theme Main Content Class
 *
 * @param  string $class Main Content class.
 * @return string
 */
function cagov_main_content_class( $class ){
	global $post;
	$main_content = ' single-column';
	
	// if not FrontPage
	if( ! is_front_page() ){
		$cagov_content_menu_sidebar = get_post_meta( $post->ID, '_cagov_content_menu_sidebar', true );

		// if display content menu sidebar is enabled then not single column
		if( 'on' === $cagov_content_menu_sidebar ){
			$main_content = '';
		}
	}

	return "main-content-ds$main_content";
}