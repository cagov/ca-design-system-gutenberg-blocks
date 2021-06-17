<?php
/*
 * Template Name: Page
 * Template Post Type: page
 */
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

<div id="page-container" class="with-sidebar has-sidebar-left page-container-ds">

    <div class="breadcrumb">
        <?php
        // @TODO update function to render web component if we build it OR export compiled breadcrumb markup or JSON to WP API
        do_action("ca_design_system_breadcrumb");
        ?>
    </div>

    <div id="main-content" class="main-content-ds" tabindex="-1">

        <div class="narrow-page-title">
            <?php
            if ('on' === get_post_meta($post->ID, 'ca_custom_post_title_display', true)) {
                esc_html(the_title(sprintf('<h1 class="page-title%1$s">', $caweb_padding), '</h1>'));
            }
            ?>
        </div>


        <div class="sidebar-container sticky-top">
            <sidebar space="0" side="left">
                <cagov-content-navigation data-selector="main" data-type="wordpress" data-label="On this page"></cagov-content-navigation>
            </sidebar>
        </div>

        <div>
            <main class="main-primary">
                <?php
                while (have_posts()) :
                    the_post();
                ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    
                        <?php

                        if ('on' === get_post_meta($post->ID, 'ca_custom_post_title_display', true)) {
                            esc_html(the_title(sprintf('<h1 class="wide-page-title page-title%1$s">', $caweb_padding), '</h1>'));
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