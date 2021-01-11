<?php

class Lava_Custom_Fonts {
	function __construct() {
		add_action( 'wp_ajax_lava_add_font', array( $this, 'add_font' ) );
		add_action( 'wp_ajax_lava_save_fonts', array( $this, 'save_fonts' ) );
		add_action( 'wp_ajax_lava_save_custom_font', array( $this, 'save_custom_font' ) );
		add_action( 'wp_ajax_lava_remove_custom_font', array( $this, 'remove_custom_font' ) );
		add_action( 'after_switch_theme', array( $this, 'theme_presets' ) );
	}

	/**
	 * Add font to default font list
	 */
    function add_font() {
    	$font_source = isset( $_POST['source'] ) ? sanitize_text_field( $_POST['source'] ) : '';
    	$font_family = isset( $_POST['font_family'] ) ? sanitize_text_field( $_POST['font_family'] ) : '';

    	if ( 'google' == $font_source ) {
			$variants = Lava_Fonts::get_variants( $font_family );
			$checked_variants = array( '400', 'regular' );
			$variant_disabled = count( $variants ) > 1 ? '' : ' disabled'; ?>

			<li>
				<h2 class="lava-font-family"><?php echo esc_html( $font_family ); ?></h2>
				<div class="lava-font-source"><?php printf( esc_html__( 'Source: %s', 'lava_extension' ), 'Google' ); ?></div>
				<div class="lava-font-variant-subset">
					<div class="lava-font-variants">
						<h3><?php esc_html_e( 'Variants', 'lava_extension' ); ?>:</h3>
						<ul><?php

							foreach( $variants as $variant ):
								$attr = '';
								if ( in_array( $variant, $checked_variants ) ) {
									$attr = ' checked';
								} ?>

								<li>
									<label>
										<input type="checkbox" data-variant="<?php echo esc_attr( $variant ); ?>" class="lava-check-variant"<?php echo esc_html( $attr . $variant_disabled ); ?>>
										<?php echo esc_html( $variant ); ?>
									</label>
								</li>

						<?php endforeach; ?>

						</ul>
					</div>
					<div class="clear"></div>
				</div>
			</li><?php

    	} else if ( 'custom' == $font_source ) {
    		$font_style = '<style>' . Lava_Fonts::get_custom_font_css( $font_family ) . '</style>';
    		$font_preview = '<li>' . $font_style . '<span class="lava-font-specimen" style="font-family:\'' . esc_attr( $font_family ) . '\';">Grumpy wizards make toxic brew for the evil Queen and Jack.</span><span class="lava-font-family" data-source="Custom">' . esc_html( $font_family ) . '</span><a href="javascript:void(0)" class="lava-remove-font">X</a></li>';
    		$font_details = '<li><h2 class="lava-font-family">' . esc_html( $font_family ) . '</h2><div class="lava-font-source">' . esc_html__( 'Source: Custom', 'lava_extension' ) . '</div></li>';
    		echo json_encode( array( 'preview' => $font_preview, 'details' => $font_details ) );
    	}

    	exit;
    }

    /**
     * Save default font list
     */
    function save_fonts() {
    	$fontData = isset( $_POST['fontData'] ) ? (array) $_POST['fontData']: array();

    	if ( ! empty( $fontData ) ) {
    		update_option( 'lava_fonts', $fontData );
    		echo '<span class="success">' . esc_html__( 'Fonts Saved.', 'lava_extension' ) . '</span>';
    	}
    	exit;
    }

	/**
	 * Save custom fonts - upload font file & save font
	 */
	function save_custom_font() {
		check_admin_referer( 'save-cf-nonce', 'security' );

		if ( empty( $_FILES ) ) {
			echo json_encode( array( 'error' => '<span class="error">' . esc_html__( 'No font file was choosen.', 'lava_extension' )  . '</span>') );
			exit;
		}

		$font_name = isset( $_POST['font_name'] ) ? sanitize_text_field( $_POST['font_name'] ) : '';

		if ( empty( $font_name ) ) {
			echo json_encode( array( 'error' => '<span class="error">' . esc_html__( 'Please enter a font name.', 'lava_extension' )  . '</span>' ) );
			exit;
		}

		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		add_filter( 'upload_dir', array( $this, 'upload_dir' ) );
		add_filter( 'upload_mimes', array( $this, 'upload_mimes' ) );
		add_filter( 'wp_check_filetype_and_ext', array( $this, 'disable_mime_for_ttf_files' ), 10, 4 );

		$upload = wp_upload_dir();
		$success = false;
		$new_font = array();
		$new_font['family'] = $font_name;
		$custom_fonts = get_option( 'lava_custom_fonts' );

		// check if font exists
		if ( ! empty( $custom_fonts ) ) {
			foreach ( $custom_fonts as $font ) {
				if ( $font['family'] == $font_name ) {
					echo json_encode( array( 'error' => '<span class="error">' . esc_html__( 'Font already exist.', 'lava_extension' )  . '</span>' ) );
					exit;
				}
			}
		}

		foreach ( $_FILES as $key => $file ) {
			if ( ! @file_exists( trailingslashit( $upload['path'] ) . $file['name'] ) ) {
				$overrides = array( 'test_form' => false );
				$upload_file = wp_handle_upload( $file, $overrides );
				if ( isset( $upload_file['error'] ) ) {
					echo json_encode( array( 'error' => '<span class="error">' . $upload_file['error'] . '</span>' ) );
					exit;
				}
			}
			$new_font[$key] = trailingslashit( $upload['url'] ) . sanitize_text_field( $file['name'] );
		}
		remove_filter( 'upload_dir', array( $this, 'upload_dir' ) );
		remove_filter( 'upload_mimes', array( $this, 'upload_mimes' ) );
		remove_filter( 'wp_check_filetype_and_ext', array( $this, 'disable_mime_for_ttf_files' ) );

		// update font option
		$custom_fonts = get_option( 'lava_custom_fonts' );
		if ( empty( $custom_fonts ) ) {
			$custom_fonts = array();
		}
		$custom_fonts[] = $new_font;
		update_option( 'lava_custom_fonts', $custom_fonts );

		echo json_encode( array( 'success' => '<span class="success">' . esc_html__( 'Font has been added.', 'lava_extension' ) . '</span>' ) );

		exit;
	}

