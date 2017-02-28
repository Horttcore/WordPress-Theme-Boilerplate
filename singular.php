<?php
/**
 *
 * Header
 *
 */
get_header();



/**
 *
 * VISUAL
 *
 */
get_template_part( 'partials/visual', get_post_type() );



/**
 *
 * Content
 *
 */
?>

<div class="content-container">

	<div class="container">

		<main class="content" role="main">

			<?php
			the_post();
			get_template_part( 'partials/content', get_post_type() );
			?>

		</main><!-- .content -->

		<?php get_template_part( 'partials/sidebar', get_post_type() ) ?>

	</div><!-- .container -->

</div><!-- .content-container -->



<?php
/**
 *
 * Footer
 *
 */
get_footer();
