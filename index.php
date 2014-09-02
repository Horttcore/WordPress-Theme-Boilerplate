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

	<?php
	theme_pagination();

	while ( have_posts() ) : the_post();

		get_template_part( 'partials/content', 'archive' );

	endwhile;

	theme_pagination();
	?>

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
