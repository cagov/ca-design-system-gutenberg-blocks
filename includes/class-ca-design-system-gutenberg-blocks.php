<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class CADesignSystemGutenbergBlocks {

    protected static $_instance = null;

    private $enabled_blocks = [];

    public static function get_instance(){
        if( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct(){
        // Load all block dependencies and files.
        $this->load_block_dependencies();
        $this->load_block_pattern_categories();
        $this->load_block_category();
        $this->ca_design_system_build_scripts();
    }
    

    /**
     * Load all patterns and blocks.
     */
    private function load_block_dependencies(){
        // ROADMAP NOTE: When there are more dependencies and installers would like to control which blocks are enabled, we can alter this function & create an admin page that will let administrators enable and disable blocks.

        // Load patterns, order of loading is order of appearance in patterns list.
        require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/patterns/standard-page/plugin.php';
        require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/patterns/event-post/plugin.php';
        require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/patterns/announcement-post/plugin.php';
        require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/patterns/press-release-post/plugin.php';    

        // Load blocks
        // require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/accordion/plugin.php's;
        // require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/alert/plugin.php';
        // require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/button/plugin.php';
        // require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/breadcrumb/plugin.php';
        require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/card/plugin.php';
        require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/card-grid/plugin.php';
        require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/category-label/plugin.php';
        // require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/content-footer/plugin.php';
        require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/content-navigation/plugin.php';
        require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/event-detail/plugin.php';
        // require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/header-image/plugin.php';
        require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/hero/plugin.php';
        // require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/highlight-box/plugin.php';
        // require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/mailchimp/plugin.php';
        // require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/menu-cards/plugin.php';
        // require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/announcement-list/plugin.php'; // Renamed
        // require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/news-archive/plugin.php';
        // require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/process-step-list/plugin.php'; // Renamed
        // require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/social-media-links/plugin.php';
        // require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/page-alert/plugin.php'; // Renamed
        require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/twitter-feed/plugin.php';
    }

    private function load_component_block_script() {
        add_action('wp_enqueue_scripts', array($this, 'ca_design_system_build_scripts'));
    }


    public function ca_design_system_build_scripts() {
        
    
        // Custom web components javascript and css
        wp_enqueue_script(
            'ca-design-system-blocks',
            plugins_url( '/build/index.js', dirname( __FILE__ ) ),
            array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-date', 'wp-compose', 'underscore', 'moment', 'wp-data' ),
        );
    
        wp_enqueue_script(
            'ca-design-system-blocks',
            plugins_url( '/build/index.js', dirname( __FILE__ ) ),
            array( ),
        );

        // https://stackoverflow.com/questions/54600455/how-to-register-styles-scripts-blocks-for-wordpress-gutenberg-block-editor

        // wp_register_style(
        //     'ca-design-system-blocks',
        //      plugins_url( '/blocks/build/blocks.style.build.css', __FILE__ ),
        //      array( 'wp-blocks' )
        // );

        // wp_register_style(
        //     'ca-design-system-blocks-edit-style',
        //     plugins_url('/blocks/build/blocks.editor.build.css', __FILE__),
        //      array( 'wp-edit-blocks' )
        // );
    }


    /**
     * Register Custom Block Pattern Category.
     */
    private function load_block_pattern_categories(){
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
    function load_block_category(){
        // This doesn't load a normal plugin function (probably syntax recommendation or scoping issue.)
        add_filter( 'block_categories', function( $categories, $post ) {
            return array_merge(
                array(
                    array(
                        'slug'  => 'ca-design-system',
                        'title' => 'CA Design System',
                    ),
                ),
                $categories,
            );
        }, 10, 2);
    }
}
