<?php
/*
 * Template Name: DS Post: Event
 * Template Post Type: post
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
        $start_date = $event_details['startDate'];
        $end_date = $event_details['endDate'];
    } catch (Exception $e) {
        // echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        echo "";
    }

    $description = $post->post_excerpt;
    // if location is fielded out with different types of data
    // $location = "";
    // $image

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

    // "organizer": "$organizer",
    // "offers": "$offers",
    // "location": "$location",
    // "image": "$image",

    // @TODO write new github issue

    // SCHEMA notes: 
    // https://schema.org/EventAttendanceModeEnumeration: online/offline/mix)

    // Event status

    // Location - address GB?

    // Image (phase 2)

    // Description - event body

    // Cost -> Offers

    // Organizer

    // Performers (is there a speakers type?)

    // <script type="application/ld+json">
    // https://schema.org/Event
    // Google example: https://developers.google.com/search/docs/data-types/event
    // {
    //     "@context": "https://schema.org",
    //     "@type": "Event",
    //     "name": "The Adventures of Kira and Morrison",
    //     "startDate": "2025-07-21T19:00-05:00",
    //     "endDate": "2025-07-21T23:00-05:00",
    //     "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
    //     "eventStatus": "https://schema.org/EventScheduled",
    //     "location": {
    //       "@type": "Place",
    //       "name": "Snickerpark Stadium",
    //       "address": {
    //         "@type": "PostalAddress",
    //         "streetAddress": "100 West Snickerpark Dr",
    //         "addressLocality": "Snickertown",
    //         "postalCode": "19019",
    //         "addressRegion": "PA",
    //         "addressCountry": "US"
    //       }
    //     },
    //     "image": [
    //       "https://example.com/photos/1x1/photo.jpg",
    //       "https://example.com/photos/4x3/photo.jpg",
    //       "https://example.com/photos/16x9/photo.jpg"
    //      ],
    //     "description": "The Adventures of Kira and Morrison is coming to Snickertown in a can't miss performance.",
    //     "offers": {
    //       "@type": "Offer",
    //       "url": "https://www.example.com/event_offer/12345_201803180430",
    //       "price": "30",
    //       "priceCurrency": "USD",
    //       "availability": "https://schema.org/InStock",
    //       "validFrom": "2024-05-21T12:00"
    //     },
    //     "performer": {
    //       "@type": "PerformingGroup",
    //       "name": "Kira and Morrison"
    //     },
    //     "organizer": {
    //       "@type": "Organization",
    //       "name": "Kira and Morrison Music",
    //       "url": "https://kiraandmorrisonmusic.com"
    //     }
    //   }
    // </script>
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
    <div id="main-content" class="main-content-ds single-column" tabindex="-1">
        <?php
        do_action("cagov_breadcrumb");
        ?>
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

                            printf('<p class="page-date">Published <time datetime="%1$s">%1$s</time></p>', get_the_date('M d, Y'));
                            print '</div>';
                            ?>
                        </article>

                        <?php echo cagov_post_schema($post, "event") ?>

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