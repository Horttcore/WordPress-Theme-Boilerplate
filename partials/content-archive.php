<article id="post-<?php the_ID() ?>" <?php post_class( 'entry cf' ) ?>>

	<header class="entry-header">

		<div class="entry-date"><?php the_time( get_option( 'date_format' ) ) ?></div>

		<h1 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>

	</header><!-- .entry-header -->

	<div class="entry-content cf">

		<?php the_content( __( 'Weiterlesen &raquo;', 'TEXTDOMAIN' ) ) ?>

	</div><!-- .entry -->

	<?php edit_post_link( __('Edit This'), '<footer class="entry-footer">', '</footer><!-- .entry-footer -->' ) ?>

</article><!-- #post-<?php the_ID() ?> -->
