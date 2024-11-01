<?php

/**
 * The plugin bootstrap file
 *
 * @link              http://krishan19.com/wordpress
 * @since             1.0.0
 * @package           Social_Hub
 *
 * @wordpress-plugin
 * Plugin Name:       Social Hub
 * Plugin URI:        http://krishan19.com/wordpress/
 * Description:       Just another social share plugin. Simple but flexible.
 * Version:           1.1.0
 * Author:            Krishan Fernando
 * Author URI:        http://krishan19.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       social-hub
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('SSSB_FOLDER', dirname(plugin_basename(__FILE__)));
define('SSSB_URL', plugin_dir_url(__FILE__));
define('SSSB_FILE_PATH', plugin_dir_path(__FILE__));
define('SSSB_THEMES_PATH', SSSB_FILE_PATH . '/assets/images/');

// Template Loader
if( ! class_exists( 'Gamajo_Template_Loader' ) ) {
	require SSSB_FILE_PATH . 'class-gamajo-template-loader.php';
}
require SSSB_FILE_PATH . 'class-sssb-template-loader.php';



require_once( SSSB_FILE_PATH . 'class-share-buttons.php' );

//plugin install/uninstall
register_activation_hook(__FILE__, array('SSSB_ShareButtons', 'sssb_activation'));
register_deactivation_hook(__FILE__, array('SSSB_ShareButtons', 'sssb_deactivation'));

add_action('wp_enqueue_scripts', array('SSSB_ShareButtons', 'sssb_add_style_script'));
add_filter('the_content', array('SSSB_ShareButtons', 'sssb_getSocialShare'));
add_action('wp_head', array('SSSB_ShareButtons', 'sssb_get_post_image'), 5);
add_action('admin_enqueue_scripts', array('SSSB_ShareButtons', 'sssb_admin_style_script'));


if( is_admin() ) {
	require_once( SSSB_FILE_PATH . 'class-admin-share-buttons.php' );
    new SSSB_AdminShareButtons();
}


