<?php
/**
 * Blog template
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

            <?php
            the_post();
            get_template_part('resources/views/content/content', 'test');
            ?>

        </main><!-- .content -->

        <?php get_template_part('resources/views/sidebar/sidebar', get_post_type()) ?>

    </div><!-- .container -->

</div><!-- .content -->

<?php
/**
 * Footer
 */
get_template_part('resources/views/footer', get_post_type());
