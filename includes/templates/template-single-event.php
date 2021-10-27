<?php
/*
 * Template Name: Event
 * Template Post Type: post
 * Template Machine Name: event
 */
?>

<?php
function cagov_post_schema($post, $type)
{
    $name = $post->post_title;

    // This is all the schema.org for an event, pulled from component blocks.

    $blocks = parse_blocks($post->post_content);
    $start_date = "";
    $end_date = "";
    
    try {
        $event_details = $blocks[0]['innerBlocks'][1]['innerBlocks'][0]['attrs'];
        // $event_materials = $blocks[0]['innerBlocks'][1]['innerBlocks'][0]['attrs'];
        // @TODO escape && ISO format: "2025-07-21T19:00-05:00"; 
        // @TODO reconstruct from event-detail saved data in post body.
        if (isset($event_details['startDateTimeUTC'])) {
            $start_date = $event_details['startDateTimeUTC'];
        }
        if (isset($event_details['endDateTimeUTC'])) {
            $end_date = $event_details['endDateTimeUTC'];
        }
    } catch (Exception $e) {
        // echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        echo "";
    }

    $description = $post->post_excerpt;

    return <<<EOT
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Event",
        "name": "$name",
        "startDate": "$start_date",
        "endDate": "$end_date",
        "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
        "eventStatus": "https://schema.org/EventScheduled",
        "description" "$description"
    }
    //</script>
    EOT;
}
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
    <div id="main-content" class="main-content-ds single-column single-column-wide" tabindex="-1">
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
                            print '<div class="entry-content">';

                            the_content();

                            // printf('<p class="page-date">Published <time datetime="%1$s">%1$s</time></p>', get_the_date('M d, Y'));
                            print '</div>';
                            ?>
                        </article>

                        <?php 
                        // Include schema.org
                        // echo cagov_post_schema($post, "event") 
                        ?>

                    <?php endwhile; ?>
                    <span class="return-top hidden-print"></span>
            </main>
        </div>
    </div>
</div>
</div>

<?php
do_action("cagov_content_menu");
?>

<?php get_footer(); ?>