<article id="post-<?php the_ID() ?>" <?php post_class( 'entry cf' ) ?>>

    <header class="entry-header">

        <div class="entry-date"><?php the_time( get_option( 'date_format' ) ) ?></div>

        <h1 class="entry-title"><?php the_title() ?></h1>

    </header><!-- .entry-header -->

    <div class="entry-content cf">

        <?php the_content() ?>

    </div><!-- .entry-content -->

</article>
