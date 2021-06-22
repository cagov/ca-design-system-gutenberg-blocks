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

        add_action('ca_design_system_breadcrumb', array($this, 'ca_design_system_content_breadcrumb_callback'));
        add_action('ca_design_system_content_menu', array($this, 'ca_design_system_content_content_menu_callback'));
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
    public function ca_design_system_gutenberg_blocks_build_scripts()
    {
        wp_enqueue_script(
            'ca-design-system-blocks',
            plugins_url('/build/index.js', dirname(__FILE__)),
            array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-date', 'wp-compose', 'underscore', 'moment', 'wp-data'),
        );

        // Styles broken... needed? (can't tell yet, too many things moving)
        // Add global CSS
        // wp_register_style(
        //     'ca-design-system-global-styles',
        //     CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/style.css',
        //     array(),
        //     filemtime(CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/style.css')
        // );
        // wp_enqueue_style('ca-design-system-global-styles');

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
        } else {
            // Add global admin & editor styles
            // Breaks page silently, no errors
            // wp_register_style(
            //     'ca-design-system-global-styles-editor',
            //     CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/editor.css',
            //     array()
            // );
            // wp_enqueue_style('ca-design-system-global-styles-editor');
        }
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


    public function ca_design_system_content_content_menu_callback($args)
    {
        $nav_links = '';

        /* loop thru and create a link (parent nav item only) */
        // $menuitems = wp_get_nav_menu_items($args->menu->term_id, array('order' => 'DESC'));

        $menuitems = wp_get_nav_menu_items('content-menu');

        foreach ($menuitems as $item) {
            if (!$item->menu_item_parent) {
                $nav_links .= sprintf(
                    '<li%1$stitle="%2$s"%3$s><a href="%4$s"%5$s>%6$s</a></li>',
                    (!empty($item->classes) ? sprintf(' class="%1$s" ', implode(' ', $item->classes)) : ''),
                    $item->attr_title,
                    (!empty($item->xfn) ? sprintf(' rel="%1$s" ', $item->xfn) : ''),
                    $item->url,
                    (!empty($item->target) ? sprintf(' target="%1$s"', $item->target) : ''),
                    $item->title
                );
            }
        }

        $social_links = $this->createContentSocialMenu($args);

        $class = !empty($social_links) ? 'content-footer' : 'content-footer';
        $style = '';

        $per_page_feedback = "<div class=\"per-page-feedback-container\" style=\"background: background: #2F4C2C;
\">PER PAGE FEEDBACK HERE</div>";

        $logo_small = "<div class=\"logo-small\"><a href=\"/\"></a></div>";

        $nav_links = sprintf('<div class="content-footer-container"><div class="%1$s">
            <div class="menu-section">%2$s</div>
            <div class="menu-section"><ul class="content-menu-links" %3$s>%4$s</ul></div>
            <div class="menu-section menu-section-social">%5$s</div>
        </div></div>', $class,  $logo_small, $style, $nav_links, $social_links);

        echo $nav_links;
    }

    
    public function createContentSocialMenu($args)
    {

        // Based on CAWeb createFooterSocialMenu
        $social_share = caweb_get_site_options('social');
        $social_links = '';

        foreach ($social_share as $opt) {
            $share_email = 'ca_social_email' === $opt ? true : false;
            $sub         = rawurlencode(sprintf('%1$s | %2$s', get_the_title(), get_bloginfo('name')));
            $body        = rawurlencode(get_permalink());
            $mailto      = $share_email ? sprintf('mailto:?subject=%1$s&body=%2$s', $sub, $body) : '';
            
            // Removed named menu option
            if (($share_email || '' !== get_option($opt))) {
                $share         = substr($opt, 10);
                $share         = str_replace('_', '-', $share);
                $title         = get_option("${opt}_hover_text", 'Share via ' . ucwords($share));
                $social_url    = $share_email ? $mailto : esc_url(get_option($opt));
                $social_target = sprintf(' target="%1$s"', get_option($opt . '_new_window', true) ? '_blank' : '_self');
                $social_icon   = !empty($share) ? "<span class=\"ca-gov-icon-$share\"></span>" : '';
                $social_links .= sprintf('<li><a href="%1$s" title="%2$s"%3$s>%4$s<span class="sr-only">%5$s</span></a></li>', $social_url, $title, $social_target, $social_icon, $share);
            }
        }

        $social_links = !empty($social_links) ? sprintf('<ul class="social-links-container">%1$s</ul>', $social_links) : '';

        return !empty($social_links) ? sprintf('%1$s', $social_links) : $social_links;
    }


    public function ca_design_system_content_breadcrumb_callback()
    {
        /* Quick breadcrumb function, @TODO Register in plugin to call as a shortcode or function */

        global $post;

        $separator = "<span class=\"crumb separator\">/</span>";
        $linkOff = true;

        // @TODO Iterate through footer menu (or any menus) to locate links.
        // $supported_menus = array('header-menu', 'footer-menu'); 

        $items = wp_get_nav_menu_items('header-menu');

        _wp_menu_item_classes_by_context($items); // Set up the class variables, including current-classes

        // @TODO Move default breadcrumbs to plugin settings

        $crumbs = array(
            "<a class=\"crumb\" href=\"https:\/\/ca.gov\" title=\"CA.GOV\">CA.GOV</a>",
            "<a class=\"crumb\" href=\"/\" title=\"" . get_bloginfo('name') . "\">" . get_bloginfo('name') . "</a>"
        );

        foreach ($items as $item) {
            if ($item->current_item_ancestor) {
                if ($linkOff == true) {
                    $crumbs[] = "<span class=\"crumb\">{$item->title}</span>";
                } else {
                    $crumbs[] = "<a class=\"crumb\" href=\"{$item->url}\" title=\"{$item->title}\">{$item->title}</a>";
                }
            } else if ($item->current) {
                $crumbs[] = "<span class=\"crumb current\">{$item->title}</span>";
            }
        }

        print_r("cat");
        print_r("is cat" . is_category());
        if (is_category()) {
            echo " cat" ;
            global $wp_query;
            $category = get_category(get_query_var('cat'), false);
            $crumbs[] = "<span class=\"crumb current\">{$category->name}</span>";
        }

        // @TODO STILL IN PROGRESS If page is a child of a category that's in the menu system, find the parent in the menu tree & add links to breadcrumbs.
        // Configuration note: requires that a menu item link to a category page.
        if (count($crumbs) == 2 && !is_category()) {
            $category = get_the_category($post->ID);

            // Get category menu item from original menu item
            $category_menu_item_found = false;

            foreach ($items as $category_item) {
                if ($category_item->type_label == "Category") { // or ->type == "taxonomy"
                    if ($category[0]->name == $category_item->title) {
                        $crumbs[] = "<span class=\"crumb current\">" . $category_item->title . "</span>";
                        $category_menu_item_found = true;
                    }
                }
            }

            // If not found, just use the category name
            if ($category[0] && $category_menu_item_found == false) {
                $crumbs[] = "<span class=\"crumb current\">" . $category[0]->name . "</span>";
            }
        }

        echo implode($separator, $crumbs);
    }
}
