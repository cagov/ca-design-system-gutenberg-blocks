<?php
/*
 * Template Name: Announcement
 * Template Post Type: post
 * Template Machine Name: post
 */
?>

<?php
// Pull header file from theme if it exists.
if (file_exists(get_stylesheet_directory() . '/header.php')) {
    require_once get_stylesheet_directory() . '/header.php';
}
if (file_exists(get_stylesheet_directory() . '/partials/header.php')) {
    require_once get_stylesheet_directory() . '/partials/header.php';
}
?>

<div id="page-container" class="page-container-ds">
    <div id="main-content" class="main-content-ds single-column" tabindex="-1">
        <?php
            do_action("cagov_breadcrumb");
        ?>
        <div class="narrow-page-title">
                <?php
                if ('on' === get_post_meta($post->ID, 'ca_custom_post_title_display', true)) {
                    $caweb_padding = get_option('ca_default_post_date_display') ? ' pb-0' : '';

                    esc_html(the_title(sprintf('<h1 class="page-title%1$s">', $caweb_padding), '</h1>'));
                }
                ?>
        </div>
        <div class="ds-content-layout">
            <main class="main-primary">
                <div>
                    <?php
                    while (have_posts()) :
                        the_post();
                    ?>

                    <?php
                        $category = get_the_category();
                    ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <category-label><?php echo $category[0]->cat_name; ?></category-label>
                            <!-- Page Title-->
                            <?php
                            if ('on' === get_post_meta($post->ID, 'ca_custom_post_title_display', true)) {
                                $caweb_padding = get_option('ca_default_post_date_display') ? ' pb-0' : '';

                                esc_html(the_title(sprintf('<h1 class="page-title%1$s">', $caweb_padding), '</h1>'));
                            }

                            // if (get_option('ca_default_post_date_display') && !$caweb_is_page_builder_used) {
                                printf('<p class="page-date published"><time datetime="%1$s">%1$s</time></p>', get_the_date('M d, Y'));
                            // }

                            print '<div class="entry-content">';

                            the_content();

                            print '</div>';

                            ?>

                        </article>

                    <?php endwhile; ?>
                    <span class="return-top hidden-print"></span>
            </main>
        </div>
    </div>
</div>


<?php
    do_action("cagov_content_menu");
?>

<?php get_footer(); ?>