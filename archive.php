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

			<h1><?php the_archive_title() ?></h1>

			<div class="posts">

				<?php

				theme_pagination();

				while ( have_posts() ) : the_post();

					get_template_part( 'partials/content-archive', get_post_type() );

				endwhile;

				the_pagination();

				?>

			</div><!-- .posts -->

		</section><!-- .content -->

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
