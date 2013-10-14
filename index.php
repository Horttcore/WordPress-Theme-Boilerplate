<?php
/**
 *
 * Load <head>
 *
 */
get_template_part( 'partials/head', 'blog' );



/**
 *
 * Load Header
 *
 */
get_template_part( 'partials/header', 'blog' );



/**
 *
 * Loop
 *
 */
theme_content_nav();

while ( have_posts() ) : the_post();

	get_template_part( 'partials/content', 'blog' );

endwhile;

theme_content_nav();



/**
 *
 * Load Footer
 *
 */
get_template_part( 'partials/footer', 'blog' );