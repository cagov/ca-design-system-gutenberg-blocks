<?php
/*
 * Template Name: Category Page
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

<div id="page-container" class="page-container-ds">

    <div class="breadcrumb">
        <?php
        do_action("ca_design_system_breadcrumb");
        ?>
    </div>

    <div id="main-content" class="main-content-ds single-column" tabindex="-1">
        <div class="section">
            <main class="main-primary">

                <?php

                global $wp_query;


                $category = get_category(get_query_var('cat'), false);
                ?>


                <h1 class="page-title"><?php echo $category->name; ?></h1>
                <div class="wp-block-ca-design-system-post-list cagov-post-list cagov-stack">
                    <div>
                        <cagov-post-list class="post-list" data-category="<?php $category->name ?>" data-count="10" data-order="desc" data-endpoint="/wp-json/wp/v2" data-show-excerpt="true" data-show-paginator="true">
                        </cagov-post-list>
                    </div>
                </div>


            </main>
        </div> <!-- #main-content -->
    </div>
</div>

<?php get_footer(); ?>
</body>

</html>