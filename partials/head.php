<!DOCTYPE html>
<!--[if IE 8]><html id="ie8" <?php body_class(); ?> <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 8)  ]><!--><html <?php body_class(); ?> <?php language_attributes(); ?>><!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title(''); ?></title>
<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<link rel="icon" href="<?php echo get_stylesheet_directory_uri() ?>/images/favicon.ico" type="image/x-icon">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>