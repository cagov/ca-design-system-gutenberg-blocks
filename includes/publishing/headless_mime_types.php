<?php

// Allow users who can upload files to include SVG, CSV and JSON files.
// This allows us to provide files that can be used in custom data visualizations.
function cagov_gb_enable_headless_asset_upload($upload_mimes)
{
    if (current_user_can('upload_files')) {
        $upload_mimes['svg'] = 'image/svg+xml'; // SVG files must be prefixed with xml tag
        $upload_mimes['csv'] = 'text/csv';
        $upload_mimes['json'] = 'text/plain';
    }

    return $upload_mimes;
}

add_filter('upload_mimes', 'cagov_gb_enable_headless_asset_upload', 10, 1);
