<?php
/**
 * LSX_TO_Videos
 *
 * @package   LSX_TO_Videos
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2018 LightSpeedDevelopment
 */
if ( ! class_exists( 'LSX_TO_Videos' ) ) {

	/**
	 * Main plugin class.
	 *
	 * @package LSX_TO_Videos
	 * @author  LightSpeed
	 */
	class LSX_TO_Videos {

		/** @var string */
		public $plugin_slug = 'to-videos';

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'init',array( $this, 'load_plugin_textdomain' ) );

			// Make TO last plugin to load
			add_action( 'activated_plugin', array( $this, 'activated_plugin' ) );

			require_once( LSX_TO_VIDEOS_PATH . '/classes/class-to-videos-admin.php' );
			require_once( LSX_TO_VIDEOS_PATH . '/includes/template-tags.php' );

			// flush_rewrite_rules()
			register_activation_hook( LSX_TO_VIDEOS_CORE, array( $this, 'register_activation_hook' ) );
			add_action( 'admin_init', array( $this, 'register_activation_hook_check' ) );
		}

		/**
		 * Load the plugin text domain for translation.
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'to-videos', false, basename( LSX_TO_VIDEOS_PATH ) . '/languages' );
		}

		/**
		 * Make TO last plugin to load.
		 */
		public function activated_plugin() {
			if ( $plugins = get_option( 'active_plugins' ) ) {
				$search = preg_grep( '/.*\/tour-operator\.php/', $plugins );
				$key = array_search( $search, $plugins );

				if ( is_array( $search ) && count( $search ) ) {
					foreach ( $search as $key => $path ) {
						array_splice( $plugins, $key, 1 );
						array_push( $plugins, $path );
						update_option( 'active_plugins', $plugins );
					}
				}
			}
		}

		/**
		 * On plugin activation
		 */
		public function register_activation_hook() {
			if ( ! is_network_admin() && ! isset( $_GET['activate-multi'] ) ) {
				set_transient( '_tour_operators_videos_flush_rewrite_rules', 1, 30 );
			}
		}

		/**
		 * On plugin activation (check)
		 */
		public function register_activation_hook_check() {
			if ( ! get_transient( '_tour_operators_videos_flush_rewrite_rules' ) ) {
				return;
			}

			delete_transient( '_tour_operators_videos_flush_rewrite_rules' );
			flush_rewrite_rules();
		}

	}

	new LSX_TO_Videos();
}
