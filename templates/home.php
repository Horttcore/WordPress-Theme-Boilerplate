<?php
/**
 * Template Name: Startseite
 */



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
the_post();
get_template_part( 'partials/content', 'home' );



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
