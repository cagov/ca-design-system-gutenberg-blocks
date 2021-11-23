<?php

/**
 * Page and post template overrides for CA Design System content
 * @package CADesignSystem
 */


add_action('after_setup_theme', 'cagov_init');
add_action('caweb_pre_main_area', 'cagov_breadcrumb');
add_action('caweb_pre_main_primary', 'cagov_pre_main_primary');
add_action('caweb_pre_footer', 'cagov_content_menu');
add_action('wp_head', 'cagov_footer_scripts');
add_action('cagov_breadcrumb', 'cagov_breadcrumb');
add_action('cagov_content_menu', 'cagov_content_menu');

/**
 * CADesignSystem Init
 * Triggered before any other hook when a user accesses the admin area.
 * Note, this does not just run on user-facing admin screens.
 * It runs on admin-ajax.php and admin-post.php as well.
 *
 * @category add_action( 'init', 'cagov_init' );
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/admin_init
 * @return void
 */
function cagov_init()
{
    /* Include functionality */
    foreach (glob(__DIR__ . '/includes/*.php') as $file) {
        require_once $file;
    }

    /* Add content menu navigation */
    register_nav_menu('content-menu', __('Content Footer Menu'));
    register_nav_menu('social-media-links', __('Social Media Links'));
    register_nav_menu('statewide-footer-menu', __('Statewide Footer Menu'));
}

/**
 * CADesignSystem Breadcrumb
 *
 * @todo update function to render web component if we build it OR export compiled breadcrumb markup or JSON to WP API
 *
 * @return HTML
 */
function cagov_breadcrumb()
{
    /* Quick breadcrumb function */

    global $post;

    $separator = "<span class=\"crumb separator\">/</span>";
    $linkOff = true;

    $items = wp_get_nav_menu_items('header-menu');

    _wp_menu_item_classes_by_context($items); // Set up the class variables, including current-classes

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

    // Configuration note: requires that a menu item link to a category page.
    if (count($crumbs) == 2 && !is_category()) {
        $category = get_the_category($post->ID);

        // Get category menu item from original menu item
        $category_menu_item_found = false;

        foreach ($items as $category_item) {
            if (isset($category_item->type_label) && $category_item->type_label === "Category") { // or ->type == "taxonomy"
                if (isset($category[0]->name) && $category[0]->name == $category_item->title) {
                    $crumbs[] = "<span class=\"crumb current\">" . $category_item->title . "</span>";
                    $category_menu_item_found = true;
                }
            }
        }

        // If not found, just use the category name
        if (isset($category[0]) && $category[0] && $category_menu_item_found == false) {
            $crumbs[] = "<span class=\"crumb current\">" . $category[0]->name . "</span>";
        }
    }

    echo '<div class="breadcrumb" aria-label="Breadcrumb" role="region">' . implode($separator, $crumbs) . '</div>';
}
function cagov_footer_scripts()
{
    /* Register cagov scripts */
    wp_register_script('twitter-timeline', 'https://platform.twitter.com/widgets.js', array(), CAWEB_VERSION, false);

    wp_enqueue_script('twitter-timeline');
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
    <div class="sidebar-container" style="z-index: 1;">
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

?>
    <div class="per-page-feedback-container">
        <cagov-feedback data-endpoint-url="https://fa-go-feedback-001.azurewebsites.net/sendfeedback"></cagov-feedback>
    </div>
    <div class="content-footer-container">
        <div class="content-footer">
            <div class="menu-section">
                <div class="logo-small">
                </div>
            </div>
            <div class="menu-section">
                <ul class="content-menu-links">
                    <?php
                    $nav_links = '';
                    $nav_menus = get_registered_nav_menus();
                    if (isset($nav_menus) && isset($nav_menus['content-menu'])) {
                        // return;
                        $menuitems = wp_get_nav_menu_items('content-menu');
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
                    <a href="<?php echo esc_url($social_url); ?>" title="<?php echo esc_attr($title); ?>" target="<?php echo esc_attr($social_target); ?>" rel="noopener">
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
