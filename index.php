<?php
/**
 *
 * Header
 *
 */
get_header();



/**
 *
 * Content loop
 *
 */
?>

<div class="content-container">

	<div class="container">

		<main class="content cf" role="main" id="main">

			<?php

			while ( have_posts() ) : the_post();

				get_template_part( 'partials/content-archive', get_post_type() );

			endwhile;

			the_posts_pagination();

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
