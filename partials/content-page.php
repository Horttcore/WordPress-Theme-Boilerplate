<article id="post-<?php the_ID() ?>" <?php post_class( 'clearfix' ) ?>>

	<div class="entry clearfix">
		<?php the_content() ?>
	</div>

	<footer>
		<?php edit_post_link() ?>
	</footer>

</article>