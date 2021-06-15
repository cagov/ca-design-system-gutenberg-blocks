<?php
/*
 * Template Name: Single Column Page
 * Template Post Type: page
 */
?>

<?php
/* Quick breadcrumb function, @TODO Register in plugin to call as a shortcode or function */
function bread_crumbs_alt()
{
    $separator = "<span class=\"crumb separator\">/</span>";
    $linkOff = true;
    $items = wp_get_nav_menu_items('header-menu');
    _wp_menu_item_classes_by_context($items); // Set up the class variables, including current-classes
    // @TODO These could be put in plugin settings.
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
            
        } else if ($item->current ) {
            $crumbs[] = "<span class=\"crumb current\">{$item->title}</>";
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

<div id="page-container" class="page-container-ds">

    <div class="breadcrumb">
        <?php bread_crumbs_alt(); ?>
    </div>

    <div id="main-content" class="main-content-ds single-column" tabindex="-1">
        <div>
            <main class="main-primary">

                <?php
                while (have_posts()) :
                    the_post();
                ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <?php
                        
                        if ('on' === get_post_meta($post->ID, 'ca_custom_post_title_display', true)) {
                            print esc_html(the_title('<!-- Page Title--><h1 class="page-title">', '</h1>'));
                        }

                        print '<div class="entry-content">';

                        the_content();

                        print '</div>';


                        ?>

                    </article> <!-- .et_pb_post -->

                <?php endwhile; ?>
                <span class="return-top hidden-print"></span>

            </main>
        </div>
    </div> <!-- #main-content -->

</div>
<?php get_footer(); ?>