<?php
/**
 * Single view template
 *
 * RalfHortt\Aurora
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

    <main class="main">

        <?php the_archive_title('<h1 class="archive__title">', '</h1>') ?>

        <div class="posts">
            <?php
            while (have_posts()) {
                the_post();
                get_template_part('resources/views/contents/content-archive', get_post_type());
            }
            ?>
        </div>

        <?php the_posts_pagination(); ?>

    </main>

    <?php get_template_part('resources/views/template-parts/sidebar', get_post_type()) ?>

</div>

<?php
/**
 * Footer
 */
get_template_part('resources/views/footer', get_post_type());
