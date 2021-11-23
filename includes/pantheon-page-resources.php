<?php

/**
 * Page and post template overrides for CA Design System content
 * @package CADesignSystem
 */
  
// (Breadcrumb moved to theme)
add_action( 'wp_head', 'cagov_footer_scripts');

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
	register_nav_menu('content-menu', 'Content Footer Menu');
	register_nav_menu('social-media-links', 'Social Media Links');
	register_nav_menu('statewide-footer-menu', 'Statewide Footer Menu');
}

function cagov_footer_scripts() {
	/* Register cagov scripts */
	wp_register_script( 'twitter-timeline', 'https://platform.twitter.com/widgets.js', array(), CAGOV_DESIGN_SYSTEM_HEADLESS_WORDPRESS__VERSION, false );

	wp_enqueue_script( 'twitter-timeline' );
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
