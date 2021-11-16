<?php
 
/**
 * Register custom templates for the CA Design System
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
 * Make custom templates available to the UI.
 * https://medium.com/@eudestwt/wordpress-how-to-make-available-page-templates-from-your-plugin-6a6a56846b51
 * 
 */
class CADesignSystemGutenbergBlocks_Plugin_Templates_Loader_Pantheon
{
 
    protected static $_instance = null;

    public static function get_instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    /**
     * Templates folder inside the plugin
     */
    private $templates_dir;

    /**
     * Templates to be merged with WP
     */
    private $templates;

    /**
     * Filtering and loading templates
     */
    public function __construct()
    {
        $this->template_dir = plugin_dir_path(__FILE__) . 'templates-pantheon/';

        add_filter('theme_page_templates', array($this, 'register_plugin_templates_page'));
        add_filter('theme_post_templates', array($this, 'register_plugin_templates_post'));
        add_filter('template_include', array($this, 'add_template_filter'));
    }

    /**
     * Load templates located in the plugin templates folder.
     */
    private function _load_default_page_templates($type)
    {
        $templates = array();
        $template_dir = $this->template_dir;

        // Reads all templates from the folder
        if (is_dir($template_dir)) {

            if ($dh = opendir($template_dir)) {
                while (($file = readdir($dh)) !== false) {

                    $full_path = $template_dir . $file;
                
                    if (filetype($full_path) == 'dir') {
                        continue;
                    }

                    // Gets Template Name from the file
                    $filedata = get_file_data($full_path, array(
                        'Template Name' => 'Template Name',
                        'Template Post Type' => 'Template Post Type',
                        'Template Machine Name' => 'Template Machine Name',
                    ));

                    // Filter templates by post type
                    if ($type === $filedata['Template Post Type']) {
                        $template_name = $filedata['Template Name'];   
                        $templates[$filedata['Template Machine Name']] = $template_name;        
                    }
                }
                closedir($dh);
            }
        }

        return $templates;
    }

    private function _lookup_template_file($machine_name)
    {
        $templates = array();
        $template_dir = $this->template_dir;

        // Reads all templates from the folder
        if (is_dir($template_dir)) {

            if ($dh = opendir($template_dir)) {
                while (($file = readdir($dh)) !== false) {

                    $full_path = $template_dir . $file;
                
                    if (filetype($full_path) == 'dir') {
                        continue;
                    }

                    // Gets Template Name from the file
                    $filedata = get_file_data($full_path, array(
                        'Template Name' => 'Template Name',
                        'Template Post Type' => 'Template Post Type',
                        'Template Machine Name' => 'Template Machine Name',
                    ));

                    // Filter templates by post type
                    if ($machine_name === $filedata['Template Machine Name']) {
                        $templates[$filedata['Template Machine Name']] = $file;        
                    }
                }
                closedir($dh);
            }
        }

        return $templates;
    }

    /**
     * Add Page Templates to Editor interface panels (metaboxes.)
     *
     * @return void
     */
    private function _add_page_templates_to_metaboxes()
    {
        add_filter('add_meta_boxes', array($this, 'cagov_default_page_template'), 1);
    }


    /**
     * Replace default page template
     *
     * @return void
     */
    public function cagov_default_page_template()
    {
        global $post;
        
        if ('page' == $post->post_type && 0 != count(get_page_templates($post)) && get_option('page_for_posts') != $post->ID) {
            $post->page_template = $this->template_dir . "templates-pantheon/template-page.php";
        } else if ('post' == $post->post_type && 0 != count(get_page_templates($post)) && get_option('page_for_posts') != $post->ID) {
            $post->page_template = $this->template_dir . "templates-pantheon/template-single.php";
        }
    }


    /**
     * theme_page_templates Filter callback
     *
     * Merges plugins' template with theme's, making them available for the user
     * 
     * @param array $theme_templates
     * @return array $theme_templates
     */
    public function register_plugin_templates_post($theme_templates)
    {
        // Merging the WP templates with this plugin's active templates

        $this->templates = $this->_load_default_page_templates("post");

        $this->_add_page_templates_to_metaboxes();

        // @TODO filter array by type
        $theme_templates = array_merge($theme_templates, $this->templates);

        return $theme_templates;
    }

    public function register_plugin_templates_page($theme_templates)
    {
        // Merging the WP templates with this plugin's active templates

        $this->templates = $this->_load_default_page_templates("page");

        $this->_add_page_templates_to_metaboxes();
        // @TODO filter array by type
        $theme_templates = array_merge($theme_templates, $this->templates);
        return $theme_templates;
    }

    /**
     * template_include Filter callback
     * 
     * Include plugin's template if there's one chosen for the rendering page 
     *
     * @param string $template path
     * @return string $template path
     */
    public function add_template_filter($template)
    {
        global $post;

        if (isset($post->ID)) {
            
            $user_selected_template = get_page_template_slug($post->ID);

            if(!isset($user_selected_template)) {
                $user_selected_template = $post->post_type;
            }
            
            $templates = $this->_lookup_template_file($user_selected_template);

            if (isset($templates[$user_selected_template])) {
                $file_name = $templates[$user_selected_template];
                $template_dir = $this->template_dir;
                $template_path = $template_dir  . $file_name;
            
                $is_plugin = false;
                if (file_exists($template_path)) {
                    $is_plugin = true;
                }

                if ($user_selected_template != '' and $is_plugin) {
                    $template = $template_path;
                }
            }
        }

        if (is_category()) {
            $template = $this->template_dir . 'plugin/category-template.php';
        }

        return $template;
    }
}
