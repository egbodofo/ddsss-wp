<div id="lava-admin-wrap" class="about-wrap lava-widget-areas">
	<?php require_once 'header.php'; ?>
	<div class="lava-admin-about">
		<h1><?php esc_html_e( 'Custom Widget Areas', 'lava' ); ?></h1>
	</div>
	<div class="lava-admin-columns">
		<div id="col-left">
			<form id="lava-add-wa-form" method="post" action>
				<p>
					<label for="lava-wa-name"><?php esc_html_e( 'Name', 'lava' ); ?></label>
					<input type="text" name="lava-wa-name" id="lava-wa-name">
				</p>
				<p>
					<label for="lava-wa-desc"><?php esc_html_e( 'Description ( optional )', 'lava' ); ?></label>
					<textarea name="lava-wa-desc" id="lava-wa-desc" rows="3"></textarea>
				</p>
				<p>
					<button type="submit" id="lava-button-add-wa" class="button button-primary"><?php esc_html_e( ' + Add New Widget Area', 'lava' ); ?></button>
				</p>
				<div id="lava-wa-message"></div>
			</form>
		</div>
		<div id="col-right">
			<ul id="lava-wa-list">
			<?php $widget_areas = get_option( 'lava_widget_areas' );
			if ( $widget_areas ):
				foreach ( $widget_areas as $id => $data ): ?>
				<li>
					<h3 class="lava-wa-name"><span class="lava-wa-name-arrow"></span><?php echo esc_html( $data['name'] ); ?></h3>
					<div class="lava-wa-info">
						<?php if ( !empty( $data['desc'] ) ): ?>
						<p class="lava-wa-desc"><?php echo esc_html( $data['desc'] ); ?></p>
						<?php endif; ?>
						<a class="lava-button-remove-wa button button-primary" href="javascript:void( 0 )" data-id="<?php echo esc_attr( $id ); ?>"><?php esc_html_e( 'Remove', 'lava' ); ?></a>
					</div>
				</li><?php
				endforeach;
			endif; ?>
			</ul>
		</div>
	</div>
</div>