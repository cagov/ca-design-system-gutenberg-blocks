<?php
/*
 * Template Name: DS Default page
 * Template Post Type: page
 * Template Machine Name: page
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

<div id="page-container" class="with-sidebar has-sidebar-left page-container-ds">
    <div id="main-content" class="main-content-ds" tabindex="-1">
        <?php
            do_action("cagov_breadcrumb");
        ?>
        <div class="narrow-page-title">
                <?php
                if ('on' === get_post_meta($post->ID, 'ca_custom_post_title_display', true)) {
                    esc_html(the_title('<h1 class="page-title">', '</h1>'));
                }
                ?>
        </div>
        <div class="ds-content-layout">
            <div class="sidebar-container everylayout" style="z-index: 1;">
                <sidebar space="0" side="left">
                    <cagov-content-navigation data-selector="main" data-type="wordpress" data-label="On this page"></cagov-content-navigation>
                </sidebar>
            </div>

            <div class="everylayout">
                <main class="main-primary">
                    <?php
                    while (have_posts()) :
                        the_post();
                    ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        
                            <?php

                            if ('on' === get_post_meta($post->ID, 'ca_custom_post_title_display', true)) {
                                esc_html(the_title('<h1 class="wide-page-title page-title">', '</h1>'));
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
        </div>
    </div> <!-- #main-content -->

</div>

<?php
    do_action("cagov_content_menu");
?>

<?php get_footer(); ?>