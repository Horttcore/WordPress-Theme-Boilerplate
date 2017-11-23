<?php
// Get slides
if (class_exists( 'Attachments' )) {
    $attachments = new Attachments( 'slider' );
}

// No output if there is no visual elemet
if (!has_post_thumbnail() && ( !class_exists( 'Attachments' ) || !$attachments->exist() )) {
    return;
}

?>

<div class="visual cf">

    <?php if (class_exists( 'Attachments' ) && $attachments->exist()) : ?>

        <div class="slider">

            <?php while ($attachments->get()) : ?>

                <div class="slide">

                    <?php echo $attachments->image( 'large' ) ?>

                </div><!-- .slide -->

            <?php endwhile;     ?>

        </div><!-- .slider -->

    <?php elseif (has_post_thumbnail()) : ?>

        <?php the_post_thumbnail( 'large' ); ?>

    <?php endif; ?>

</div><!-- .visual -->
