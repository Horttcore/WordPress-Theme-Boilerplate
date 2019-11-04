<article id="post-<?php the_ID() ?>" <?php post_class('entry') ?>>

    <header class="entry__header">

        <div class="entry-date"><?php the_date() ?></div>

        <h1 class="entry__title"><?php the_title() ?></h1>

    </header>

    <div class="entry__content cf">

        <?php the_content() ?>

    </div>

</article>
