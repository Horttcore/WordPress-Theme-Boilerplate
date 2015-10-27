<article id="post-<?php the_ID() ?>" <?php post_class( 'cf' ) ?>>

	<header class="entry-header">

		<div class="entry-date"><?php the_time( get_option( 'date_format' ) ) ?></div>

		<h1 class="entry-title"><?php the_title() ?></h1>

	</header><!-- .entry-header -->

	<div class="entry-content cf">

		<?php the_content( __( 'Weiterlesen &raquo;', 'TEXTDOMAIN' ) ) ?>

	</div>

	<?php edit_post_link( __('Edit This'), '<footer class="entry-footer">', '</footer><!-- .entry-footer -->' ) ?>

</article>
