<?php
/**
 * Include public styles
 */
function uteam_public_styles() {
    $uteam_version = defined( 'UTEAM_VERSION' ) ? UTEAM_VERSION : '1.0.5'; // Define version number

    $settings_options = get_option( 'uteam_settings_option' );

    $plugin_bootstrap_library_disable = isset( $settings_options['plugin_bootstrap_library_disable'] ) ? 'bootstrap_css' : null;
    if ( 'bootstrap_css' != $plugin_bootstrap_library_disable ) {
        wp_enqueue_style( 'wp_ultimate_team_grid', plugins_url( '/assets/css/wp_ultimate_team_grid.css', __FILE__ ), array(), $uteam_version, 'all' );
    }

    $plugin_fontawesome_library_disable = isset( $settings_options['plugin_fontawesome_library_disable'] ) ? 'fontawesome' : null;
    if ( $plugin_fontawesome_library_disable != 'fontawesome' ) :
        wp_enqueue_style( 'wp_ultimate_font_awesome_important', plugins_url( '/assets/css/all.min.css', __FILE__ ), array(), $uteam_version, 'all' );
    endif;

    $plugin_owl_library_disable = isset( $settings_options['plugin_owl_library_disable'] ) ? 'owl' : null;
    if ( $plugin_owl_library_disable != 'owl' ) :
        wp_enqueue_style( 'wp_ultimate_owl-carousel', plugins_url( '/assets/css/owl.carousel.css', __FILE__ ), array(), $uteam_version, 'all' );
    endif;

    $plugin_flex_library_disable = isset( $settings_options['plugin_flex_library_disable'] ) ? 'flex' : null;
    if ( $plugin_flex_library_disable != 'flex' ) :
        wp_enqueue_style( 'wp_ultimate_flexslider', plugins_url( '/assets/css/flexslider.css', __FILE__ ), array(), $uteam_version, 'all' );
    endif;

    wp_enqueue_style( 'wp_ultimate_team_main', plugins_url( '/assets/css/wp_ultimate_team.css', __FILE__ ), array(), $uteam_version, 'all' );
}

add_action( 'wp_enqueue_scripts', 'uteam_public_styles' );

/**
 * Include public scripts
 */
function uteam_public_scripts() {
    $uteam_version = defined( 'UTEAM_VERSION' ) ? UTEAM_VERSION : '1.0.5'; // Define version number

    wp_enqueue_script( 'uteam-isotope', plugins_url( '/assets/js/isotope.pkgd.min.js', __FILE__ ), array( 'jquery', 'imagesloaded' ), $uteam_version, true );
    wp_enqueue_script( 'owl-carousel', plugins_url( '/assets/js/owl.carousel.min.js', __FILE__ ), array( 'jquery' ), $uteam_version, true );
    wp_enqueue_script( 'jquery-flexslider', plugins_url( '/assets/js/jquery.flexslider-min.js', __FILE__ ), array( 'jquery' ), $uteam_version, true );
    wp_enqueue_script( 'uteam-main', plugins_url( '/assets/js/main.js', __FILE__ ), array( 'jquery' ), $uteam_version, true );
    wp_enqueue_script( 'parallax-effect', plugins_url( '/assets/js/parallax.effect.min.js', __FILE__ ), array( 'jquery' ), $uteam_version, true );
}

add_action( 'wp_enqueue_scripts', 'uteam_public_scripts' );
