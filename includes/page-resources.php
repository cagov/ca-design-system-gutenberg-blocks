<?php

/**
 * Page/Post Template Overrides for the CAWeb Theme
 *
 * @package CADesignSystem
 */

// add_action( 'caweb_pre_main_area', 'cagov_breadcrumb');
// add_action( 'caweb_pre_main_primary', 'cagov_pre_main_primary' );
// add_action( 'caweb_pre_footer', 'cagov_content_menu' );

add_action('cagov_breadcrumb', 'cagov_breadcrumb');
add_action('cagov_content_menu', 'cagov_content_menu');

/**
 * CADesignSystem Breadcrumb
 *
 * @todo update function to render web component if we build it OR export compiled breadcrumb markup or JSON to WP API
 *
 * @return HTML
 */
function cagov_breadcrumb()
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

    // if (is_category()) {
    //     global $wp_query;
    //     $category = get_category(get_query_var('cat'), false);
    //     $crumbs[] = "<span class=\"crumb current\">{$category->name}</span>";
    // }

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

/**
 * CADesignSystem Pre Main Primary
 *
 * @category add_action( 'caweb_pre_main_primary', 'cagov_pre_main_primary');
 * @return HTML
 */
function cagov_pre_main_primary()
{
    global $post;

    $cagov_content_menu_sidebar = get_post_meta($post->ID, '_cagov_content_menu_sidebar', true);

    // Dont render cagov-content-navigation sidebar on front page, post,
    // or if content navigation sidebar not enabled.
    // @TODO This logic needs to be recorded, documented for headless unless we do a simpler method of just doing templates & not adding extra logic that needs to be maintained.

    if ('on' !== $cagov_content_menu_sidebar || is_front_page() || is_single()) {
        return;
    }
?>
    <div class="sidebar-container sticky-top" style="z-index: 1;">
        <sidebar space="0" side="left">
            <cagov-content-navigation data-selector="main" data-type="wordpress" data-label="On this page"></cagov-content-navigation>
        </sidebar>
    </div>
<?php
}

/**
 * CADesignSystem Content Menu
 *
 * @category add_action( 'caweb_pre_footer', 'cagov_content_menu' );
 * @return HTML
 */
