<div class="posts">
    <?php
    while (have_posts()) {
        the_post();
        get_template_part('resources/views/contents/content-search', get_post_type());
    }
    ?>
</div>

<?php the_posts_pagination(); ?>
