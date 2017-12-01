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

            <h1 class="archive-title"><?php the_archive_title() ?></h1>

            <?php get_template_part( 'views/loop' ) ?>

        </main><!-- .main -->

        <?php get_template_part( 'view/sidebar', get_post_type() ) ?>

    </div><!-- .container -->

</div><!-- .content -->

<?php
/**
 *
 * Footer
 *
 */
get_footer();
