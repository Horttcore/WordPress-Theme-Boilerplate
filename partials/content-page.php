<article id="post-<?php the_ID() ?>" <?php post_class( 'entry cf' ) ?>>

	<div class="entry-content cf">

		<?php the_content( __( 'Weiterlesen &raquo;', 'TEXTDOMAIN' ) ) ?>

	</div><!-- .entry-content -->

	<?php edit_post_link( __('Edit This'), '<footer class="entry-footer">', '</footer><!-- .entry-footer -->' ) ?>

</article>
