<?php
/**
 * 404 template
 *
 * RalfHortt\Aurora
 *
 * @version 1.0.0
 */

/**
 * Header
 */
get_template_part('resources/views/header', '404');

/**
 * Content
 */
?>
<div class="content">

    <main class="main">
        <?php get_template_part('resources/views/contents/content', '404') ?>
    </main>

    <?php get_template_part('resources/views/template-parts/sidebar', '404') ?>

</div>

<?php
/**
 * Footer
 */
get_template_part('resources/views/footer', '404');
