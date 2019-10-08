<div class="posts">

    <?php
    while (have_posts()) :
        the_post();
        get_template_part('resources/views/content/content-archive', get_post_type());
    endwhile;
    ?>

</div><!-- .posts -->

<?php the_posts_pagination(); ?>
