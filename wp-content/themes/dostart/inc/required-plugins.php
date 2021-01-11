<?php

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'dostart_register_required_plugins' );


function dostart_register_required_plugins() {

    $plugins = array(

        array(
            'name'     => 'Kirki Customizer Framework',
            'slug'     => 'kirki',
            'required' => false,
        ),

        array(
            'name'     => 'Unlimited Theme Addons',
            'slug'     => 'unlimited-theme-addons',
            'required' => false,
        ),
    );

    $config = array(
        'id'           => 'dostart',
        'default_path' => '',
        'menu'         => 'dostart-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',

    );

    tgmpa( $plugins, $config );
}
