<footer class="footer cf">

	<div class="container">

		<?php
        wp_nav_menu(array(
            'theme_location'    => 'footer',
            'container'             => 'nav',
            'container_class'   => 'nav-footer cf',
            'container_id'      => '',
            'menu_class'        => 'cf',
            'menu_id'           => '',
            'before'            => '',
            'fallback_cb'       => '',
        ));
        ?>

    </div><!-- .container -->

</footer><!-- .footer -->
