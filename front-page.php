<?php
/**
 *
 * <head>
 *
 */
get_template_part( 'partials/head', 'home' );



/**
 *
 * Header
 *
 */
get_template_part( 'partials/header', 'home' );



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
get_template_part( 'partials/footer', 'home' );



/**
 *
 * Foot
 *
 */
get_template_part( 'partials/foot', 'home' );
