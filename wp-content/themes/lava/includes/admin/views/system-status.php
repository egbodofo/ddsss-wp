<div id="lava-admin-wrap" class="about-wrap lava-system-status">
	<?php require_once 'header.php'; ?>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th colspan="3"><?php esc_html_e( 'Theme Info', 'lava' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="lava-system-status-label"><?php esc_html_e( 'Theme Name', 'lava' ); ?></td>
				<td class="lava-system-status-value"><?php echo LAVA_THEME_NAME; ?></td>
			</tr>
			<tr>
				<td class="lava-system-status-label"><?php esc_html_e( 'Theme Version', 'lava' ); ?></td>
				<td class="lava-system-status-value"><?php echo LAVA_THEME_VERSION; ?></td>
			</tr>
		</tbody>
	</table>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th colspan="3"><?php esc_html_e( 'Server Environment', 'lava' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="lava-system-status-label"><?php esc_html_e( 'PHP Version', 'lava' ); ?></td>
				<td><?php if ( function_exists( 'phpversion' ) ) echo phpversion(); ?></td>
			</tr>
			<tr>
				<td class="lava-system-status-label"><?php esc_html_e( 'MySQL Version', 'lava' ); ?></td>
				<td class="lava-system-status-value"><?php global $wpdb; echo esc_html( $wpdb->db_version() ); ?></td>
			</tr><?php
			
			if ( function_exists( 'ini_get' ) ) : ?>
				
				<tr>
					<td class="lava-system-status-label"><?php esc_html_e( 'PHP post_max_size', 'lava' ); ?></td>
					<td class="lava-system-status-value"><?php echo ini_get( 'post_max_size' ); ?><span class="lava-help-tip"><?php
						printf( 
							wp_kses(
								__( ' - file upload size. See: <a href="%s" target="_blank">Increasing max file upload size.</a>', 'lava' ),
								array(
									'a' => array(
										'href' => array(),
										'target' => array( '_blank' ),
									)
								)
							),
							'https://themespirit.com/'
						);
						?></span>
					</td>
				</tr>
				<tr>
					<td class="lava-system-status-label"><?php esc_html_e( 'PHP max_execution_time', 'lava' ); ?></td>
					<td class="lava-system-status-value"><?php echo ini_get( 'max_execution_time' ); ?></td>
				</tr>
				<tr>
					<td class="lava-system-status-label"><?php esc_html_e( 'PHP max_input_vars', 'lava' ); ?></td>
					<td class="lava-system-status-value"><?php
						$max_input_vars = ini_get( 'max_input_vars' );
						if ( $max_input_vars < 3000 ) {
							echo esc_html( $max_input_vars ) . '<span class="lava-help-tip">';
							printf(
								wp_kses(
									__( ' - Recommended Value: <strong>3000</strong>. Max input vars limitation will truncate POST data such as menus. See: <a href="%s" target="_blank">Increasing max input vars limit.</a>', 'lava' ),
									array(
										'a' => array(
											'href' => array(),
											'target' => array( '_blank' ),
										),
										'strong' => array()
									)
								),
								'http://sevenspark.com/docs/ubermenu-3/faqs/menu-item-limit'
							);
							echo '</span>';
						} else {
							echo '<span class="lava-ok">' . esc_html( $max_input_vars ) . '</span>';
						} ?>
					</td>
				</tr>
				<tr>
					<td class="lava-system-status-label"><?php esc_html_e( 'SUHOSIN Installed', 'lava' ); ?></td>
					<td class="lava-system-status-value"><?php echo extension_loaded( 'suhosin' ) ? '&#10004;' : '&ndash;'; ?></td>
				</tr><?php

			endif; ?>

		</tbody>
	</table>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th colspan="3"><?php esc_html_e( 'WordPress Environment', 'lava' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="lava-system-status-label"><?php esc_html_e( 'WP Home URL', 'lava' ); ?></td>
				<td class="lava-system-status-value"><?php echo esc_url( home_url() ); ?></td>
			</tr>
			<tr>
				<td class="lava-system-status-label"><?php esc_html_e( 'WP Site URL', 'lava' ); ?></td>
				<td class="lava-system-status-value"><?php echo esc_url( site_url() ); ?></td>
			</tr>
			<tr>
				<td class="lava-system-status-label"><?php esc_html_e( 'WP Version', 'lava' ); ?></td>
				<td class="lava-system-status-value"><?php bloginfo( 'version' ); ?></td> 
			</tr>
			<tr>
				<td class="lava-system-status-label"><?php esc_html_e( 'WP Multisite', 'lava' ); ?></td>
				<td class="lava-system-status-value"><?php if ( is_multisite() ) echo '<span class="lava-check">&#10004;</span>'; else echo '&ndash;'; ?></td>
			</tr>
			<tr>
				<td class="lava-system-status-label"><?php esc_html_e( 'WP Memory Limit', 'lava' ); ?></td>
				<td class="lava-system-status-value"><?php
					$memory = preg_replace( '/[^\d]/', '', WP_MEMORY_LIMIT );
					if ( $memory < 64 ) {
						echo esc_html( $memory ) . 'MB<span class="lava-help-tip">';
						printf(
							wp_kses(
								__( ' - We recommend setting memory limit to at least <strong>64MB</strong>. Increase this value if you plan to use many plugins on your site.<br />See: <a href="%s" target="_blank">Increasing memory allocated to PHP.</a>', 'lava' ),
								array(
									'a' => array(
										'href' => array(),
										'target' => array( '_blank' ),
									),
									'strong' => array(),
									'br' => array()
								)
							),
							'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP'
						); 
						echo '</span>';
					} else {
						echo '<span class="lava-ok">' . esc_html( $memory ) . 'MB</span>';
					}
				?></td>
			</tr>
			<tr>
				<td class="lava-system-status-label"><?php esc_html_e( 'WP Debug Mode', 'lava' ); ?></td>
				<td class="lava-system-status-value"><?php if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) echo '<span class="lava-check">&#10004;</span>'; else echo '&ndash;'; ?></td>
			</tr>
			<tr>
				<td class="lava-system-status-label"><?php esc_html_e( 'WP Language', 'lava' ); ?></td>
				<td class="lava-system-status-value"><?php echo get_locale(); ?></td>
			</tr>
		</tbody>
	</table>
</div>