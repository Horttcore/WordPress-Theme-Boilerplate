<?php
/**
 *
 * <head>
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

		<main class="content cf" role="main">

			<h1 class="archive-title"><?php the_archive_title() ?></h1>

			<div class="posts">

				<?php

				while ( have_posts() ) : the_post();

					get_template_part( 'partials/content-archive', get_post_type() );

				endwhile;

				the_posts_pagination();

				?>

			</div><!-- .posts -->

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
