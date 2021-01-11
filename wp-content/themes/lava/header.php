<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php echo Lava_Util::get_option( 'header_code' ); ?>
	<?php wp_head(); ?>
	</head>
<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
	<?php wp_body_open(); ?>
	<div class="site">
		<?php echo Lava_Util::get_page_loader(); ?>
		<div class="site-overlay"></div>
		<div class="site-main">
		<?php get_template_part( 'templates/header/header', Lava()->get_header_style() ); ?>