<?php
/**
 *
 * <head>
 *
 */
get_template_part( 'partials/head', 'archive' );



/**
 *
 * Header
 *
 */
get_template_part( 'partials/header', 'archive' );



/**
 *
 * Content loop
 *
 */
?>

<div class="content-container">

	<div class="container">

		<section class="content cf">

			<?php

			while ( have_posts() ) : the_post();

				get_template_part( 'partials/content-archive', get_post_type() );

			endwhile;

			the_pagination();

			?>

		</section><!-- .content -->

		<?php get_template_part( 'partials/sidebar', get_post_type() ) ?>

	</div><!-- .container -->

</div><!-- .content-container -->



<?php
/**
 *
 * Footer
 *
 */
get_template_part( 'partials/footer', 'archive' );



/**
 *
 * Foot
 *
 */
get_template_part( 'partials/foot', 'archive' );
