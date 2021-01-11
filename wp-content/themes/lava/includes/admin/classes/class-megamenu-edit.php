<?php
/**
 * Navigation Menu API: Walker_Nav_Menu_Edit class
 *
 */
class Lava_Megamenu_Edit extends Walker_Nav_Menu {
	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker_Nav_Menu::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker_Nav_Menu::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * Start the element output.
	 *
	 * @see Walker_Nav_Menu::start_el()
	 * @since 3.0.0
	 *
	 * @global int $_wp_nav_menu_max_depth
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 * @param int    $id     Not used.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		ob_start();
		$item_id = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = false;
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) )
				$original_title = false;
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title = get_the_title( $original_object->ID );
		} elseif ( 'post_type_archive' == $item->type ) {
			$original_object = get_post_type_object( $item->object );
			if ( $original_object ) {
				$original_title = $original_object->labels->archives;
			}
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive' ),
		);

		$title = $item->title;

		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( __( '%s (Invalid)', 'lava' ), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( __('%s (Pending)', 'lava' ), $item->title );
		}

		$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;
		?>
		<li id="menu-item-<?php echo esc_attr( $item_id ); ?>" class="<?php echo implode(' ', $classes ); ?>">
			<div class="menu-item-bar">
				<div class="menu-item-handle">
					<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu"<?php if ( 0 == $depth ) echo ' style="display:none;"'; ?>><?php esc_html_e( 'sub item', 'lava' ); ?></span></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-up-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-up" aria-label="<?php esc_attr_e( 'Move up', 'lava' ) ?>">&#8593;</a>
							|
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-down-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-down" aria-label="<?php esc_attr_e( 'Move down', 'lava' ) ?>">&#8595;</a>
						</span>
						<a class="item-edit" id="edit-<?php echo esc_attr( $item_id ); ?>" href="<?php
							echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
						?>" aria-label="<?php esc_attr_e( 'Edit menu item', 'lava' ); ?>"><span class="screen-reader-text"><?php esc_html_e( 'Edit', 'lava' ); ?></span></a>
					</span>
				</div>
			</div>

			<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo esc_attr( $item_id ); ?>">
				<?php if ( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'URL', 'lava' ); ?><br />
							<input type="text" id="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-wide">
					<label for="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'Navigation Label', 'lava' ); ?><br />
						<input type="text" id="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>
				<p class="field-title-attribute field-attr-title description description-wide">
					<label for="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'Title Attribute', 'lava' ); ?><br />
						<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr( $item_id ); ?>]"<?php checked( $item->target, '_blank' ); ?> />
						<?php esc_html_e( 'Open link in a new tab', 'lava' ); ?>
					</label>
				</p>
				<p class="field-css-classes description description-thin">
					<label for="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'CSS Classes (optional)', 'lava' ); ?><br />
						<input type="text" id="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'Link Relationship (XFN)', 'lava' ); ?><br />
						<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p>
				<p class="field-description description description-wide">
					<label for="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'Description', 'lava' ); ?><br />
						<textarea id="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr( $item_id ); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
						<span class="description"><?php esc_html_e( 'The description will be displayed in the menu if the current theme supports it.', 'lava' ); ?></span>
					</label>
				</p>

				<!-- lava megamenu section start -->
				<div class="lava-megamenu-edit">
					<p class="field-iconfont description description-wide">
						<label for="edit-menu-item-lava-megamenu-iconfont-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Menu Icon ( Use a Material Icon name. e.g. thumb_up ) ', 'lava' ); ?><a href="https://material.io/icons/" target="_blank"><?php esc_html_e( 'Browse Icons', 'lava' ); ?></a><br />
							<input type="text" id="edit-menu-item-lava-megamenu-iconfont-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-lava-megamenu-iconfont" name="menu-item-lava-megamenu-iconfont[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_html( $item->lava_megamenu_iconfont ); ?>" />
						</label>
					</p>
					<?php $img_url = $item->lava_megamenu_icon; ?>
					<p class="field-icon description description-wide<?php if (!empty($img_url)) { echo ' has-image'; } ?>">
						<label for="edit-menu-item-lava-megamenu-icon-<?php echo esc_attr( $item_id ); ?>">
							<input type="text" id="edit-menu-item-lava-megamenu-icon-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-lava-megamenu-icon" name="menu-item-lava-megamenu-icon[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_url( $img_url ); ?>" />
							<a href="javascript:void(0)" class="button button-secondary lava-megamenu-set-image"><?php esc_html_e( 'Set Image Icon', 'lava' ); ?></a>
							<img class="lava-megamenu-image-preview" src="<?php echo esc_url( $img_url ); ?>" alt="image preview">
							<a href="javascript:void(0)" class="button button-secondary lava-megamenu-remove-image"><?php esc_html_e( 'Remove Image', 'lava' ); ?></a>
						</label>
					</p>
					<p class="field-enable description description-wide">
						<label for="edit-menu-item-lava-megamenu-enable-<?php echo esc_attr( $item_id ); ?>">
							<input type="checkbox" id="edit-menu-item-lava-megamenu-enable-<?php echo esc_attr( $item_id ); ?>" class="widefat menu-item-lava-megamenu-enable" name="menu-item-lava-megamenu-enable[<?php echo esc_attr( $item_id ); ?>]" value="1" <?php checked( $item->lava_megamenu_enable, 1 ); ?> />
							<?php esc_html_e( 'Enable Mega Menu', 'lava' ); ?>
						</label>
					</p>
					<p class="field-width description description-wide">
						<label for="edit-menu-item-lava-megamenu-width-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Mega Menu Width ( In columns e.g. 8 columns equals to full width )', 'lava' ); ?>
							<select id="edit-menu-item-lava-megamenu-width" class="widefat edit-menu-item-lava-megamenu-width" name="menu-item-lava-megamenu-width[<?php echo esc_attr( $item_id ); ?>]" >
								<option value="8" <?php selected( $item->lava_megamenu_width, '8' ); ?>><?php esc_html_e( 'Full Width ( 8 )', 'lava' ); ?></option>
							<?php for( $i = 1; $i < 9; $i++ ) :  ?>
								<option value="<?php echo esc_attr( $i );?>" <?php selected( $item->lava_megamenu_width, $i ); ?> ><?php echo esc_html( $i ); ?></option>
							<?php endfor; ?>
							</select>
						</label>
					</p>
					<p class="field-hide-text description description-wide">
						<label for="edit-menu-item-lava-megamenu-hide-text-<?php echo esc_attr( $item_id ); ?>">
							<input type="checkbox" id="edit-menu-item-lava-megamenu-hide-text-<?php echo esc_attr( $item_id ); ?>" class="widefat code menu-item-lava-megamenu-hide-text" name="menu-item-lava-megamenu-hide-text[<?php echo esc_attr( $item_id ); ?>]" value="1" <?php checked( $item->lava_megamenu_hide_text, 1 ); ?> />
							<?php esc_html_e( 'Hide Text', 'lava' ); ?>
						</label>
					</p>
					<p class="field-new-row description description-wide">
						<label for="edit-menu-item-lava-megamenu-new-row-<?php echo esc_attr( $item_id ); ?>">
							<input type="checkbox" id="edit-menu-item-lava-megamenu-new-row-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-lava-megamenu-new-row" name="menu-item-lava-megamenu-new-row[<?php echo esc_attr( $item_id ); ?>]" value="1" <?php checked( $item->lava_megamenu_new_row, 1 ); ?> />
							<?php esc_html_e( 'Start a New Row', 'lava' ); ?>
						</label>
					</p>
					<p class="field-widget-area description description-wide">
						<label for="edit-menu-item-lava-megamenu-widget-area-<?php echo esc_attr( $item_id ); ?>">	
							<?php esc_html_e( 'Mega Menu Widget Area', 'lava' ); ?>
							<select id="edit-menu-item-lava-megamenu-widget-area-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-lava-megamenu-widget-area" name="menu-item-lava-megamenu-widget-area[<?php echo esc_attr( $item_id ); ?>]" >
								<option value="0"><?php esc_html_e( 'Select a Widget Area', 'lava' ); ?></option>
							<?php global $wp_registered_sidebars;
								if ( ! empty( $wp_registered_sidebars ) && is_array( $wp_registered_sidebars ) ):
									foreach( $wp_registered_sidebars as $sidebar ):?>
								 	<option value="<?php echo esc_attr( $sidebar['id'] ); ?>" <?php selected( $item->lava_megamenu_widget_area, $sidebar['id'] ); ?> ><?php echo esc_html( $sidebar['name'] ); ?></option>;
								<?php endforeach; ?>
							<?php endif; ?>
							</select>
						</label>
					</p>
					<p class="field-column-width description description-wide">
						<label for="edit-menu-item-lava-megamenu-column-width-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Column Width', 'lava' ); ?>
							<select id="edit-menu-item-lava-megamenu-column-width" class="widefat edit-menu-item-lava-megamenu-column-width" name="menu-item-lava-megamenu-column-width[<?php echo esc_attr( $item_id ); ?>]" >
								<option value="4" <?php selected( $item->lava_megamenu_column_width, 'auto' ); ?>><?php esc_html_e( 'Auto ( 1/4 )', 'lava' ); ?></option>
							<?php for( $i = 0; $i < count( lava_Util::$columns ); $i++ ) :  ?>
								<option value="<?php echo esc_attr( $i );?>" <?php selected( $item->lava_megamenu_column_width, $i ); ?> ><?php echo lava_Util::$columns[ $i ]; ?></option>
							<?php endfor; ?>
							</select>
						</label>
					</p>
				</div>
				<!-- lava megamenu section end -->

				<fieldset class="field-move hide-if-no-js description description-wide">
					<span class="field-move-visual-label" aria-hidden="true"><?php esc_html_e( 'Move', 'lava' ); ?></span>
					<button type="button" class="button-link menus-move menus-move-up" data-dir="up"><?php esc_html_e( 'Up one', 'lava' ); ?></button>
					<button type="button" class="button-link menus-move menus-move-down" data-dir="down"><?php esc_html_e( 'Down one', 'lava' ); ?></button>
					<button type="button" class="button-link menus-move menus-move-left" data-dir="left"></button>
					<button type="button" class="button-link menus-move menus-move-right" data-dir="right"></button>
					<button type="button" class="button-link menus-move menus-move-top" data-dir="top"><?php esc_html_e( 'To the top', 'lava' ); ?></button>
				</fieldset>

				<div class="menu-item-actions description-wide submitbox">
					<?php if ( 'custom' != $item->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( __('Original: %s', 'lava' ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr( $item_id ); ?>" href="<?php
					echo wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => $item_id,
							),
							admin_url( 'nav-menus.php' )
						),
						'delete-menu_item_' . $item_id
					); ?>"><?php esc_html_e( 'Remove', 'lava' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr( $item_id ); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
						?>#menu-item-settings-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Cancel', 'lava' ); ?></a>
				</div>

				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item_id ); ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();
	}

} // Walker_Nav_Menu_Edit
