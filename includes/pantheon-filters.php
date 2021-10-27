<?php

/**
 * CADesignSystem Filters
 *
 * @package CADesignSystem
 */

/* WP Filters */
add_filter('theme_page_templates', 'cagov_register_page_post_templates', 20);

/**
 * CADesignSystem Page/Post Templates
 * Adds CADesignSystem page/post templates.
 *
 * @category add_filter( 'theme_page_templates', 'cagov_register_page_post_templates', 20 );
 * @link https://developer.wordpress.org/reference/hooks/theme_page_templates/
 * @param  array $theme_templates Array of page templates. Keys are filenames, values are translated names.
 *
 * @return array
 */
function cagov_register_page_post_templates($theme_templates)
{
    return array_merge($theme_templates, cagov_get_page_post_templates());
}
