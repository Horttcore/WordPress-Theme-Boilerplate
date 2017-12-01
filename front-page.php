<?php
/**
 *
 * Header
 *
 */
get_header();



/**
 *
 * Content
 *
 */
?>

<div class="content">

    <div class="container">

        <main class="main" role="main" id="main">

            <?php
            the_post();
            get_template_part( 'views/content', 'home' );
            ?>

        </main><!-- .content -->

    </div><!-- .container -->

</div><!-- .content-container -->



<?php
/**
 *
 * Footer
 *
 */
get_footer();
