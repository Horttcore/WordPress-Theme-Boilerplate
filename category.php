<?php
/**
 *
 * <head>
 *
 */
get_header();



/**
 *
 * Content loop
 *
 */
?>
<div class="content">

    <div class="container">

        <main class="main">

            <h1 class="archive-title"><?php echo single_cat_title() ?></h1>

            <?php get_template_part( 'views/loop' ) ?>

        </main><!-- .main -->

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
