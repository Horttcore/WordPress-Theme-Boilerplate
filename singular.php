<?php
/**
 *
 * <head>
 *
 */
get_template_part( 'partials/head', get_post_type() );



/**
 *
 * Header
 *
 */
get_template_part( 'partials/header', get_post_type() );



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
get_template_part( 'partials/footer', get_post_type() );



/**
 *
 * Foot
 *
 */
get_template_part( 'partials/foot', get_post_type() );
