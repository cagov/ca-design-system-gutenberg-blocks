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
class CADesignSystemGutenbergBlocks_Plugin_Templates_Loader
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
        add_filter('get_the_excerpt', array($this, 'ca_design_system_gutenberg_blocks_excerpt'));
    }

    public function ca_design_system_gutenberg_blocks_excerpt($excerpt)
    {
        global $post;
        $meta = get_post_meta($post->ID);
        $details = $excerpt;
        try {
            // if (str_contains($meta['_wp_page_template'][0], "event")) {
            // @TODO see why str_contains doesn't work here & also fix this absolute pathed template.
            // @TODO For now do the gross thing of linking to abs server paths until have time to researching making template paths not absolute
            if ($meta['_wp_page_template'][0] == "/Users/chachasikes/Work/ca.gov/wordpress/wordpress/wp-content/plugins/ca-design-system-gutenberg-blocks/includes/templates/template-single-event.php" || $meta['_wp_page_template'][0] == "/Users/chachasikes/Work/ca.gov/wordpress/wordpress/wp-content/plugins/ca-design-system-gutenberg-blocks/includes/templates/template-single-event.php") {
                $blocks = parse_blocks($post->post_content);
                $event_date_display = "";
                $event_time = "";
                $materials = "";
                try {
                    $event_details = $blocks[0]['innerBlocks'][1]['innerBlocks'][0]['attrs'];

                    //@TODO escape && ISO format: "2025-07-21T19:00-05:00"; // @TODO reconstruct from event-detail saved data in post body.
    
                    $start_date = $event_details['startDate'];
                    // $end_date = $event_details['endDate'];
                    $start_time = $event_details['startTime'];
                    $end_time = $event_details['endTime'];
                    $event_time_detail = $start_time;
    
                    if ($end_time) {
                        $event_time_detail = $event_time_detail . " – " . $end_time;
                    }

                    $event_date_display = "<div class=\"event-date\">" . $start_date . "</div>";
                    $event_time = "<div class=\"event-time\">" . $event_time_detail . "</div>";
                } catch (Exception $e) {
                } finally {
                }
               


                try {
                    $event_materials = $blocks[0]['innerBlocks'][1]['innerBlocks'][0]['attrs'];
                    // $event_materials_agenda = $event_materials['agenda'];
                    $event_materials_materials = $event_materials['materials'];
                    $materials = "<div class=\"event-materials\">" . $event_materials_materials . "</div>";
                } catch (Exception $e) {
                } finally {
                }

                // ORIGINAL: return $excerpt;

                // @TODO smarter date handling, we can convert to ISO on date entering in GB
                // For now will be text entry

                $details = "<div class=\"event-details\">" . $event_date_display . $event_time . $materials . "</div>";
            }
        } catch (Exception $e) {
        } finally {
        }


        return $details;
    }
}
