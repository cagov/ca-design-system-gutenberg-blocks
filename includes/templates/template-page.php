<?php
/*
 * Template Name: DS Default page
 * Template Post Type: page
 * Template Machine Name: page
 */
?>

<?php
// Pull header files from theme if they exists.
$caweb_header = get_stylesheet_directory() .'/header.php';
$caweb_header_partial_163 = get_stylesheet_directory() . '/partials/content/header.php';
$caweb_header_partial_162 = get_stylesheet_directory() . '/partials/header.php';

if (file_exists($caweb_header)) {
    require_once $caweb_header;
}

// CAWeb ^1.6.3a
if (file_exists($caweb_header_partial_163)) {
    require_once $caweb_header_partial_163;
}  

// CAWeb 1.6.2 fallback
elseif (file_exists($caweb_header_partial_162)) {
    require_once $caweb_header_partial_162;
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
                    <cagov-page-navigation data-selector="main" data-type="wordpress" data-label="On this page"></cagov-page-navigation>
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