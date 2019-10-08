<?php
/**
 * Front page template
 *
 * @package FBO\Phoenix
 * @version 1.0.0
 */


/**
 * Header
 */
get_template_part('resources/views/header', 'front-page');


/**
 * Content
 */
?>
<div class="content">

    <div class="container">

        <main class="main">

            <?php
            the_post();
            get_template_part('resources/views/template-parts/content', 'home');
            ?>

        </main><!-- .content -->

        <?php get_template_part('resources/views/template-parts/sidebar', get_post_type()) ?>

    </div><!-- .container -->

</div><!-- .content -->

<?php
/**
 * Footer
 */
get_template_part('resources/views/footer', 'front-page');
