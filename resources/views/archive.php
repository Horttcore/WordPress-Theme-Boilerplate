<?php
/**
 * Single view template
 *
 * @package FBO\Phoenix
 * @version 1.0.0
 */


/**
 * Header
 */
get_template_part('resources/views/header', get_post_type());


/**
 * Content
 */
?>
<div class="content">

    <div class="container">

        <main class="main">

            <?php the_archive_title('<h1 class="archive__title">', '</h1>') ?>

            <div class="posts">

                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('resources/views/template-parts/content-archive', get_post_type());
                endwhile;
                ?>

            </div><!-- .posts -->

            <?php the_posts_pagination(); ?>

        </main><!-- .content -->

        <?php get_template_part('resources/views/template-parts/sidebar', get_post_type()) ?>

    </div><!-- .container -->

</div><!-- .content -->

<?php
/**
 * Footer
 */
get_template_part('resources/views/footer', get_post_type());
