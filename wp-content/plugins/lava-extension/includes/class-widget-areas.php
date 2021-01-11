<?php

class Lava_Widget_Areas {

	function __construct() {
		add_action( 'wp_ajax_lava_widget_areas', array( $this, 'run' ) );
	}

	function run() {
		$action = $_POST['wa_action'];
		if ( $action == 'add' ) {
			$wa_name = isset( $_POST['wa_name'] ) ? sanitize_text_field( $_POST['wa_name'] ) : '';
			$wa_desc = isset( $_POST['wa_desc'] ) ? sanitize_text_field( $_POST['wa_desc'] ) : '';
			
			if ( ! empty( $wa_name ) ) {
				$this->add( $wa_name, $wa_desc );
			} else {
				self::response( 1, null );
			}
		} elseif ( $action == 'remove' ) {
			$wa_id = isset( $_POST['wa_id'] ) ? sanitize_text_field( $_POST['wa_id'] ) : '';
			$this->remove( $wa_id );
		}
		exit;
	}

	function add( $name, $desc ) {
		global $wp_registered_sidebars;

		$id = self::name_to_id( $name );
		$widget_areas = get_option( 'lava_widget_areas' );

		if ( !empty( $wp_registered_sidebars ) && array_key_exists( $id, $wp_registered_sidebars ) ) {
			self::response( 2, null );
			return;
		}

		if ( !empty( $widget_areas ) && array_key_exists( $id, $widget_areas ) ) {
			self::response( 2, null );
			return;
		}

		$widget_areas[$id] = array( 'name' => $name, 'desc' => $desc );
		update_option( 'lava_widget_areas', $widget_areas );
		$desc = empty( $desc ) ? '' : '<p>'. esc_html( $desc ) .'</p>';
		$data = '<li><h3 class="lava-wa-name"><span class="lava-wa-name-arrow"></span>'. esc_html( $name ) .'</h3><div class="lava-wa-info">'. $desc .'<a class="lava-button-remove-wa button button-primary" href="javascript:void(0)" data-id="'. esc_attr( $id ) .'">'. esc_html__( 'Remove', 'lava_extension' ) .'</a></div></li>';
		self::response( 3, $data );
	}

	function remove( $id ) {
		$widget_areas = get_option( 'lava_widget_areas' );
		
		if ( array_key_exists( $id, $widget_areas ) ) {
			unset( $widget_areas[$id] );
			update_option( 'lava_widget_areas', $widget_areas );
			self::response( 4, null );
		} else {
			self::response( 5, null );
		}
	}

	static function response( $index, $data ) {
		$message = '';
		switch( $index ) {
			case 1: $error = true; $message = '<span class="error">'. esc_html__( 'Name cannot be empty.', 'lava_extension' ) .'</span>'; break;
			case 2: $error = true; $message = '<span class="error">'. esc_html__( 'Name exist, please use another name.', 'lava_extension' ) .'</span>'; break;
			case 3: $error = false; $message = '<span>'. esc_html__( 'New widget area created successfully.', 'lava_extension' ) .'</span>'; break;
			case 4: $error = false; $message = '<span>'. esc_html__( 'Widget removed.', 'lava_extension' ) .'</span>'; break;
			case 5: $error = true; $message = '<span class="error">'. esc_html__( 'Widget cannot be removed.', 'lava_extension' ) .'</span>'; break;
		}
		
		if ( $index == 3 ) {
			echo json_encode( array( 'error'=> $error, 'message' => $message, 'data' => $data ) );
		} else {
			echo json_encode( array( 'error'=> $error, 'message' => $message ) );
		}
	}

	static function name_to_id( $name ) {
		$id = trim( $name );
		$id = preg_replace( '!\s+!', '-', $id );
		return strtolower( $id );
	}
}

new Lava_Widget_Areas();