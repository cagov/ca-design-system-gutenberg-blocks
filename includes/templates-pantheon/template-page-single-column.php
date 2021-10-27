<?php
/*
 * Template Name: Single Column Page
 * Template Post Type: page
 * Template Machine Name: single-column
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
                esc_html(the_title('<h1 class="page-title">', '</h1>'));
            }
            ?>
        </div>
        <div class="ds-content-layout">
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