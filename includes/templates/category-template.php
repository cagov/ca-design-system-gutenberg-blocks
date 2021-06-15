<?php
/*
 * Template Name: Category Page
 * Template Post Type: page
 */
?>

<?php
// Placeholder breadcrumb function
function get_breadcrumb()
{
    echo '<a href="' . home_url() . '" rel="nofollow">Home</a>';
    if (is_category() || is_single()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        the_category(' &bull; ');
        if (is_single()) {
            echo " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
            the_title();
        }
    } elseif (is_page()) {
        echo "&nbsp;&nbsp;/&nbsp;&nbsp;Needs&nbsp;Work&nbsp;&nbsp;/&nbsp;&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
}

function bread_crumbs_alt()
{
    // $theme_locations = get_nav_menu_locations();

    // if (!isset($theme_locations[$theme_location])) {
    //     return '';
    // }

    $separator = " / ";

    $linkOff = true;

    $items = wp_get_nav_menu_items('header-menu');
    _wp_menu_item_classes_by_context($items); // Set up the class variables, including current-classes
    $crumbs = array(
        "<a href=\"https:\/\/ca.gov\" title=\"CA.GOV\">CA.GOV</a>",
        "<a href=\"/\" title=\"" . get_bloginfo('name') . "\">" . get_bloginfo('name') . "</a>"
    );

    foreach ($items as $item) {
        if ($item->current_item_ancestor) {
            if ($linkOff == true) {
                $crumbs[] = "{$item->title}";
            } else {
                $crumbs[] = "<a href=\"{$item->url}\" title=\"{$item->title}\">{$item->title}</a>";
            }
        } else if ($item->current) {
            $crumbs[] = "<span>{$item->title}</>";
        }
    }
    echo implode($separator, $crumbs);
}

?>

<?php
// Pull header file from theme if it exists.
if (file_exists(get_stylesheet_directory() . '/header.php')) {
    require_once get_stylesheet_directory() . '/header.php';
}
if (file_exists(get_stylesheet_directory() . '/header.php')) {
    require_once get_stylesheet_directory() . '/partials/header.php';
}
?>

<div id="page-container" class="with-sidebar page-container-ds">

    <div class="breadcrumb"><?php bread_crumbs_alt(); ?></div>

    <div id="main-content" class="main-content-ds" tabindex="-1">
        <div class="section">
            <main class="main-primary">

                <?php

                global $wp_query;

                if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                ?>

                        <cagov-post-list ></cagov-post-list>
    
                <?php
                else :
                    get_template_part('includes/no-results', 'index');
                endif;
                ?>
            </main>
        </div> <!-- #main-content -->
    </div>
</div>

<?php get_footer(); ?>
</body>

</html>