<?php
/**
 * Include admin styles
 */
$uteam_version = defined( 'UTEAM_VERSION' ) ? UTEAM_VERSION : '1.0.5'; // Define version number
function uteam_admin_styles( $screen ) {
    // if( 'wp_uteam_page_uteamsettings' != $screen ){
    //     return;
    // }
    global $uteam_version; // Include global variable

    wp_enqueue_style( 'wp_ultimate_team_jquery_ui', plugins_url('/assets/css/jquery-ui.css', __FILE__), array(), $uteam_version, 'all' );
    wp_enqueue_style( 'wp_ultimate_team_main_admin', plugins_url('/assets/css/admin.css', __FILE__), array(), $uteam_version, 'all' );
    wp_enqueue_style( 'wp-ultimate-team-admin-font-awesome', plugins_url('/assets/css/all.min.css', __FILE__), array(), $uteam_version, 'all' );
    
}
add_action( 'admin_enqueue_scripts', 'uteam_admin_styles' );

/**
 * Include admin scripts
 */
function uteam_admin_script( $screen ){
    global $uteam_version; // Include global variable

    wp_enqueue_style( 'wp-color-picker' );
    
    if (!is_plugin_active('wp_ultimate_team_pro/wp_ultimate_team_pro.php')) {
        wp_enqueue_script( 'uteam-main', plugins_url('/assets/js/admin.js', __FILE__) , array( 'jquery', 'jquery-ui-tabs', 'wp-color-picker' ),  $uteam_version, true );
    }
    
}
add_action( 'admin_enqueue_scripts', 'uteam_admin_script' );

