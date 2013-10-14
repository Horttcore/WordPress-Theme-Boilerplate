<?php
/**
 *
 * Load <head>
 *
 */
get_template_part( 'partials/head', 'category' );



/**
 *
 * Load Header
 *
 */
get_template_part( 'partials/header', 'category' );



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
get_template_part( 'partials/footer', 'category' );