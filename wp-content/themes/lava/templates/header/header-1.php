<div class="nav-overlay">
	<nav class="nav"><?php lava_fullscreen_menu(); ?></nav>
	<a id="nav-close" href="javascript:void(0)">
		<span class="nav-icon-x"></span>
	</a>
</div>
<header id="header" class="header-style-<?php echo esc_attr( Lava()->get_header_style() ); ?>">
	<div class="header-wrapper<?php echo esc_attr( Lava()->get_header_affix_style() ); ?>">
		<?php get_template_part( 'templates/header/logo' ); ?>
		<a class="hamburger" href="javascript:void(0)" role="button">
			<span class="menu-icon"><span></span><span></span><span></span></span>
			<h5 class="menu-text"><?php esc_html_e( 'Menu', 'lava' ); ?></h5>
		</a>
	</div>
</header>