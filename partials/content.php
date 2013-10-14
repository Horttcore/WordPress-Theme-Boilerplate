<article id="post-<?php the_ID() ?>" <?php post_class( 'clearfix' ) ?>>

	<header>
		<h2><?php the_title() ?></h2>
	</header>

	<div class="entry clearfix">
		<?php the_content() ?>
	</div>

	<footer>
		<?php edit_post_link() ?>
	</footer>

</article>