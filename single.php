<?php
/**
 *
 * Load <head>
 *
 */
get_template_part( 'partials/head', get_post_type() );



/**
 *
 * Load Header
 *
 */
get_template_part( 'partials/header', get_post_type() );



/**
 *
 * Loop
 *
 */
the_post();
get_template_part( 'partials/content', get_post_type() );



/**
 *
 * Load Footer
 *
 */
get_template_part( 'partials/footer', get_post_type() );