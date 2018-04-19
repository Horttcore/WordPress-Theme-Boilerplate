<header class="header" role="banner">

	<div class="header__container container">

		<?php the_custom_logo() ?>

        <a href="#" class="toggle-nav"><?php _e( 'Menü', 'TEXTDOMAIN' ) ?></a>

        <?php
        wp_nav_menu(array(
            'theme_location'    => 'main',
            'container'         => 'nav',
            'container_class'   => 'nav__main',
            'container_id'      => '',
            'menu_class'        => '',
            'menu_id'           => '',
            'before'            => '',
            'fallback_cb'       => '',
        ));
        ?>

        <?php
        wp_nav_menu(array(
            'theme_location'    => 'meta',
            'container'         => 'nav',
            'container_class'   => 'nav__meta',
            'container_id'      => '',
            'menu_class'        => '',
            'menu_id'           => '',
            'before'            => '',
            'fallback_cb'       => '',
        ));
        ?>

    </div><!-- .container -->

</header><!-- .header -->
