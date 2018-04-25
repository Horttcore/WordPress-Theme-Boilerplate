<footer class="footer">

	<div class="container">

		<?php
        wp_nav_menu(array(
            'theme_location'    => 'footer',
            'container'         => 'nav',
            'container_class'   => 'nav__footer ',
            'container_id'      => '',
            'menu_class'        => '',
            'menu_id'           => '',
            'before'            => '',
            'fallback_cb'       => '',
        ));
        ?>

    </div><!-- .container -->

</footer><!-- .footer -->
