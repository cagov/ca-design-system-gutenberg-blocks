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
        $this->load_block_pattern_categories();
    }

    private function load_block_dependencies(){
        // Note for Design System developers:
        // ROADMAP NOTE: When there are more dependencies and installers would like to control which blocks are enabled, we can alter this function & create an admin page that will let administrators enable and disable blocks.

        // Load patterns, order of loading is order of appearance in patterns list.
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/patterns/standard-page/plugin.php';
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/patterns/event-post/plugin.php';
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/patterns/news-post/plugin.php';
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/patterns/recent-news/plugin.php';
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/patterns/press-release-post/plugin.php';    


        // Load blocks
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/accordion/plugin.php';
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/alert/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/button/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/breadcrumb/plugin.php';
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/card/plugin.php';
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/card-grid/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/category-label/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/content-footer/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/content-navigation/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/event-detail/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/header-image/plugin.php';
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/hero/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/highlight-box/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/mailchimp/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/menu-cards/plugin.php';
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/news-list/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/news-archive/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/process-list/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/social-media-links/plugin.php';
        // require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/standard-alert/plugin.php';
        require_once CAGOV_DESIGN_SYSTEM_BLOCKS_DIR_PATH . '/blocks/twitter-feed/plugin.php';
    }

    /**
     * Register Block Pattern Category.
     */
    private function load_block_pattern_categories(){
        if ( function_exists( 'register_block_pattern_category' ) ) {
            register_block_pattern_category(
                'cagov',
                array( 'label' => esc_html__( 'CA Design System', 'cagov' ) )
            );
        }
}
}
