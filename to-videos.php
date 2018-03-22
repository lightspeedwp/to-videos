<?php
/*
 * Plugin Name:	Tour Operator Videos
 * Plugin URI:	https://www.lsdev.biz/product/tour-operator-videos/
 * Description:	With the Videos extension installed you’re able to display videos on all of your Tour Operator related post types. Whether you want to show a walk-through video of an accommodation or a highlights reel of a tour or destination, the videos extension takes care of all your video needs.
 * Author:		LightSpeed
 * Version: 	1.2
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
define( 'LSX_TO_VIDEOS_VER', '1.2' );

/* ======================= Below is the Plugin Class init ========================= */

require_once( LSX_TO_VIDEOS_PATH . '/classes/class-to-videos.php' );
