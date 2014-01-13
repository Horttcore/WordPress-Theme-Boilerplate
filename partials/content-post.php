<article id="post-<?php the_ID() ?>" <?php post_class( 'clearfix' ) ?>>

	<header>
		<div class="post-date"><?php the_date() ?></div>
		<h1><?php the_title() ?></h1>
	</header>

	<div class="entry clearfix">
		<?php the_content( __( 'Weiterlesen &raquo;', 'TEXTDOMAIN' ) ) ?>
	</div>

	<?php edit_post_link( __('Edit This'), '<footer class="entry-footer">', '</footer><!-- .entry-footer -->' ) ?>

</article>