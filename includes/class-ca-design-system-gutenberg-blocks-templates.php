<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// https://medium.com/@eudestwt/wordpress-how-to-make-available-page-templates-from-your-plugin-6a6a56846b51
class CADesignSystemGutenbergBlocks_Plugin_Templates_Loader {
  
    protected static $_instance = null;

    public static function get_instance(){
        if( is_null( self::$_instance ) ) {
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
  public function __construct ( ) {
      $this->template_dir = plugin_dir_path(__FILE__) . 'templates/';
      $this->templates = $this->load_plugin_templates();
      add_filter('theme_page_templates', array($this, 'register_plugin_templates_page'));
      add_filter('theme_post_templates', array($this, 'register_plugin_templates_post'));
      add_filter('template_include', array($this, 'add_template_filter' ));
  }

  /**
   * Loading templates from the templates folder inside the plugin
   */
  private function load_plugin_templates ( ) {
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
                  ));

                  $template_name = $filedata['Template Name'];

                  $templates[$full_path] = $template_name;

              }
              closedir($dh);
          }
    }		

    return $templates;
  }

  /**
   * theme_page_templates Filter callback
   *
   * Merges plugins' template with theme's, making them available for the user
   * 
   * @param array $theme_templates
   * @return array $theme_templates
   */
  public function register_plugin_templates_post ( $theme_templates ) {    
    // Merging the WP templates with this plugin's active templates

    // @TODO filter array by type
    $theme_templates = array_merge($theme_templates, $this->templates);
      
    return $theme_templates;
  }

  public function register_plugin_templates_page ( $theme_templates ) {    
    // Merging the WP templates with this plugin's active templates

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
   public function add_template_filter ( $template ) {
      
      $user_selected_template = get_page_template_slug($post->ID);
      $file_name = pathinfo($user_selected_template, PATHINFO_BASENAME);
      $template_dir = $this->template_dir;

      if (file_exists($template_dir . $file_name)) {
          $is_plugin = true;
      }

      if ( $user_selected_template != '' AND $is_plugin ) {
          $template = $user_selected_template;
      }       
  
      return $template;
  }   
  
}