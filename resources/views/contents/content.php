<article id="post-<?php the_ID() ?>" <?php post_class('entry') ?> role="main">

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
        <h1 class="entry__title"><?php the_title() ?></h1>
    </header>

    <div class="entry__content cf">
        <?php the_content() ?>
    </div>

</article>
