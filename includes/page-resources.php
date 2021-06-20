<?php
/**
 * Page/Post Template Overrides for the CAWeb Theme
 *
 * @package CADesignSystem
 */

//add_action( 'caweb_pre_main_area', 'cagov_breadcrumb');
add_action( 'caweb_pre_main_primary', 'cagov_pre_main_primary');
add_action( 'caweb_pre_footer', 'cagov_content_menu' );

/**
 * CADesignSystem Breadcrumb
 *
 * @todo update function to render web component if we build it OR export compiled breadcrumb markup or JSON to WP API
 * 
 * @return HTML
 */
function cagov_breadcrumb(){
    /* Quick breadcrumb function, @TODO Register in plugin to call as a shortcode or function */

    // Dont render breadcrumbs on front page
    if( is_front_page() ){
        return;
    }

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

    if (is_category()) {
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

    
    ?>
    <div class="breadcrumb">
        <?php echo implode($separator, $crumbs); ?>
    </div>
    <?php
}

/**
 * CADesignSystem Pre Main Primary
 *
 * @category add_action( 'caweb_pre_main_primary', 'cagov_pre_main_primary');
 * @return HTML
 */
function cagov_pre_main_primary(){
        global $post;

        $cagov_content_menu_sidebar = get_post_meta( $post->ID, '_cagov_content_menu_sidebar', true );

        // Dont render cagov-content-navigation sidebar on front page, post, 
        // or if content navigation sidebar not enabled
        if( 'on' !== $cagov_content_menu_sidebar || is_front_page() || is_single() ){
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
function cagov_content_menu(){
    $nav_links = '';

    /* loop thru and create a link (parent nav item only) */
    // $menuitems = wp_get_nav_menu_items($args->menu->term_id, array('order' => 'DESC'));
    $nav_menus = get_nav_menu_locations();

    if( ! isset( $nav_menus['content-menu'] ) ){
        return;
    }
    
    $menuitems = wp_get_nav_menu_items($nav_menus['content-menu']);

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

    $social_links = cagov_content_social_menu();

    $class = !empty($social_links) ? 'content-footer' : 'content-footer';
    $style = '';

    $per_page_feedback = "<div class=\"per-page-feedback-container\" style=\"background: background: #2F4C2C;\">PER PAGE FEEDBACK HERE</div>";

    $logo_small = "<div class=\"logo-small\"><a href=\"/\"></a></div>";

    $nav_links = sprintf('<div class="content-footer-container"><div class="%1$s">
        <div class="menu-section">%2$s</div>
        <div class="menu-section"><ul class="content-menu-links" %3$s>%4$s</ul></div>
        <div class="menu-section menu-section-social">%5$s</div>
    </div></div>', $class,  $logo_small, $style, $nav_links, $social_links);

    echo $nav_links;
}

/**
 * CADesignSystem Content Social Menu
 *
 * @return HTML
 */
function cagov_content_social_menu()
{

    // Based on CAWeb createFooterSocialMenu
    if( ! function_exists('caweb_get_site_options') ){
        return;
    }

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

