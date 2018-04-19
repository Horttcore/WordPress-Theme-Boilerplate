<?php
/**
 *
 * <head>
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
            get_template_part( 'view/content', '404' );
            ?>

        </main><!-- .main -->

        <?php get_template_part( 'view/sidebar', '404' ) ?>

    </div><!-- .container -->

</div><!-- .content -->

<?php
/**
 *
 * Footer
 *
 */
get_footer();
