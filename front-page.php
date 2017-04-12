<?php
/**
 *
 * Header
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

		<main class="content" role="main">

			<?php
			the_post();
			get_template_part( 'partials/content', 'home' );
			?>

		</main><!-- .content -->

	</div><!-- .container -->

</div><!-- .content-container -->



<?php
/**
 *
 * Footer
 *
 */
get_footer();
