<?php
/**
 * Typography control class.
 *
 * @since  1.0.0
 * @access public
 */

class Pool_Services_Lite_Control_Typography extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'typography';

	/**
	 * Array 
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $l10n = array();

	/**
	 * Set up our control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @param  string  $id
	 * @param  array   $args
	 * @return void
	 */
	public function __construct( $manager, $id, $args = array() ) {

		// Let the parent class do its thing.
		parent::__construct( $manager, $id, $args );

		// Make sure we have labels.
		$this->l10n = wp_parse_args(
			$this->l10n,
			array(
				'color'       => esc_html__( 'Font Color', 'pool-services-lite' ),
				'family'      => esc_html__( 'Font Family', 'pool-services-lite' ),
				'size'        => esc_html__( 'Font Size',   'pool-services-lite' ),
				'weight'      => esc_html__( 'Font Weight', 'pool-services-lite' ),
				'style'       => esc_html__( 'Font Style',  'pool-services-lite' ),
				'line_height' => esc_html__( 'Line Height', 'pool-services-lite' ),
				'letter_spacing' => esc_html__( 'Letter Spacing', 'pool-services-lite' ),
			)
		);
	}

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script( 'pool-services-lite-ctypo-customize-controls' );
		wp_enqueue_style(  'pool-services-lite-ctypo-customize-controls' );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		// Loop through each of the settings and set up the data for it.
		foreach ( $this->settings as $setting_key => $setting_id ) {

			$this->json[ $setting_key ] = array(
				'link'  => $this->get_link( $setting_key ),
				'value' => $this->value( $setting_key ),
				'label' => isset( $this->l10n[ $setting_key ] ) ? $this->l10n[ $setting_key ] : ''
			);

			if ( 'family' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_families();

			elseif ( 'weight' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_weight_choices();

			elseif ( 'style' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_style_choices();
		}
	}

	/**
	 * Underscore JS template to handle the control's output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function content_template() { ?>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<ul>

		<# if ( data.family && data.family.choices ) { #>

			<li class="typography-font-family">

				<# if ( data.family.label ) { #>
					<span class="customize-control-title">{{ data.family.label }}</span>
				<# } #>

				<select {{{ data.family.link }}}>

					<# _.each( data.family.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.family.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.weight && data.weight.choices ) { #>

			<li class="typography-font-weight">

				<# if ( data.weight.label ) { #>
					<span class="customize-control-title">{{ data.weight.label }}</span>
				<# } #>

				<select {{{ data.weight.link }}}>

					<# _.each( data.weight.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.weight.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.style && data.style.choices ) { #>

			<li class="typography-font-style">

				<# if ( data.style.label ) { #>
					<span class="customize-control-title">{{ data.style.label }}</span>
				<# } #>

				<select {{{ data.style.link }}}>

					<# _.each( data.style.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.style.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.size ) { #>

			<li class="typography-font-size">

				<# if ( data.size.label ) { #>
					<span class="customize-control-title">{{ data.size.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.size.link }}} value="{{ data.size.value }}" />

			</li>
		<# } #>

		<# if ( data.line_height ) { #>

			<li class="typography-line-height">

				<# if ( data.line_height.label ) { #>
					<span class="customize-control-title">{{ data.line_height.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.line_height.link }}} value="{{ data.line_height.value }}" />

			</li>
		<# } #>

		<# if ( data.letter_spacing ) { #>

			<li class="typography-letter-spacing">

				<# if ( data.letter_spacing.label ) { #>
					<span class="customize-control-title">{{ data.letter_spacing.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.letter_spacing.link }}} value="{{ data.letter_spacing.value }}" />

			</li>
		<# } #>

		</ul>
	<?php }

	/**
	 * Returns the available fonts.  Fonts should have available weights, styles, and subsets.
	 *
	 * @todo Integrate with Google fonts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_fonts() { return array(); }

	/**
	 * Returns the available font families.
	 *
	 * @todo Pull families from `get_fonts()`.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	function get_font_families() {

		return array(
			'' => __( 'No Fonts', 'pool-services-lite' ),
        'Abril Fatface' => __( 'Abril Fatface', 'pool-services-lite' ),
        'Acme' => __( 'Acme', 'pool-services-lite' ),
        'Anton' => __( 'Anton', 'pool-services-lite' ),
        'Architects Daughter' => __( 'Architects Daughter', 'pool-services-lite' ),
        'Arimo' => __( 'Arimo', 'pool-services-lite' ),
        'Arsenal' => __( 'Arsenal', 'pool-services-lite' ),
        'Arvo' => __( 'Arvo', 'pool-services-lite' ),
        'Alegreya' => __( 'Alegreya', 'pool-services-lite' ),
        'Alfa Slab One' => __( 'Alfa Slab One', 'pool-services-lite' ),
        'Averia Serif Libre' => __( 'Averia Serif Libre', 'pool-services-lite' ),
        'Bangers' => __( 'Bangers', 'pool-services-lite' ),
        'Boogaloo' => __( 'Boogaloo', 'pool-services-lite' ),
        'Bad Script' => __( 'Bad Script', 'pool-services-lite' ),
        'Bitter' => __( 'Bitter', 'pool-services-lite' ),
        'Bree Serif' => __( 'Bree Serif', 'pool-services-lite' ),
        'BenchNine' => __( 'BenchNine', 'pool-services-lite' ),
        'Cabin' => __( 'Cabin', 'pool-services-lite' ),
        'Cardo' => __( 'Cardo', 'pool-services-lite' ),
        'Courgette' => __( 'Courgette', 'pool-services-lite' ),
        'Cherry Swash' => __( 'Cherry Swash', 'pool-services-lite' ),
        'Cormorant Garamond' => __( 'Cormorant Garamond', 'pool-services-lite' ),
        'Crimson Text' => __( 'Crimson Text', 'pool-services-lite' ),
        'Cuprum' => __( 'Cuprum', 'pool-services-lite' ),
        'Cookie' => __( 'Cookie', 'pool-services-lite' ),
        'Chewy' => __( 'Chewy', 'pool-services-lite' ),
        'Days One' => __( 'Days One', 'pool-services-lite' ),
        'Dosis' => __( 'Dosis', 'pool-services-lite' ),
        'Droid Sans' => __( 'Droid Sans', 'pool-services-lite' ),
        'Economica' => __( 'Economica', 'pool-services-lite' ),
        'Fredoka One' => __( 'Fredoka One', 'pool-services-lite' ),
        'Fjalla One' => __( 'Fjalla One', 'pool-services-lite' ),
        'Francois One' => __( 'Francois One', 'pool-services-lite' ),
        'Frank Ruhl Libre' => __( 'Frank Ruhl Libre', 'pool-services-lite' ),
        'Gloria Hallelujah' => __( 'Gloria Hallelujah', 'pool-services-lite' ),
        'Great Vibes' => __( 'Great Vibes', 'pool-services-lite' ),
        'Handlee' => __( 'Handlee', 'pool-services-lite' ),
        'Hammersmith One' => __( 'Hammersmith One', 'pool-services-lite' ),
        'Inconsolata' => __( 'Inconsolata', 'pool-services-lite' ),
        'Indie Flower' => __( 'Indie Flower', 'pool-services-lite' ),
        'IM Fell English SC' => __( 'IM Fell English SC', 'pool-services-lite' ),
        'Julius Sans One' => __( 'Julius Sans One', 'pool-services-lite' ),
        'Josefin Slab' => __( 'Josefin Slab', 'pool-services-lite' ),
        'Josefin Sans' => __( 'Josefin Sans', 'pool-services-lite' ),
        'Kanit' => __( 'Kanit', 'pool-services-lite' ),
        'Lobster' => __( 'Lobster', 'pool-services-lite' ),
        'Lato' => __( 'Lato', 'pool-services-lite' ),
        'Lora' => __( 'Lora', 'pool-services-lite' ),
        'Libre Baskerville' => __( 'Libre Baskerville', 'pool-services-lite' ),
        'Lobster Two' => __( 'Lobster Two', 'pool-services-lite' ),
        'Merriweather' => __( 'Merriweather', 'pool-services-lite' ),
        'Monda' => __( 'Monda', 'pool-services-lite' ),
        'Montserrat' => __( 'Montserrat', 'pool-services-lite' ),
        'Muli' => __( 'Muli', 'pool-services-lite' ),
        'Marck Script' => __( 'Marck Script', 'pool-services-lite' ),
        'Noto Serif' => __( 'Noto Serif', 'pool-services-lite' ),
        'Open Sans' => __( 'Open Sans', 'pool-services-lite' ),
        'Overpass' => __( 'Overpass', 'pool-services-lite' ),
        'Overpass Mono' => __( 'Overpass Mono', 'pool-services-lite' ),
        'Oxygen' => __( 'Oxygen', 'pool-services-lite' ),
        'Orbitron' => __( 'Orbitron', 'pool-services-lite' ),
        'Patua One' => __( 'Patua One', 'pool-services-lite' ),
        'Pacifico' => __( 'Pacifico', 'pool-services-lite' ),
        'Padauk' => __( 'Padauk', 'pool-services-lite' ),
        'Playball' => __( 'Playball', 'pool-services-lite' ),
        'Playfair Display' => __( 'Playfair Display', 'pool-services-lite' ),
        'PT Sans' => __( 'PT Sans', 'pool-services-lite' ),
        'Philosopher' => __( 'Philosopher', 'pool-services-lite' ),
        'Permanent Marker' => __( 'Permanent Marker', 'pool-services-lite' ),
        'Poiret One' => __( 'Poiret One', 'pool-services-lite' ),
        'Quicksand' => __( 'Quicksand', 'pool-services-lite' ),
        'Quattrocento Sans' => __( 'Quattrocento Sans', 'pool-services-lite' ),
        'Raleway' => __( 'Raleway', 'pool-services-lite' ),
        'Rubik' => __( 'Rubik', 'pool-services-lite' ),
        'Rokkitt' => __( 'Rokkitt', 'pool-services-lite' ),
        'Russo One' => __( 'Russo One', 'pool-services-lite' ),
        'Righteous' => __( 'Righteous', 'pool-services-lite' ),
        'Slabo' => __( 'Slabo', 'pool-services-lite' ),
        'Source Sans Pro' => __( 'Source Sans Pro', 'pool-services-lite' ),
        'Shadows Into Light Two' => __( 'Shadows Into Light Two', 'pool-services-lite'),
        'Shadows Into Light' => __( 'Shadows Into Light', 'pool-services-lite' ),
        'Sacramento' => __( 'Sacramento', 'pool-services-lite' ),
        'Shrikhand' => __( 'Shrikhand', 'pool-services-lite' ),
        'Tangerine' => __( 'Tangerine', 'pool-services-lite' ),
        'Ubuntu' => __( 'Ubuntu', 'pool-services-lite' ),
        'VT323' => __( 'VT323', 'pool-services-lite' ),
        'Varela Round' => __( 'Varela Round', 'pool-services-lite' ),
        'Vampiro One' => __( 'Vampiro One', 'pool-services-lite' ),
        'Vollkorn' => __( 'Vollkorn', 'pool-services-lite' ),
        'Volkhov' => __( 'Volkhov', 'pool-services-lite' ),
        'Yanone Kaffeesatz' => __( 'Yanone Kaffeesatz', 'pool-services-lite' )
		);
	}

	/**
	 * Returns the available font weights.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_weight_choices() {

		return array(
			'' => esc_html__( 'No Fonts weight', 'pool-services-lite' ),
			'100' => esc_html__( 'Thin',       'pool-services-lite' ),
			'300' => esc_html__( 'Light',      'pool-services-lite' ),
			'400' => esc_html__( 'Normal',     'pool-services-lite' ),
			'500' => esc_html__( 'Medium',     'pool-services-lite' ),
			'700' => esc_html__( 'Bold',       'pool-services-lite' ),
			'900' => esc_html__( 'Ultra Bold', 'pool-services-lite' ),
		);
	}

	/**
	 * Returns the available font styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_style_choices() {

		return array(
			'' => esc_html__( 'No Fonts Style', 'pool-services-lite' ),
			'normal'  => esc_html__( 'Normal', 'pool-services-lite' ),
			'italic'  => esc_html__( 'Italic', 'pool-services-lite' ),
			'oblique' => esc_html__( 'Oblique', 'pool-services-lite' )
		);
	}
}
