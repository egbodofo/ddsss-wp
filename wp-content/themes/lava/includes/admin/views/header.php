<div class="lava-theme-logo">
	<span class="lava-theme-version"><?php printf( esc_html__( 'Version %s', 'lava' ), LAVA_THEME_VERSION ); ?></span>
</div>
<h1><?php printf( esc_html__( 'Welcome to %s!', 'lava' ), LAVA_THEME_NAME ); ?></h1>
<div class="about-text"><?php printf( esc_html__( '%s is now installed and ready to use! Get ready to build something beautiful!', 'lava' ), LAVA_THEME_NAME ); ?></div>
<?php global $submenu;
if ( isset( $submenu['lava_welcome'] ) ) {
    $nav_tabs = $submenu['lava_welcome'];
}
if ( ! empty( $nav_tabs ) ): ?>
    <h2 class="nav-tab-wrapper">
    <?php foreach ( $nav_tabs as $tab ): ?>
	<?php if ( 'customize.php' == $tab[2] ) : ?>
    <a href="<?php echo esc_attr( $tab[2] ); ?>" class="nav-tab <?php if ( isset( $_GET['page'] ) && $_GET['page'] == $tab[2] ) { echo 'nav-tab-active'; }?> "><?php echo esc_html( $tab[0] ); ?></a>
	<?php else : ?>
    <a href="admin.php?page=<?php echo esc_attr( $tab[2] ); ?>" class="nav-tab <?php if ( isset( $_GET['page'] ) && $_GET['page'] == $tab[2] ) { echo 'nav-tab-active'; }?> "><?php echo esc_html( $tab[0] ); ?></a>
	<?php endif; ?>
    <?php endforeach; ?>
    </h2><?php
endif;