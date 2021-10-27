<?php
/* 
 * This template is used to render categories with the post-list web component.
 * 
 * This keeps the category layout in line with similar pages that use blocks that render content by categories with web componts using the WP API interface, for rendering agnostic-to-WordPress headless performant static pages.
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

<div id="page-container" class="page-container-default">
    <div id="main-content" class="main-content-ds single-column" tabindex="-1">
        <?php
        global $wp_query;
        $category = get_category(get_query_var('cat'), false);
        ?>
        <?php
        do_action("cagov_breadcrumb");
        ?>
        <div class="narrow-page-title">
            <?php echo $category->name; ?>
        </div>
        <div class="ds-content-layout">
            <main class="main-primary">
                <h1 class="page-title"><?php echo $category->name; ?></h1>
                <div class="wp-block-ca-design-system-post-list cagov-post-list cagov-stack">
                    <div>
                        <cagov-post-list class="post-list" data-category="<?php echo $category->slug ?>" data-count="10" data-order="desc" data-endpoint="/wp-json/wp/v2" data-show-excerpt="true" data-show-paginator="true" data-show-published-date="true" data-no-results="No results found">
                        </cagov-post-list>
                    </div>
                </div>

                <span class="return-top hidden-print"></span>
            </main>
        </div>
    </div> <!-- #main-content -->
</div>

<?php
do_action("cagov_content_menu");
?>

<?php get_footer(); ?>
</body>

</html>