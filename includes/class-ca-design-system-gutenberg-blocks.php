<?php

/**
 * Create Gutenberg blocks for the CA Design system.
 * 
 * @category CADesignSystem
 * @package  CADesignSystem
 * @author   Office of Digital Innovation <info@digital.ca.gov>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/cagov/ca-design-system-gutenberg-blocks#readme
 */

if (!defined('ABSPATH')) {
    /* Exit if accessed directly. */
    exit;
}

/**
 * Initial Set up for Gutenberg Block interfaces
 * 
 * @category CADesignSystem
 * @package  CADesignSystemGutenbergBlocks
 * @author   Office of Digital Innovation <info@digital.ca.gov>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/cagov/ca-design-system-gutenberg-blocks#readme
 */
class CADesignSystemGutenbergBlocks
{

    protected static $_instance = null;

    private $enabled_blocks = [];

    public static function get_instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Load Block files, styles, set up Gutenberg block interface categories, add JavaScript, and configure page templates.
     */
    private function __construct()
    {
        // Load all block dependencies and files.
        $this->_load_block_dependencies();
        $this->ca_design_system_gutenberg_blocks_build_scripts();
        $this->_load_block_pattern_categories();
        $this->_load_block_category();
    }

    /**
     * Load all patterns and blocks.
     */
    private function _load_block_dependencies()
    {
        // Load patterns, order of loading is order of appearance in patterns list.

        include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/patterns/event-post/plugin.php';

        // CA Design System: Utilities blocks
        // These appear in child patterns, content editors do not need to interact with these.
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
        // include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/menu-cards/plugin.php';

        // For alternate approach with pattern construction
        // include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/breadcrumb/plugin.php';
        // include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/category-label/plugin.php';
    }

    /**
     * Add required WP block scripts to front end pages.
     * 
     * NOTE: This is NOT optimized for performance or file loading.
     */
    public function ca_design_system_gutenberg_blocks_build_scripts()
    {
        // ***THIS IS A PERFORMANCE BOTTLENECK***
        wp_enqueue_script(
            'ca-design-system-blocks',
            plugins_url('/build/index.js', dirname(__FILE__)),
            array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-date', 'wp-compose', 'underscore', 'moment', 'wp-data'),
        );

        if (!is_admin()) {
            /* Compiled dynamic blocks. Used for more complex blocks with more UI interaction. Generated using npm run build from src folder, which builds child blocks. */
            wp_enqueue_script(
                'ca-design-system-blocks',
                plugins_url('/build/index.js', dirname(__FILE__)),
                array(),
            );

            /**
             * Register web-component from Block child plugins. 
             * Plugins creates hooks that lets us load that component as needed.
             */
            do_action("ca_design_system_gutenberg_blocks_register_announcement_list_web_component");
            do_action("ca_design_system_gutenberg_blocks_register_post_list_web_component");
            do_action("ca_design_system_gutenberg_blocks_register_content_navigation_web_component");
        }
    }

    function add_type_attribute($tag, $handle, $src) {
        // if not your script, do nothing and return original $tag
        if ( 'your-script-handle' !== $handle ) {
            return $tag;
        }
        // change the script tag by adding type="module" and return it.
        $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
        return $tag;
    }


    /**
     * Register Custom Block Pattern Category.
     */
    private function _load_block_pattern_categories()
    {
        if (function_exists('register_block_pattern_category')) {
            register_block_pattern_category(
                'ca-design-system',
                array('label' => esc_html__('CA Design System', 'ca-design-system'))
            );
        }
    }

    /**
     * Register Custom Block Category.
     */
    function _load_block_category()
    {
        // This doesn't load a normal plugin function (probably syntax recommendation or scoping issue.)
        add_filter(
            'block_categories',
            function ($categories, $post) {
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
}