function cagov_content_menu()
{
    $nav_links = '';

    /* loop thru and create a link (parent nav item only) */
    $nav_menus = get_nav_menu_locations();

    if (!isset($nav_menus['content-menu'])) {
        return;
    }

?>
    <div class="content-footer-container">
        <div class="content-footer">
            <div class="menu-section">
                <div class="logo-small">
                    <a href="/"></a>
                </div>
            </div>
            <div class="menu-section">
                <ul class="content-menu-links" %3$s>
                    <?php
                    $menuitems = wp_get_nav_menu_items($nav_menus['content-menu']);

                    foreach ($menuitems as $item) {
                        if (!$item->menu_item_parent) {
                            $class  = !empty($item->classes) ? implode(' ', $item->classes) : '';
                            $rel    = !empty($item->xfn) ? $item->xfn : '';
                            $target = !empty($item->target) ? $item->target : '_blank';
                    ?>
                            <li class="<?php echo esc_attr($class); ?>" title="<?php echo esc_attr($item->attr_title); ?>" rel="<?php echo esc_attr($rel); ?>">
                                <a href="<?php echo esc_url($item->url); ?>" target="<?php echo esc_attr($target); ?>"><?php echo esc_attr($item->title); ?></a>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="menu-section menu-section-social">
                <?php
                cagov_content_social_menu();
                ?>
            </div>
        </div>
    </div>
<?php

    $per_page_feedback = '<div class="per-page-feedback-container" style="background: background: #2F4C2C;">PER PAGE FEEDBACK HERE</div>';
}

/**
 * CADesignSystem Content Social Menu
 *
 * @return HTML
 */
function cagov_content_social_menu()
{
    // Based on CAWeb createFooterSocialMenu.
    if (!function_exists('caweb_get_site_options')) {
        return;
    }

    $social_share = caweb_get_site_options('social');
    $social_links = '';

?>
    <ul class="social-links-container">
        <?php
        foreach ($social_share as $opt) {
            $share_email = 'ca_social_email' === $opt ? true : false;
            $sub         = rawurlencode(sprintf('%1$s | %2$s', get_the_title(), get_bloginfo('name')));
            $body        = rawurlencode(get_permalink());
            $mailto      = $share_email ? sprintf('mailto:?subject=%1$s&body=%2$s', $sub, $body) : '';

            // Removed named menu option.
            if (($share_email || '' !== get_option($opt))) {
                $share         = substr($opt, 10);
                $share         = str_replace('_', '-', $share);
                $title         = get_option("${opt}_hover_text", 'Share via ' . ucwords($share));
                $social_url    = $share_email ? $mailto : esc_url(get_option($opt));
                $social_target = get_option($opt . '_new_window', true) ? '_blank' : '_self';
                $social_icon   = !empty($share) ? '' : '';
        ?>
                <li>
                    <a href="<?php echo esc_url($social_url); ?>" title="<?php echo esc_attr($title); ?>" target="<?php echo esc_attr($social_target); ?>">
                        <?php if (!empty($share)) : ?>
                            <span class="ca-gov-icon-<?php echo esc_attr($share); ?>"></span>
                        <?php endif; ?>
                        <span class="sr-only"><?php echo esc_attr($share); ?></span>
                    </a>
                </li>
        <?php
            }
        }

        ?>
    </ul>
<?php
}

//Adding the Open Graph in the Language Attributes
// function cagov_add_opengraph_doctype( $output ) {
//     return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
// }
// add_filter('language_attributes', 'cagov_add_opengraph_doctype');

function cagov_content_og_tags()
{

    // Current CA Web og tags (None. is a plugin typically recommended to CA Web customers?)
    // Name	Content
    // Author	State of California
    // charset	utf-8
    // Description	State of California
    // generator	CAWeb v.1.5.5
    // generator	WordPress 5.7.2
    // google-site-verification	001779225245372747843:9s-idxui5pk
    // HandheldFriendly	True
    // Keywords	California, government
    // MobileOptimized	320
    // robots	noindex, nofollow
    // viewport	width=device-width, initial-scale=1.0, minimum-scale=1.0

    // theme-color
    // manifest
    // shortcut icon
    // echo '<meta http-equiv="X-UA-Compatible" content="IE=Edge" />';

    // Dependency:
    $caweb_social_options = caweb_get_site_options( 'social' );

    $twitterCreator = false;
    if ( get_option( $caweb_social_options['Twitter'], false ) ) {
        $twitterCreator = get_option( $caweb_social_options['Twitter'], false );
    }
    global $post;
    if (!is_singular()) //if it is not a post or a page
        return;

    // echo '<meta property="fb:app_id" content="Your Facebook App ID" />'; // @TODO Needs to be a setting & we don't have a FB App Id - should be optional

    echo '<meta property="og:title" content="' . get_the_title() . '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
    echo '<meta property="og:site_name" content="' . get_bloginfo('', 'name') . '"/>';

    // echo '<meta property="og:description" content="' . get_bloginfo('', 'description') . '"/>';
    // Or excerpt
    echo '<meta property="og:description" content="' . get_the_excerpt() . '"/>';

    // Q: default cagov twitter account?

    if ($twitterCreator) {
        echo '<meta name="twitter:site" content="' . $twitterCreator . '" />';
        echo '<meta name="twitter:creator" content="' . $twitterCreator . '" />'; 
    }
    echo '<meta name="twitter:url" content="' . get_permalink() . '" />';

    echo '<meta name="twitter:title" content="' . get_bloginfo('', 'name') . '" />';
    echo '<meta name="twitter:description" content="' . get_the_excerpt() . '" />';
    echo '<meta name="twitter:card" content="summary_large_image" />';
    echo '<link rel="canonical" href="' . get_permalink() . '" />';

    // 1200/630

    if (!has_post_thumbnail($post->ID)) {
        // Default image handling for image and twitter cards
        $logo = get_theme_mod('custom_logo');
        $image = wp_get_attachment_image_src($logo, 'full');
        $image_url = $image[0];
        $image_width = $image[1];
        $image_height = $image[2];

        // Use default image
        $default_image = $image_url;
        echo '<meta property="og:image" content="' . $image_url . '"/>';
        echo '<meta property="og:image:width" content="' . $image_width . '"/>';
        echo '<meta property="og:image:height" content="' . $image_height . '"/>';
    } else {
        $image =wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
        $image_url = $image[0];
        $image_width = $image[1];
        $image_height = $image[2];
        echo '<meta property="og:image" content="' . $image_url . '"/>';
        echo '<meta property="og:image:width" content="' . $image_width . '"/>';
        echo '<meta property="og:image:height" content="' . $image_height . '"/>';
    }
}

/**
 * CA Web header has hard coded default site metadata.
 * This function 
 *
 * @return void
 */
function cagov_fix_header_meta() {

    // Future possibility: before header, update the app icon, to be able to test & review with communities.

    // This could be a sitewide setting & accept a high res images that uses an image cropping tool to generate all the variants for new images (if it doesn't already)
    
    // $caweb_apple_icon = CAWEB_URI . '/images/system/apple-touch-icon';

    
    echo '<meta name="author" content="' . get_bloginfo('', 'name') . ' | State of California" />';
    
	echo '<meta name="description" content="' . get_bloginfo('', 'description') . '" />';

    // @TODO Are keywords set anywhere in the theme? If so, append.
	// echo '<meta name="keywords" content="California, government' . $keywords .  '" />';
}

add_action('wp_head', 'cagov_content_og_tags');
// This double renders values og:description is correct for social media. Need to check with Twitter card.
add_action('wp_head', 'cagov_fix_header_meta');
