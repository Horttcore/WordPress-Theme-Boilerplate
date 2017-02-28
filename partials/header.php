<header class="header cf" role="banner">

	<div class="container">

		<?php the_custom_logo() ?>

		<a href="#" class="toggle-nav"><?php _e( 'Menü', 'TEXTDOMAIN' ) ?></a>

		<?php
		wp_nav_menu(array(
			'theme_location'	=> 'main',
			'container'			=> 'nav',
			'container_class'	=> 'nav-main cf',
			'container_id'		=> '',
			'menu_class'		=> 'cf',
			'menu_id'			=> '',
			'before'			=> '',
			'fallback_cb'		=> '',
		));
		?>

		<?php
		wp_nav_menu(array(
			'theme_location'	=> 'meta',
			'container'			=> 'nav',
			'container_class'	=> 'nav-meta cf',
			'container_id'		=> '',
			'menu_class'		=> 'cf',
			'menu_id'			=> '',
			'before'			=> '',
			'fallback_cb'		=> '',
		));
		?>

	</div><!-- .container -->

</header><!-- .header -->
