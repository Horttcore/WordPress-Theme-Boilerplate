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
<section>

	<h1><?php single_cat_title() ?></h1>

	<div class="posts">

		<?php

		theme_content_nav();

		while ( have_posts() ) : the_post();

			get_template_part( 'partials/content', 'archive' );

		endwhile;

		theme_content_nav();

		?>

	</div><!-- .posts -->

</section>



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