<?php

/**
 * Page/Post Template Overrides for the CAWeb Theme
 *
 * @package CADesignSystem
 */

add_action( 'caweb_pre_main_area', 'ca_design_system_gutenberg_blocks_breadcrumb');
add_action( 'caweb_pre_main_primary', 'ca_design_system_gutenberg_blocks_pre_main_primary' );
add_action( 'caweb_pre_footer', 'ca_design_system_gutenberg_blocks_content_menu' );

/**
 * CADesignSystem Breadcrumb
 *
 * @todo update function to render web component if we build it OR export compiled breadcrumb markup or JSON to WP API
 *
 * @return HTML
 */
function ca_design_system_gutenberg_blocks_breadcrumb() {
    /* Quick breadcrumb function, @TODO Register in plugin to call as a shortcode or function */

    // Dont render breadcrumbs on front page.
    if ( is_front_page() ) {
        return;
    }

    global $post;

    $separator = '<span class="crumb separator">/</span>';
    $link_off  = true;

    // @TODO Iterate through footer menu (or any menus) to locate links.
    // $supported_menus = array('header-menu', 'footer-menu');

    $items = wp_get_nav_menu_items( 'header-menu' );

    _wp_menu_item_classes_by_context( $items ); // Set up the class variables, including current-classes.

    // @TODO Move default breadcrumbs to plugin settings

    $crumbs = array(
        '<a class="crumb" href="https:\/\/ca.gov" title="CA.GOV">CA.GOV</a>',
        '<a class="crumb" href="/" title="' . get_bloginfo( 'name' ) . '">' . get_bloginfo( 'name' ) . '</a>',
    );

    foreach ( $items as $item ) {
        if ( $item->current_item_ancestor ) {
            if ( true === $link_off ) {
                $crumbs[] = "<span class=\"crumb\">{$item->title}</span>";
            } else {
                $crumbs[] = "<a class=\"crumb\" href=\"{$item->url}\" title=\"{$item->title}\">{$item->title}</a>";
            }
        } elseif ( $item->current ) {
            $crumbs[] = "<span class=\"crumb current\">{$item->title}</span>";
        }
    }

    if ( is_category() ) {
        global $wp_query;
        $category = get_category( get_query_var( 'cat' ), false );
        $crumbs[] = "<span class=\"crumb current\">{$category->name}</span>";
    }

    // @TODO STILL IN PROGRESS If page is a child of a category that's in the menu system, find the parent in the menu tree & add links to breadcrumbs.
    // Configuration note: requires that a menu item link to a category page.
    if ( 2 === count( $crumbs ) && ! is_category() ) {
        $category = get_the_category( $post->ID );

        // Get category menu item from original menu item.
        $category_menu_item_found = false;

        foreach ( $items as $category_item ) {
            if ( 'Category' === $category_item->type_label ) { // or ->type == "taxonomy".
                if ( $category[0]->name === $category_item->title ) {
                    $crumbs[]                 = '<span class="crumb current">' . $category_item->title . '</span>';
                    $category_menu_item_found = true;
                }
            }
        }

        // If not found, just use the category name.
        if ( $category[0] && false === $category_menu_item_found ) {
            $crumbs[] = '<span class="crumb current">' . $category[0]->name . '</span>';
        }
    }

    ?>
    <div class="breadcrumb">
        <?php echo implode( $separator, $crumbs ); ?>
    </div>

    <div class="narrow-page-title">
            <?php
            if ('on' === get_post_meta($post->ID, 'ca_custom_post_title_display', true)) {
                esc_html(the_title('<h1 class="page-title">', '</h1>'));
            }
            ?>      
    </div>

<?php
}

/**
 * CADesignSystem Pre Main Primary
 *
 * @category add_action( 'caweb_pre_main_primary', 'ca_design_system_gutenberg_blocks_pre_main_primary');
 * @return HTML
 */
