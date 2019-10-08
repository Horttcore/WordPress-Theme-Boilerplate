<?php
/**
 * 404 template
 *
 * @package FBO\Phoenix
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

    <div class="container">

        <main class="main">

            <?php
            the_post();
            get_template_part('resources/views/content/content', '404');
            ?>

        </main><!-- .content -->

        <?php get_template_part('resources/views/sidebar/sidebar', '404') ?>

    </div><!-- .container -->

</div><!-- .content -->

<?php
/**
 * Footer
 */
get_template_part('resources/views/footer', '404');
