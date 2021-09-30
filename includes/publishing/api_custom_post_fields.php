<?php 

// function cagov_design_system_get_post_custom_fields($post)
// {
//     global $post;
//     $meta = get_post_meta($post->ID);
//     try {
//         if (isset($meta['_wp_page_template']) && 0 < mb_strpos(strval($meta['_wp_page_template'][0]), "event")) {
//             return cagov_design_system_custom_fields_event($post);
//         }
//     } catch (Exception $e) {
//     } finally {
//     }
//     return null;
// }

// function cagov_get_post_fields($post)
// {
//     $custom_post_link = get_post_meta($post->ID, '_ca_custom_post_link', true);
//     $custom_post_date = get_post_meta($post->ID, '_ca_custom_post_date', true);
//     $custom_post_location = get_post_meta($post->ID, '_ca_custom_post_location', true);
//     $custom_fields = cagov_design_system_get_post_custom_fields($post);
//     return array(
//         'post_link' => $custom_post_link,
//         'post_date' => $custom_post_date,
//         'locale' => get_locale(),
//         'gmt_offset' => get_option('gmt_offset'),
//         'timezone' => get_option('timezone_string'),
//         'post_published_date_display' => array(
//             'i18n_locale_date' => date_i18n('F j, Y',  strtotime($post->post_date), false),
//             'i18n_locale_date_gmt' => date_i18n('F j, Y', strtotime($post->post_date_gmt), true),
//             'i18n_locale_date_time' => date_i18n('F j, Y g:i a',  strtotime($post->post_date), false),
//             'i18n_locale_date_time_gmt' => date_i18n('F j, Y g:i a', strtotime($post->post_date_gmt), true),
//         ),
//         'post_modified_date_display' => array(
//             'i18n_locale_date' => date_i18n('F j, Y',  strtotime($post->post_modified), false),
//             'i18n_locale_date_gmt' => date_i18n('F j, Y', strtotime($post->post_modified_gmt), true),
//             'i18n_locale_date_time' => date_i18n('F j, Y g:i a',  strtotime($post->post_modified), false),
//             'i18n_locale_date_time_gmt' => date_i18n('F j, Y g:i a', strtotime($post->post_modified_gmt), true),
//         ),
//         'post_location' => $custom_post_location,
//     );
// }