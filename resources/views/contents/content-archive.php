<article id="post-<?php the_ID() ?>" <?php post_class('entry') ?>>

    <?php
    if (has_post_thumbnail()) {
        ?>
        <div class="entry__image">
            <?php the_post_thumbnail() ?>
        </div>
        <?php
    }
?>

    <header class="entry__header">
        <div class="entry__date"><?php the_time(get_option('date_format')) ?></div>
        <h1 class="entry__title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
    </header>

    <div class="entry__content cf">
        <?php the_content() ?>
    </div>

    <footer class="entry__footer">
        <a class="entry__more-link" href="<?php the_permalink() ?>"><?php _e('Mehr erfahren', 'TEXTDOMAIN') ?></a>
    </footer>

</article>
