<?php
/**
 *
 * Header
 *
 */
get_header();



/**
 *
 * Content loop
 *
 */
?>

<div class="content-container">

    <div class="container">

        <main class="content cf" role="main" id="main">

            <?php get_template_part( 'views/loop' ) ?>

        </main><!-- .content -->

        <?php get_template_part( 'views/sidebar', get_post_type() ) ?>

    </div><!-- .container -->

</div><!-- .content-container -->



<?php
/**
 *
 * Footer
 *
 */
get_footer();
