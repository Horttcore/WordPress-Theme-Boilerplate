<?php
/**
 *
 * <head>
 *
 */
get_header();



/**
 *
 * Content
 *
 */
?>

<div class="content-container">

	<div class="container">

		<main class="content" role="main" id="main">

			<?php
			the_post();
			get_template_part( 'partials/content', '404' );
			?>

		</main><!-- .content -->

		<?php get_template_part( 'partials/sidebar', '404' ) ?>

	</div><!-- .container -->

</div><!-- .content-container -->



<?php
/**
 *
 * Footer
 *
 */
get_footer();
