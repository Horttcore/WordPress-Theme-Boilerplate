<article id="post-<?php the_ID() ?>" <?php post_class( 'clearfix' ) ?>>

	<header>
		<h2><?php the_title() ?></h2>
	</header>

	<div class="entry clearfix">
		<?php the_content() ?>
	</div>

	<?php edit_post_link( __('Edit This'), '<footer class="entry-footer">', '</footer><!-- .entry-footer -->' ) ?>

</article>