function ca_design_system_gutenberg_blocks_pre_main_primary() {
        global $post;

        $ca_design_system_gutenberg_blocks_content_menu_sidebar = get_post_meta( $post->ID, '_ca_design_system_gutenberg_blocks_content_menu_sidebar', true );

        // Dont render cagov-content-navigation sidebar on front page, post,
        // or if content navigation sidebar not enabled.
        // @TODO This logic needs to be recorded, documented for headless unless we do a simpler method of just doing templates & not adding extra logic that needs to be maintained.

        if ( 'on' !== $ca_design_system_gutenberg_blocks_content_menu_sidebar || is_front_page() || is_single() ) {
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
 * @category add_action( 'caweb_pre_footer', 'ca_design_system_gutenberg_blocks_content_menu' );
 * @return HTML
 */
function ca_design_system_gutenberg_blocks_content_menu() {
    $nav_links = '';

    /* loop thru and create a link (parent nav item only) */
    $nav_menus = get_nav_menu_locations();

    if ( ! isset( $nav_menus['content-menu'] ) ) {
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
                        $menuitems = wp_get_nav_menu_items( $nav_menus['content-menu'] );

                    foreach ( $menuitems as $item ) {
                        if ( ! $item->menu_item_parent ) {
                            $class  = ! empty( $item->classes ) ? implode( ' ', $item->classes ) : '';
                            $rel    = ! empty( $item->xfn ) ? $item->xfn : '';
                            $target = ! empty( $item->target ) ? $item->target : '_blank';
                            ?>
                                <li class="<?php echo esc_attr( $class ); ?>" title="<?php echo esc_attr( $item->attr_title ); ?>" rel="<?php echo esc_attr( $rel ); ?>">
                                    <a href="<?php echo esc_url( $item->url ); ?>" target="<?php echo esc_attr( $target ); ?>"><?php echo esc_attr( $item->title ); ?></a>
                                </li>
                                <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="menu-section menu-section-social">
                <?php
                    ca_design_system_gutenberg_blocks_content_social_menu();
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
function ca_design_system_gutenberg_blocks_content_social_menu() {
    // Based on CAWeb createFooterSocialMenu.
    if ( ! function_exists( 'caweb_get_site_options' ) ) {
        return;
    }

    $social_share = caweb_get_site_options( 'social' );
    $social_links = '';

    ?>
    <ul class="social-links-container">
    <?php
    foreach ( $social_share as $opt ) {
        $share_email = 'ca_social_email' === $opt ? true : false;
        $sub         = rawurlencode( sprintf( '%1$s | %2$s', get_the_title(), get_bloginfo( 'name' ) ) );
        $body        = rawurlencode( get_permalink() );
        $mailto      = $share_email ? sprintf( 'mailto:?subject=%1$s&body=%2$s', $sub, $body ) : '';

        // Removed named menu option.
        if ( ( $share_email || '' !== get_option( $opt ) ) ) {
            $share         = substr( $opt, 10 );
            $share         = str_replace( '_', '-', $share );
            $title         = get_option( "${opt}_hover_text", 'Share via ' . ucwords( $share ) );
            $social_url    = $share_email ? $mailto : esc_url( get_option( $opt ) );
            $social_target = get_option( $opt . '_new_window', true ) ? '_blank' : '_self';
            $social_icon   = ! empty( $share ) ? '' : '';
            ?>
                <li>
                    <a href="<?php echo esc_url( $social_url ); ?>" title="<?php echo esc_attr( $title ); ?>" target="<?php echo esc_attr( $social_target ); ?>">
                        <?php if ( ! empty( $share ) ) : ?>
                            <span class="ca-gov-icon-<?php echo esc_attr( $share ); ?>"></span>
                        <?php endif; ?>
                        <span class="sr-only"><?php echo esc_attr( $share ); ?></span>
                    </a>
                </li>
            <?php
        }
    }

    ?>
    </ul>
    <?php
}
