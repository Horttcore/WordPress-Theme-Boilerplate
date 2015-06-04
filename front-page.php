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

		<?php
		the_post();
		get_template_part( 'partials/content', 'home' );
		?>

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