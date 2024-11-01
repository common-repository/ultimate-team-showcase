<?php
/**
 * Plugin Name:       Ultimate Team Showcase
 * Plugin URI:        https://plugins.rstheme.com/wp-ultimate-team/
 * Description:       The Ultimate Team Showcase WordPress plugin for showing team members profile in grid, slider, Isotope, and lightbox layouts easily using by shortcodes.
 * Version:           1.0.6
 * Author:            rstheme
 * Author URI:        https://rstheme.com/
 * License:           GPLv3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       ultimate-team-showcase
 * Domain Path:       /languages
 * Requires PHP:      7.0.0
 * Requires at least: 5.5
 */


/**
 * Defines constants
 */
define( 'UTEAM_VERSION', '1.0.6' );
define( 'UTEAM_FILE', __FILE__ );
define( 'UTEAM_PATH', plugin_dir_path( __FILE__ ) );
define( 'UTEAM_URL', plugins_url( '/', __FILE__ ) );
define( 'UTEAM_BASENAME', plugin_basename( __FILE__ ) );

$dir = plugin_dir_path( __FILE__ );

/**
 * Load Textdomain
 */
function uteam_load_textdomain(){
	load_plugin_textdomain('ultimate-team-showcase', false, dirname(__FILE__)."/languages");
}
add_action('plugins_loaded', 'uteam_load_textdomain');

/**
 * Include styles and scripts for public part
 */
include_once UTEAM_PATH . 'public/uteam-public.php';

/**
 * Include styles and scripts for admin part
 */
include_once UTEAM_PATH . 'admin/uteam-admin.php';

/**
 * Include file for admin
 */
include_once  UTEAM_PATH.'includes/template.php';
include_once  UTEAM_PATH.'includes/shortcode_generate.php';
include_once  UTEAM_PATH.'includes/metabox/custom/init.php';
include_once  UTEAM_PATH.'includes/metabox/wp_ultimate_team_metabox.php';
include_once  UTEAM_PATH.'includes/ElementBlock/elementor_widgets.php';
include_once  UTEAM_PATH.'admin/settings/plugin-settings.php';


/**
 * Link to settings page from plugins admin page
 *
 */
function uteam_add_action_links ( $links ) {
    $setting_links = array(
        '<a href="' . admin_url( 'edit.php?post_type=wp_uteam&page=uteamsettings' ) . '">'.esc_html( "Settings", 'ultimate-team-showcase' ).'</a>',
    );
    return array_merge( $links, $setting_links );
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'uteam_add_action_links' );

/**
 * Link to settings page from plugins admin page
 *
 */
function uteam_add_action_pro_links ( $links ) {
    $links['go_pro'] = sprintf( '<a target="_blank" href="%1$s" style="color: #0052da; font-weight: 700;">Go Pro</a>', 'https://rstheme.com/product/ultimate-team-showcase-wordpress-plugin/' );
    return $links;
}
// add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'uteam_add_action_pro_links' );

/**
 * Redirect to settings page after plugin activate
 *
 */

function uteam_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( esc_url_raw(wp_safe_redirect( admin_url( 'edit.php?post_type=wp_uteam&page=uteamsettings' ) )) );
    }
}
// add_action( 'activated_plugin', 'uteam_activation_redirect' );


register_activation_hook(__FILE__, 'uteam_plugin_activate');

function uteam_plugin_activate() {
    // Perform necessary checks and setup

    // Check for PHP version
    if (version_compare(PHP_VERSION, '7.0', '<')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die('This plugin requires PHP version 7.0 or higher.');
    }

    

    // Log successful activation
    if (!function_exists('write_log')) {
        function write_log($log) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }
    write_log('Plugin activated successfully.');
}
