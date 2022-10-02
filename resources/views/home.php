<?php
/**
 * Blog template
 *
 * RalfHortt\Aurora
 *
 * @version 1.0.0
 */

/**
 * <head>
 */
get_template_part('resources/views/header', 'blog');

/**
 * Content loop
 */
?>
<div class="content">

    <main class="main">
        <h1 class="archive-title"><?php echo single_cat_title() ?></h1>
        <?php get_template_part('resources/views/template-parts/loop', 'blog') ?>
    </main><!-- .main -->

    <?php get_template_part('resources/views/template-parts/sidebar', 'blog') ?>

</div><!-- .content -->


<?php
/**
 * Footer
 */
get_template_part('resources/views/footer', 'blog');
