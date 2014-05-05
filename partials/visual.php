<?php
if ( has_post_thumbnail() ) :

	?>
	<div class="post-thumbnail">

		<?php the_post_thumbnail() ?>

	</div><!-- .post-thumbnail -->
	<?php

endif;