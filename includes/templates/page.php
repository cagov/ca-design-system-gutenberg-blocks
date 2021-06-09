<?php
/*
 * Template Name: CA Design System Page Template
 * Template Post Type: page
 */
?>

<?php require_once get_template_directory() . '/header.php'; ?>

	<div id="page-container">
	

			<div id="main-content" class="main-content" tabindex="-1">
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
			</div> <!-- #main-content -->

	</div>
	<?php get_footer(); ?>
