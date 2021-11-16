<?php
// Redirection plugin designed to use its own REST API via AJAX, not really for general consumption. 

// This extension script gets the data at a new endpoint, for WordPress, exporting csv or json only.

// wp-content/plugins/redirection/api/api-export.php
// Redirection_Api_Route

function cagov_design_system_start_rest_redirection()
{    
    $redirection_plugin = WP_PLUGIN_DIR . '/redirection';

    if (is_dir($redirection_plugin)) {
        // plugin directory found!
        require_once $redirection_plugin . '/api/api.php';
        require_once $redirection_plugin . '/redirection-admin.php';

        Redirection_Api::init();
        Redirection_Admin::init();

        if (defined('RED_MAX_PER_PAGE')) {
            if (class_exists('Redirection_Api_Route')) {
                class Redirection_Api_Export_Cagov extends Redirection_Api_Route
                {
                    public function __construct($namespace)
                    {
                        register_rest_route($namespace, '/export-public/1/(?P<format>csv|json)', array(
                            $this->get_route(WP_REST_Server::READABLE, 'route_export', [$this, 'permission_callback_manage']),
                        ), true);
                    }
        
                    public function permission_callback_manage(WP_REST_Request $request)
                    {
                        // return Redirection_Capabilities::has_access( Redirection_Capabilities::CAP_IO_MANAGE );
                        return true; // Visible publicly (anonymous user, no login required)
        
                    }
        
                    public function route_export(WP_REST_Request $request)
                    {
                        $module = "1"; // was $request['module']; // Wordpress (Value not easily accessible because of some upstream method handlers, we know we only want WordPress info here)
                        // $format = "csv";
                        if (in_array($request['format'], ['csv','json'], true)) { 
                            $format = $request['format'];
                        }
                        $export = Red_FileIO::export($module, $format);
                        if ($export === false) {
                            return $this->add_error_details(new WP_Error('redirect_export_invalid_module_cagov', 'Invalid module'), __LINE__);
                        }
                        
                        // Original structure for AJAX handler.
                        // return array(
                        //     'data' => $export['data'],
                        //     'total' => $export['total'],
                        // );
                        if ("json" === $format) {
                            header('Content-type: application/json');
                            return json_decode($export['data']);
                        } else {
                            // Downloadable CSV
                            header('Content-type: text/csv');
                            return $export['data'];
                        }
                        
                    }
                }   
                // $redirection_api = new Redirection_Api();
                $redirection_api = new Redirection_Api_Export_Cagov(REDIRECTION_API_NAMESPACE);         
            }
        }
    }
    remove_action('rest_api_init', 'cagov_design_system_start_rest_redirection');
}
add_action('rest_api_init', 'cagov_design_system_start_rest_redirection', 10, 2);
