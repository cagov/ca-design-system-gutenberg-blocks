<?php

/**
 * CADesignSystemGutenbergBlocks
 *
 * @package CADesignSystemGutenbergBlocks
 */

if (!defined('ABSPATH')) {
    exit;
}

class CADesignSystemGutenbergBlocks_AdminPage
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

    private function __construct()
    {
        // Load all block dependencies and files.
        $this->load_admin_page();

       
    }

       /**
     * Create menu page for CA Design System
     */
    private function load_admin_page()
    {

        add_action('admin_menu', array($this, 'create_admin_page'));
    }

    /**
     * Render main landing page for CA Design System admin page.
     */
    public function render_admin_page()
    {
        echo "
        <h2>CA Design System</h2>
        <div>
        <p>Welcome to the CA Design System.</p>

        <ul>
            <li><a href=\"#content-guide\">Content Guide</a></li>
            <li><a href=\"#creating-pages\">Creating templated pages</a></li>
            <li><a href=\"#report-bug\">Report a bug</a></li>
        </ul>
        
        </div>
        ";
    }

    public function create_admin_page()
    {
        add_menu_page(
            __('CA Design System', 'ca-design-system'),
            __('CA Design System', 'ca-design-system'),
            'manage_options',
            'ca-design-system',
            array($this, 'render_admin_page'),
            'dashicons-schedule',
            3
        );

        add_submenu_page(
            'ca-design-system',
            __('Fix Page Titles', 'ca-design-system'),
            __('Fix Page Titles', 'ca-design-system'),
            'manage_options',
            'fix-page-titles',
            array($this, 'update_all_pages'),
            'dashicons-schedule',
            2
        );

        add_submenu_page(
            'ca-design-system',
            __('Fix Post Titles', 'ca-design-system'),
            __('Fix Post Titles', 'ca-design-system'),
            'manage_options',
            'fix-post-titles',
            array($this, 'update_all_posts'),
            'dashicons-schedule',
            3
        );
    }

    public function update_all_pages()
    {
        echo "UPDATING ALL PAGE TITLES";
        $args = array(
            'post_type' => 'page',
            'numberposts' => -1
        );
        $all_posts = get_posts($args);
        
        foreach ($all_posts as $single_post) {
            // print_r($single_post);
            echo $single_post->ca_custom_post_title_display;
            update_post_meta($single_post->ID, 'ca_custom_post_title_display', true);
        }
    }

    // public function setAllPageTitles()
    // {

    //     add_action('wp_loaded', 'update_all_pages');
    // }

    public function update_all_posts()
    {
        echo "UPDATING ALL POST TITLES";
        $args = array(
            'post_type' => 'post',
            'numberposts' => -1
        );
        $all_posts = get_posts($args);
        // print_r($all_posts);
        
        foreach ($all_posts as $single_post) {
            // print_r($single_post);
            echo $single_post->ca_custom_post_title_display;
            update_post_meta($single_post->ID, 'ca_custom_post_title_display', true);
        }
    }

    // public function setAllPostTitles()
    // {

    //     add_action('wp_loaded', 'update_all_posts');
    // }
}
