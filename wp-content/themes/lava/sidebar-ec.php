<?php $sidebar_class = Lava_Util::get_option( 'sticky_sidebar', true ) ? ' sticky' : ''; ?>
<aside class="sidebar<?php echo esc_attr( $sidebar_class ); ?>">
	<div class="sidebar-wrapper"><?php
		if ( is_active_sidebar( 'ec-sidebar' ) ) {
			dynamic_sidebar( 'ec-sidebar' );
		} else {
			dynamic_sidebar( 'default-sidebar' );
		}
	?></div>
</aside>