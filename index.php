<?php
/**
 *
 * Load <head>
 *
 */
get_template_part( 'partials/head', 'archive' );



/**
 *
 * Load Header
 *
 */
get_template_part( 'partials/header', 'archive' );



/**
 *
 * Loop
 *
 */
theme_content_nav();

while ( have_posts() ) : the_post();

	get_template_part( 'partials/content', 'archive' );

endwhile;

theme_content_nav();



/**
 *
 * Load Footer
 *
 */
get_template_part( 'partials/footer', 'archive' );