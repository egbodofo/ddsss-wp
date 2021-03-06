<?php
/**
 * Welcome Screen Class
 */
class bizstart_screen {

	/**
	 * Constructor for the welcome screen
	 */
	public function __construct() {

		/* activation notice */
		add_action( 'load-themes.php', array( $this, 'bizstart_activation_admin_notice' ) );

	}
	
	public function bizstart_activation_admin_notice() {
		global $pagenow;

		if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'bizstart_admin_notice' ), 99 );
		}
	}

	/**
	 * Display an admin notice linking to the welcome screen
	 * @sfunctionse 1.8.2.4
	 */
	public function bizstart_admin_notice() {
		?>			
		<div class="updated notice is-dismissible construction-zone-notice">
			<h1><?php
			$theme_info = wp_get_theme();
			printf( esc_html__('Thanks for installing  %1$s , You rock!', 'bizstart'), esc_html( $theme_info->Name ), esc_html( $theme_info->Version ) ); ?>
			</h1>
			<p><?php echo sprintf( esc_html__("Welcome! Thank you for choosing Bizstart WordPress theme. To take full advantage of the features this theme has to offer visit our %1\$s welcome page %2\$s.", "bizstart"), '<a href="' . esc_url( admin_url( 'themes.php?page=Bizstart_zone_upgrade' ) ) . '">', '</a>' ); ?></p>
			<p class="note1"><a href="<?php echo esc_url( admin_url( 'themes.php?page=Bizstart_zone_upgrade' ) ); ?>" class="button button-blue-secondary button_info" style="text-decoration: none;"><?php echo esc_html__('Get started with Bizstart','bizstart'); ?></a> <a href="http://freehtmldesigns.com/themes/?product=bizstart-premium-wordpress-theme" target="_blank" class="button button-blue-secondary button_info" style="text-decoration: none;"><?php echo esc_html__('Buy Premium','bizstart'); ?></a></p>
		</div>
		<?php
	}
	
}

$GLOBALS['bizstart_screen'] = new bizstart_screen();