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
				<?php get_template_part( 'templates/header/logo' ); ?>
				<?php lava_main_menu(); ?>
				<div class="nav-btns">
					<?php if ( Lava_Util::get_option( 'nav_show_button', false ) ) : ?>
					<?php lava_nav_cta_button(); ?>
					<?php endif; ?>
					<button class="hamburger">
						<span class="menu-icon"><span></span><span></span><span></span></span>
					</button>
				</div>
			</nav>
		</div>
	</div>
</header>