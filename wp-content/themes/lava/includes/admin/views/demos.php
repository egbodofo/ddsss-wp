<?php
$demo_option = get_option( 'lava_demo' );
$current_demo_id = isset( $demo_option['id'] ) ? $demo_option['id'] : '';
$lava_demos = array(
	array(
		'id' => 'default',
		'label' => esc_html__( 'Default', 'lava' ),
		'preview' => 'http://lava.themespirit.com/',
	),
	array(
		'id' => '2',
		'label' => esc_html__( 'Demo 2', 'lava' ),
		'preview' => 'http://lava.themespirit.com/demo-2/',
	),
	array(
		'id' => '3',
		'label' => esc_html__( 'Demo 3', 'lava' ),
		'preview' => 'http://lava.themespirit.com/demo-3/',
	)
);
?>
<div id="lava-admin-wrap" class="about-wrap">
	<?php require_once 'header.php'; ?>
	<div class="lava-admin-about">
		<h1><?php printf( esc_html__( '%s Demos', 'lava' ), LAVA_THEME_NAME ); ?></h1>
		<p><?php esc_html_e( 'Toggle off this option if you only want to import the customizer settings.', 'lava' ); ?></p>
		<div class="lava-toggle checked">
			<input type="checkbox" id="lava-content-checkbox" checked>
			<span class="lava-toggle-lever"></span>
			<label class="lava-label-include-content" for="lava-content-checkbox"><?php esc_html_e( 'Install demo content', 'lava' ); ?></label>
			<label class="lava-label-exclude-content" for="lava-content-checkbox"><?php esc_html_e( 'Only install customizer settings', 'lava' ); ?></label>
		</div>
	</div>
	<div class="lava-row">
	<?php foreach ( $lava_demos as $demo ) :
			$demo_id = isset( $demo['id'] ) ? $demo['id'] : '';
			$demo_label = isset( $demo['label'] ) ? $demo['label'] : '';
			$demo_thumb = LAVA_ADMIN_URI . '/assets/images/demos/' . $demo_id . '.jpg';
			$demo_preview = isset( $demo['preview'] ) ? $demo['preview'] : '';
			$disabled = !empty( $demo['disable'] ) ? ' disabled' : '';
		?>
		<div class="lava-admin-item lava-col-4<?php echo esc_attr( $current_demo_id == $demo_id ) ? ' lava-demo-installed' : ''; ?>">
			<div class="lava-item-wrapper">
				<div class="lava-item-overlay"></div>
				<div class="lava-item-screenshot">
					<img src="<?php echo esc_url( $demo_thumb ); ?>" alt="<?php echo esc_attr( $demo_label ); ?>">
				</div>
				<div class="lava-item-actionbar">
					<div class="lava-progressbar"></div>
					<div class="lava-item-title"><?php echo esc_html( $demo_label ); ?></div>
					<div class="lava-label-installing"><?php esc_html_e( 'Installing..', 'lava' ); ?></div>
					<div class="lava-label-uninstalling"><?php esc_html_e( 'Uninstalling..', 'lava' ); ?></div>
					<div class="lava-item-buttons">
						<input type="submit" class="button button-primary lava-button-uninstall" value="<?php esc_attr_e( 'Uninstall', 'lava' ); ?>"<?php echo esc_html( $disabled ); ?>>
						<input type="submit" class="button button-primary lava-button-install" value="<?php esc_attr_e( 'Install', 'lava' ); ?>" data-demo-id="<?php echo esc_attr( $demo_id ); ?>" <?php echo esc_html( $disabled ); ?>>
						<a class="button button-primary lava-button-preview" href="<?php echo esc_url( $demo_preview ); ?>" target="_blank" <?php echo esc_html( $disabled ); ?>><?php esc_html_e( 'Preview', 'lava' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
	<div class="clear"></div>
</div>