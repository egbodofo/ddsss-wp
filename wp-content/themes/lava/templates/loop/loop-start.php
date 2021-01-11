<?php

switch( Lava()->get_post_style() ) {

	case '2':
		
		if ( 'full-width' == Lava()->get_layout() ) : ?>
			
			<div class="col x12 s6 m4 loop-post">
				<div <?php post_class( 'post-style-2' ); ?>>

		<?php else: ?>

			<div class="col x12 s6 loop-post">
				<div <?php post_class( 'post-style-2' ); ?>>
		
		<?php endif;

		break;

	default: ?>

		<div class="col x12 loop-post">
		<div <?php post_class( 'post-style-'. Lava()->get_post_style() ); ?>><?php

		break;
}