<?php
/**
 * Search template
 *
 * RalfHortt\Aurora
 *
 * @version 1.0.0
 */

/**
 * <head>
 */
get_template_part('resources/views/header', 'search');

/**
 * Content loop
 */
?>
<div class="content">

    <main class="main">

        <h1 class="archive-title"><?php printf(__('Suchergebnis für: %s'), get_search_query()) ?></h1>

        <?php get_template_part('resources/views/template-parts/loop-search') ?>

    </main>

    <?php get_template_part('resources/views/template-parts/sidebar', get_post_type()) ?>

</div>


<?php
/**
 * Footer
 */
get_template_part('resources/views/footer', 'search');
