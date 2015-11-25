<?php
/**
 *
 * <head>
 *
 */
get_template_part( 'partials/head', '404' );



/**
 *
 * Header
 *
 */
get_template_part( 'partials/header', '404' );



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
get_template_part( 'partials/footer', '404' );



/**
 *
 * Foot
 *
 */
get_template_part( 'partials/foot', '404' );