	/**
	 * Remove custom font
	 */
	function remove_custom_font() {
		$font_name = isset( $_POST['font_name'] ) ? sanitize_text_field( $_POST['font_name'] ) : '';
		$upload = wp_upload_dir();
		if ( ! empty( $font_name ) ) {
			$custom_fonts = get_option( 'lava_custom_fonts' );
			$i = 0;
			foreach ( $custom_fonts as $font ) {
				if ( $font['family'] == $font_name ) {
					foreach ( $font as $key => $value ) {
						if ( $key !== 'family' && ! empty( $value ) ) {
							$file_name = basename( $value );
							$file_name = preg_replace( '/.[^.]*$/', '', $file_name );
							$file_path = trailingslashit( $upload['basedir'] ) . 'lava-fonts/' . $file_name . '.' . $key;
							if ( @file_exists( $file_path ) ) {
								@unlink( $file_path );
							}
						}
					}
					unset( $custom_fonts[$i] );
					$custom_fonts = array_values( $custom_fonts );
					update_option( 'lava_custom_fonts', $custom_fonts );
					break;
				}
				$i ++;
			}

			$fonts = get_option( 'lava_fonts' );
			$j = 0;
			foreach ( $fonts as $font ) {
				if ( $font['family'] == $font_name ) {
					unset( $fonts[$j] );
					$fonts = array_values( $fonts );
					update_option( 'lava_fonts', $fonts );
					break;
				}
				$j ++;
			}
		}
		exit;
	}

	function upload_dir( $upload ) {
		$upload['subdir'] = '/lava-fonts';
		$upload['path'] = $upload['basedir'] . $upload['subdir'];
		$upload['url'] = $upload['baseurl'] . $upload['subdir'];
		return $upload;
	}

	function upload_mimes( $mimes ) {
		$mimes['woff'] = 'application/font-woff';
		$mimes['ttf'] = 'application/x-font-truetype';
		$mimes['eot'] = 'application/vnd.ms-fontobject';
		$mimes['svg'] = 'image/svg+xml';
		$mimes['woff2'] = 'application/font-woff2';
		$mimes['otf'] = 'application/x-font-opentype';
		return $mimes;
	}

	/**
	 * Disable Mime type check for TTF font files
	 *
	 * A bug was introduced in WordPress 4.7.1 which caused stricter checks on mime types
	 * However, files can have multiple mime types which doesn't appear to be supported yet.
	 * Once this bug is resolved we'll remove this patch.
	 *
	 * @trac https://core.trac.wordpress.org/ticket/39550
	 *
	 * @param array  $data     File data array containing 'ext', 'type', and 'proper_filename' keys.
	 * @param string $file     Full path to the file.
	 * @param string $filename The name of the file (may differ from $file due to $file being in a tmp directory).
	 * @param array  $mimes    Key is the file extension with value as the mime type.
	 *
	 * @return array
	 *
	 * @since 4.1
	 */
	function disable_mime_for_ttf_files( $data, $file, $filename, $mimes ) {
		$wp_filetype = wp_check_filetype( $filename, $mimes );
		if ( strtolower( $wp_filetype['ext'] ) === 'ttf' ) {
			$ext             = $wp_filetype['ext'];
			$type            = $wp_filetype['type'];
			$proper_filename = $data['proper_filename'];
			return compact( 'ext', 'type', 'proper_filename' );
		}
		return $data;
	}
	
    function theme_presets() {
        $theme_info = get_option( 'lava_theme_info' );
        if ( !isset( $theme_info ) ) {
            $theme_info['theme_activated'] = false;
            update_option( 'lava_theme_info', $theme_info );
        }
        // install default fonts
        Lava_Fonts::add_preset_fonts();
    }
}

new Lava_Custom_Fonts();
