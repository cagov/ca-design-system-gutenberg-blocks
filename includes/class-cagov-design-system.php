<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class CAGOVDesignSystem {

    protected static $_instance = null;

    private $enabled_blocks = [];

    public static function get_instance(){
        if( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct(){
        // Load All Block Files
        $this->load_block_dependencies();
        $this->load_web_component_dependencies();
    }

    private function load_block_dependencies(){
        // Note for Design System developers:
        // ROADMAP: Eventually, when there are more dependencies and installers would like to control which blocks are enabled, we can alter this function & create an admin page that will let administrators enable and disable blocks.
        // For now, all of the blocks will load.
        // New blocks should be registered alphabetically.
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/alert/plugin.php';
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/card/plugin.php';
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/card-grid/plugin.php';
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/content-navigation/plugin.php';
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/hero/plugin.php';
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/news-list/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/post-event/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/post-announcement/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/post-press-release/plugin.php';        
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/recent-news/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/twitter-embed/plugin.php';

        // Load patterns
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/patterns/standard-page/plugin.php';

    }

    // Patterns, Blocks & Categories
    // @TODO 
    // - Add Pattern context + categories
    // Update block & pattern categories
    
    private function load_web_component_dependencies(){
        // Global dependencies
        wp_enqueue_script(
            'moment'
        );

        // Custom web components javascript and css
        wp_enqueue_script(
            'california-design-system-news-list-web-component',
            plugins_url( '/blocks/news-list/web-component.js', dirname( __FILE__ ) ),
            array( ),
        );
        // @TODO this is acting strangely, figure out why.
        // wp_enqueue_style(
        //     'california-design-system-news-list',
        //     plugins_url( '/blocks/news-list/style.css', dirname( __FILE__ ) ),
        //     array( )
        // );
    }
}
