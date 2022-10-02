<?php
/**
 * Header
 *
 * RalfHortt\Aurora
 *
 * @version 1.0.0
 */

/**
 * <head>
 */
get_template_part('resources/views/template-parts/head', get_post_type());

/**
 * Header
 */
get_template_part('resources/views/template-parts/header', get_post_type());

/**
 * Content
 */
?>
<div class="content">

    <main class="main">
        <?php
        while (have_posts()) {
            the_post();
            get_template_part('resources/views/contents/content', get_post_type());
        }
?>
    </main>

    <?php get_template_part('resources/views/template-parts/sidebar', get_post_type()) ?>

</div>

<?php
/**
 * Footer
 */
get_template_part('resources/views/footer', get_post_type());
