<?php
/*
 * Plugin Name:	Tour Operator Videos
 * Plugin URI:	https://www.lsdev.biz/product/tour-operator-videos/
 * Description:	With the Videos extension installed you’re able to display videos on all of your Tour Operator related post types. Whether you want to show a walk-through video of an accommodation or a highlights reel of a tour or destination, the videos extension takes care of all your video needs.
 * Author:		LightSpeed
 * Version: 	1.1.0
 * Author URI: 	https://www.lsdev.biz/
 * License: 	GPL-3.0
 * Text Domain: to-videos
 * Domain Path: /languages/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'LSX_TO_VIDEOS_PATH', plugin_dir_path( __FILE__ ) );
define( 'LSX_TO_VIDEOS_CORE', __FILE__ );
define( 'LSX_TO_VIDEOS_URL', plugin_dir_url( __FILE__ ) );
define( 'LSX_TO_VIDEOS_VER', '1.1.0' );

/* ======================= The API Classes ========================= */

if ( ! class_exists( 'LSX_API_Manager' ) ) {
	require_once( 'classes/class-lsx-api-manager.php' );
}

/**
 * Runs once when the plugin is activated.
 */
function lsx_to_videos_activate_plugin() {
	$lsx_to_password = get_option( 'lsx_api_instance',false );

	if ( false === $lsx_to_password ) {
		update_option( 'lsx_api_instance',LSX_API_Manager::generatePassword() );
	}
}

register_activation_hook( __FILE__, 'lsx_to_videos_activate_plugin' );

/**
 *	Grabs the email and api key from the TO Videos Settings.
 */
function lsx_to_videos_options_pages_filter( $pages ) {
	$pages[] = 'lsx-to-settings';
	return $pages;
}

add_filter( 'lsx_api_manager_options_pages','lsx_to_videos_options_pages_filter',10,1 );

function lsx_to_videos_api_admin_init() {
	$options = get_option( '_lsx-to_settings',false );

	$data = array(
		'api_key' => '',
		'email' => '',
	);

	if ( false !== $options && isset( $options['api'] ) ) {
		if ( isset( $options['api']['to-videos_api_key'] ) && '' !== $options['api']['to-videos_api_key'] ) {
			$data['api_key'] = $options['api']['to-videos_api_key'];
		}

		if ( isset( $options['api']['to-videos_email'] ) && '' !== $options['api']['to-videos_email'] ) {
			$data['email'] = $options['api']['to-videos_email'];
		}
	}

	$instance = get_option( 'lsx_api_instance', false );

	if ( false === $instance ) {
		$instance = LSX_API_Manager::generatePassword();
	}

	$api_array = array(
		'product_id'	=> 'TO Videos',
		'version'		=> '1.1.0',
		'instance'		=> $instance,
		'email'			=> $data['email'],
		'api_key'		=> $data['api_key'],
		'file'			=> 'to-videos.php',
		'documentation' => 'tour-operator-videos',
	);

	$lsx_to_api_manager = new LSX_API_Manager( $api_array );
}

add_action( 'admin_init', 'lsx_to_videos_api_admin_init' );

/* ======================= Below is the Plugin Class init ========================= */

require_once( LSX_TO_VIDEOS_PATH . '/classes/class-to-videos.php' );
