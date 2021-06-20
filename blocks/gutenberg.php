<?php
/**
 * Load Up Gutenberg
 *
 * @package CADesignSystem
 */

cagov_gutenberg_init();

function cagov_gutenberg_init(){
    // Load all block dependencies and files.
    cagov_load_block_dependencies();
    cagov_load_block_pattern_categories();
    cagov_load_block_category();

	add_action( 'wp_enqueue_scripts', 'cagov_gutenberg_blocks_build_scripts' );
}

/**
 * Load all patterns and blocks.
 */
function cagov_load_block_dependencies() {
	// Load patterns, order of loading is order of appearance in patterns list.

	include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/patterns/event-post/plugin.php';

	// CA Design System: Utilities blocks
	// These appear in child patterns, content editors do not need to interact with these.
	// include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/breadcrumb/plugin.php';
	// include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/category-label/plugin.php';
	include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/content-navigation/plugin.php';
	include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/event-detail/plugin.php';
	include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/event-materials/plugin.php';
	include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/post-list/plugin.php';

	// CA Design System blocks
	include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/accordion/plugin.php';
	include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/announcement-list/plugin.php';
	include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/card/plugin.php'; // Planning to rename to: 'call-to-action-button' - Renamed in GB interface labels but not code
	include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/card-grid/plugin.php'; // Planning to rename to: 'call-to-action-grid' - Renamed in GB interface labels but not code
	include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/hero/plugin.php'; // Planning to rename to feature-card - Renamed in GB interface labels but not code
	include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/page-alert/plugin.php'; // Renamed

	// ## Phase 2
	// Blocks
	// include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/process-step-list/plugin.php'; // Renamed
	// include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/highlight-box/plugin.php';

	// Patterns
	// include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/patterns/agenda/plugin.php';

	// Still a little unclear if these would be used:
	// include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/button/plugin.php';
	// include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/menu-cards/plugin.php';
	// include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/header-image/plugin.php';
}

/**
 * Add required WP block scripts to front end pages.
 *
 * NOTE: This is NOT optimized for performance or file loading.
 */
function cagov_gutenberg_blocks_build_scripts() {
	 wp_enqueue_script(
		'ca-design-system-blocks',
		CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'build/index.js',
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-date', 'wp-compose', 'underscore', 'moment', 'wp-data' ),
	);

	// Styles broken... needed? (can't tell yet, too many things moving)
	// Add global CSS
	// wp_register_style(
	// 'ca-design-system-global-styles',
	// CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/style.css',
	// array(),
	// filemtime(CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/style.css')
	// );
	// wp_enqueue_style('ca-design-system-global-styles');

	if ( ! is_admin() ) {
		/* Compiled dynamic blocks. Used for more complex blocks with more UI interaction. Generated using npm run build from src folder, which builds child blocks. */
		wp_enqueue_script(
			'ca-design-system-blocks',
			CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'build/index.js',
			array(),
		);

		/**
		 * Register web-component from Block child plugins.
		 * Plugins creates hooks that lets us load that component as needed.
		 */
		do_action( 'ca_design_system_gutenberg_blocks_register_announcement_list_web_component' );
		do_action( 'ca_design_system_gutenberg_blocks_register_post_list_web_component' );
		do_action( 'ca_design_system_gutenberg_blocks_register_content_navigation_web_component' );
	} else {
		// Add global admin & editor styles
		// Breaks page silently, no errors
		// wp_register_style(
		// 'ca-design-system-global-styles-editor',
		// CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/editor.css',
		// array()
		// );
		// wp_enqueue_style('ca-design-system-global-styles-editor');
	}
}

/**
 * Register Custom Block Pattern Category.
 */
function cagov_load_block_pattern_categories() {
	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category(
			'ca-design-system',
			array( 'label' => esc_html__( 'CA Design System', 'ca-design-system' ) )
		);
	}
}

/**
 * Register Custom Block Category.
 */
function cagov_load_block_category() {
	// This doesn't load a normal plugin function (probably syntax recommendation or scoping issue.)
	add_filter(
		'block_categories',
		function ( $categories, $post ) {
			return array_merge(
				array(
					array(
						'slug'  => 'ca-design-system',
						'title' => 'CA Design System',
					),
				),
				array(
					array(
						'slug'  => 'ca-design-system-utilities',
						'title' => 'CA Design System: Utilities',
					),
				),
				$categories,
			);
		},
		10,
		2
	);
}
