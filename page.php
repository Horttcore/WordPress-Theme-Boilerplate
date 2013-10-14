<?php
/**
 *
 * Load <head>
 *
 */
get_template_part( 'partials/head', 'page' );



/**
 *
 * Load Header
 *
 */
get_template_part( 'partials/header', 'page' );



/**
 *
 * Loop
 *
 */
the_post();
get_template_part( 'partials/content', 'page' );



/**
 *
 * Load Footer
 *
 */
get_template_part( 'partials/footer', 'page' );
