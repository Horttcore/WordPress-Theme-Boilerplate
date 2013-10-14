<?php
/**
 *
 * Load <head>
 *
 */
get_template_part( 'partials/head', 'single' );



/**
 *
 * Load Header
 *
 */
get_template_part( 'partials/header', 'single' );



/**
 *
 * Loop
 *
 */
the_post();
get_template_part( 'partials/content', 'single' );



/**
 *
 * Load Footer
 *
 */
get_template_part( 'partials/footer', 'single' );