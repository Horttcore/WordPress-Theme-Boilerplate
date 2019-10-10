<article id="post-<?php the_ID() ?>" <?php post_class('entry') ?>>

    <header class="entry__header">

        <div class="entry__date"><?php the_time(get_option('date_format')) ?></div>

        <h1 class="entry__title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>

    </header>

    <div class="entry__content cf">

        <?php the_content(__('Weiterlesen &raquo;', 'TEXTDOMAIN')) ?>

    </div>

</article>
