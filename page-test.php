<?php
/**
 *
 * Header
 *
 */
get_header();



/**
 *
 * Content
 *
 */
?>
<div class="content">

    <div class="container">

        <main class="main">

            <?php
            the_post();
            get_template_part( 'views/content', 'test' );
            ?>

        </main><!-- .content -->

        <?php get_template_part( 'views/sidebar', get_post_type() ) ?>

    </div><!-- .container -->

</div><!-- .content -->

<?php
/**
 *
 * Footer
 *
 */
get_footer();
