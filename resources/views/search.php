<?php
/**
 * Search template
 *
 * @package FBO\Phoenix
 * @version 1.0.0
 */


/**
 *
 * <head>
 *
 */
get_template_part('resources/views/header', 'search');


/**
 *
 * Content loop
 *
 */
?>
<div class="content">

    <div class="container">

        <main class="main">

            <h1 class="archive-title"><?php printf(__('Suchergebnis für: %s'), get_search_query()) ?></h1>

            <?php get_template_part('resources/views/template-parts/loop') ?>

        </main><!-- .main -->

        <?php get_template_part('resources/views/template-parts/sidebar', get_post_type()) ?>

    </div><!-- .container -->

</div><!-- .content -->


<?php
/**
 *
 * Footer
 *
 */
get_template_part('resources/views/footer', 'search');
