<article id="post-<?php the_ID() ?>" <?php post_class( 'entry cf' ) ?> role="main">

	<header class="entry-header">

		<h1 class="entry-title"><?php the_title() ?></h1>

	</header><!-- .entry-header -->

	<div class="entry-content cf">

		<?php the_content( __( 'Weiterlesen &raquo;', 'TEXTDOMAIN' ) ) ?>

	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID() ?> -->
