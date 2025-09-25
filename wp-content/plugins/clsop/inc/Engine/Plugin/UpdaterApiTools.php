<?php
/**
 * Source file was changed on the Fri Nov 24 13:30:07 2023 +0100
 */

namespace WP_Rocket\Engine\Plugin;

use WP_Rocket\Logger\Logger;

/**
 * Trait for the plugin updater.
 */
trait UpdaterApiTools {
	/**
	 * Get a \WP_Error object to use when the request to WP Rocket’s server fails.
	 *
	 * @param  mixed $data Error data to pass along the \WP_Error object.
	 * @return \WP_Error
	 */
	protected function get_request_error( $data = [] ) {
		if ( ! is_array( $data ) ) {
			$data = [
				'response' => $data,
			];
		}

		Logger::debug(
			'Error when reading INI-file.',
			array_merge( [ 'Plugin Information' ], $data )
		);

		return new \WP_Error(
			$this->request_error_id,
			sprintf(
				// translators: %s is an URL.
				__( 'An unexpected error occurred. Something may be wrong with external or this server&#8217;s configuration.'/* If you continue to have problems, <a href="%s">contact support</a>.*/, 'rocket' ),
				$this->get_support_url()
			),
			$data
		);
	}

	/**
	 * Get support URL.
	 *
	 * @return string
	 */
	protected function get_support_url() {
		return rocket_get_external_url(
			'support',
			[
				'utm_source' => 'wp_plugin',
				'utm_medium' => 'wp_rocket',
			]
		);
	}

	/**
	 * Get a plugin slug, given its full path.
	 *
	 * @param  string $plugin_file Full path to the plugin.
	 * @return string
	 */
	protected function get_plugin_slug( $plugin_file ) {
		$plugin_file = trim( $plugin_file, '/' );
		$plugin_slug = explode( '/', $plugin_file );
		$plugin_slug = end( $plugin_slug );
		$plugin_slug = str_replace( '.php', '', $plugin_slug );

		return $plugin_slug;
	}
}
