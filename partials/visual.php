<?php
// Get slides
$attachments = new Attachments( 'slider' );

// No output if there is no visual elemet
if ( !has_post_thumbnail() && !$attachments->exist() )
	return;

?>

<div class="visual">

	<?php if ( $attachments->exist() ) : ?>

		<div class="slider">

			<?php while( $attachments->get() ) : ?>

				<div class="slide">

					<?php echo $attachments->image( 'slider' ) ?>

					<div class="slide-wrapper">

						<span class="slide-content">

							<?php echo apply_filters( 'the_content', $attachments->field( 'caption' ) ) ?>

						</span><!-- .slide-content -->

					</div><!-- .slide-wrapper -->

				</div><!-- .slide -->

			<?php endwhile;	?>

		</div><!-- .slider -->

	<?php elseif ( has_post_thumbnail() ) : ?>

		<?php the_post_thumbnail( 'visual' ); ?>

	<?php endif; ?>

</div><!-- .visual -->
