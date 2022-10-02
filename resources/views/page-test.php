<?php
/**
 * Blog template
 *
 * RalfHortt\Aurora
 *
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

            <?php
            the_post();
get_template_part('resources/views/contents/content', 'test');
?>

        </main>

        <?php get_template_part('resources/views/template-parts/sidebar', get_post_type()) ?>

    </div>

</div>

<?php
/**
 * Footer
 */
get_template_part('resources/views/footer', get_post_type());
