<?php $sidebar_class = Lava_Util::get_option( 'sticky_sidebar', true ) ? ' sticky' : ''; ?>
<?php $sidebar_class = Lava_Util::get_option( 'hide_sidebar_on_xs', false ) ? $sidebar_class . ' hidden-xs' : $sidebar_class; ?>
<aside class="sidebar<?php echo esc_attr( $sidebar_class ); ?>">
	<div class="sidebar-wrapper"><?php
		if ( !empty( Lava()->get_sidebar_id() ) ) {
			dynamic_sidebar( Lava()->get_sidebar_id() );
		} else {
			dynamic_sidebar( 'default-sidebar' );
		}
	?>
	</div>
</aside>