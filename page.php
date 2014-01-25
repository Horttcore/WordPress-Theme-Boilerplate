<?php
/**
 *
 * <head>
 *
 */
get_template_part( 'partials/head', 'page' );



/**
 *
 * Header
 *
 */
get_template_part( 'partials/header', 'page' );



/**
 *
 * Content
 *
 */
the_post();
get_template_part( 'partials/content', 'page' );



/**
 *
 * Footer
 *
 */
get_template_part( 'partials/footer', 'page' );



/**
 *
 * Foot
 *
 */
get_template_part( 'partials/foot', 'page' );
