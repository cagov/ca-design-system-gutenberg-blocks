<?php
/*
 * Template Name: Page
 * Template Post Type: page
 */
?>

<?php
function get_breadcrumb() {
    echo '<a href="'.home_url().'" rel="nofollow">Home</a>';
    if (is_category() || is_single()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        the_category(' &bull; ');
            if (is_single()) {
                echo " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
                the_title();
            }
    } elseif (is_page()) {
        echo "&nbsp;&nbsp;/&nbsp;&nbsp;Needs&nbsp;Work&nbsp;&nbsp;/&nbsp;&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
}?>

<?php 


require_once get_stylesheet_directory() . '/header.php';
require_once get_stylesheet_directory() . '/partials/header.php';
 ?>

	<div id="page-container" class="with-sidebar page-container-ds">
	
	<div class="breadcrumb"><?php get_breadcrumb(); ?></div>

			<div id="main-content" class="main-content-ds" tabindex="-1">
			
			<div>
			<sidebar space="0" side="left">
		            <cagov-content-navigation data-selector="main" data-type="wordpress" data-label="On this page"></cagov-content-navigation>
				</sidebar></div>
				<div>
				<main class="main-primary">

					<?php
					while ( have_posts() ) :
						the_post();
						?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<?php
						if ( 'on' === get_post_meta( $post->ID, 'ca_custom_post_title_display', true ) ) {
							print esc_html( the_title( '<!-- Page Title--><h1 class="page-title">', '</h1>' ) );
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
