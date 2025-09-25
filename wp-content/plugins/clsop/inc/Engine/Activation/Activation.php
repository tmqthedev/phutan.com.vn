<?php
/**
 * Source file was changed on the Wed Jan 31 14:00:07 2024 +0100
 */

namespace WP_Rocket\Engine\Activation;

use WP_Rocket\Admin\Options;
use WP_Rocket\Dependencies\League\Container\Container;
use WP_Rocket\Event_Management\Event_Manager;
use WP_Rocket\ThirdParty\Hostings\HostResolver;

/**
 * Plugin activation controller
 *
 * @since 3.6.3
 */
class Activation {
	/**
	 * Aliases in the container for each class that needs to call its activate method
	 *
	 * @var array
	 */
	private static $activators = [
		'advanced_cache',
		'capabilities_manager',
		'wp_cache',
		'action_scheduler_check',
		'preload_activation',
	];

	/**
	 * Performs these actions during the plugin activation
	 *
	 * @return void
	 */
	public static function activate_plugin() {
		$container = new Container();

		$container->add( 'template_path', WP_ROCKET_PATH . 'views' );
		$options_api = new Options( 'wp_rocket_' );
		$container->add( 'options_api', $options_api );
		$container->addServiceProvider( \WP_Rocket\ServiceProvider\Options::class );
		$container->addServiceProvider( \WP_Rocket\Engine\Preload\Activation\ServiceProvider::class );
		$container->addServiceProvider( ServiceProvider::class );
		$container->addServiceProvider( \WP_Rocket\ThirdParty\Hostings\ServiceProvider::class );

		$host_type = HostResolver::get_host_service();

		if ( ! empty( $host_type ) ) {
			array_unshift( self::$activators, $host_type );
		}

		foreach ( self::$activators as $activator ) {
			$container->get( $activator );
		}

		// Last constants.
		define( 'WP_ROCKET_PLUGIN_NAME', 'AccelerateWP' );
		define( 'WP_ROCKET_PLUGIN_SLUG', sanitize_key( WP_ROCKET_PLUGIN_NAME ) );

		if ( defined( 'SUNRISE' ) && SUNRISE === 'on' && function_exists( 'domain_mapping_siteurl' ) ) {
			require WP_ROCKET_INC_PATH . 'domain-mapping.php';
		}

		require WP_ROCKET_FUNCTIONS_PATH . 'options.php';
		require WP_ROCKET_FUNCTIONS_PATH . 'formatting.php';
		require WP_ROCKET_FUNCTIONS_PATH . 'i18n.php';
		require WP_ROCKET_FUNCTIONS_PATH . 'htaccess.php';
		require WP_ROCKET_FUNCTIONS_PATH . 'api.php';

		/**
		 * WP Rocket activation.
		 *
		 * @since  3.1.5
		 */
		do_action( 'rocket_activation' );

		if ( rocket_valid_key() ) {
			// Add All WP Rocket rules of the .htaccess file.
			flush_rocket_htaccess();
		}

		// Create the cache folders (wp-rocket & min).
		rocket_init_cache_dir();

		// Create the config folder (wp-rocket-config).
		rocket_init_config_dir();

		/**
		 * Create config file when WP CLI.
		 *
		 * @note CL
		 */
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			require WP_ROCKET_ADMIN_PATH . 'upgrader.php';
			require WP_ROCKET_FUNCTIONS_PATH . 'admin.php';
			rocket_upgrader();
			rocket_generate_config_file();
		}

		// Update customer key & licence.

		/*
		 * Disable license request function
		wp_remote_get(
			WP_ROCKET_WEB_API . 'activate-licence.php',
			[
				'blocking' => false,
			]
		);
		*/

		/**
		 * Fires after WP Rocket is activated
		 */
		do_action( 'rocket_after_activation' );
	}
}
