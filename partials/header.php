<header class="header clearfix">

	<a class="logo" href="<?php echo home_url() ?>">
		<img src="<?php echo get_stylesheet_directory_uri() ?>/images/logo-WP_SLUG.png" alt="<?php bloginfo('name') ?>" title="<?php bloginfo('description') ?>">
	</a>

	<?php
	wp_nav_menu(array(
		'theme_location'	=> 'main',
		'container'			=> 'nav',
		'container_class'	=> 'nav-main clearfix',
		'container_id'		=> '',
		'menu_class'		=> 'clearfix',
		'menu_id'			=> '',
		'before'			=> '',
		'fallback_cb'		=> '',
	));
	?>

	<?php
	wp_nav_menu(array(
		'theme_location'	=> 'meta',
		'container'			=> 'nav',
		'container_class'	=> 'nav-meta clearfix',
		'container_id'		=> '',
		'menu_class'		=> 'clearfix',
		'menu_id'			=> '',
		'before'			=> '',
		'fallback_cb'		=> '',
	));
	?>

</header><!-- .header -->