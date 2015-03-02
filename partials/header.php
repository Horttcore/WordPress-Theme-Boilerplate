<header class="header cf" role="banner">

	<div class="container">

		<a class="logo" href="<?php echo home_url() ?>">
			<img src="<?php echo get_stylesheet_directory_uri() ?>/images/logo-WP_SLUG.png" alt="<?php bloginfo('name') ?>" title="<?php bloginfo('description') ?>">
		</a>

		<a href="#" class="toggle-nav"><?php _e( 'Menu', 'TEXTDOMAIN' ) ?></a>

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
