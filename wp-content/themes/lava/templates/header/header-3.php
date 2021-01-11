<div class="nav-overlay">
	<nav class="nav"><?php lava_fullscreen_menu(); ?></nav>
	<a id="nav-close" href="javascript:void(0)">
		<span class="nav-icon-x"></span>
	</a>
</div>
<header id="header" class="header-style-<?php echo esc_attr( Lava()->get_header_style() ); ?>">
	<div class="header-wrapper<?php echo esc_attr( Lava()->get_header_affix_style() ); ?>">
		<div class="container-fluid">
			<nav class="nav">
				<div class="nav-left"><?php lava_left_menu(); ?></div>
				<?php get_template_part( 'templates/header/logo' ); ?>
				<div class="nav-right"><?php lava_right_menu(); ?></div>
				<button class="hamburger">
					<span class="menu-icon"><span></span><span></span><span></span></span>
				</button>
			</nav>
		</div>
	</div>
</header>