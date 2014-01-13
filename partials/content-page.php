<article id="post-<?php the_ID() ?>" <?php post_class( 'clearfix' ) ?>>

	<div class="entry clearfix">
		<?php the_content() ?>
	</div>

	<?php edit_post_link( __('Edit This'), '<footer class="entry-footer">', '</footer><!-- .entry-footer -->' ) ?>

</article>