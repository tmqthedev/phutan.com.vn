<?php
/**
 * Source file was changed on the Fri Nov 24 13:30:07 2023 +0100
 */

namespace WP_Rocket\Engine\HealthCheck;

use WP_Rocket\Dependencies\League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Service Provider for health check subscribers
 *
 * @since 3.6
 */
class ServiceProvider extends AbstractServiceProvider {

	/**
	 * The provides array is a way to let the container
	 * know that a service is provided by this service
	 * provider. Every service that is registered via
	 * this service provider must have an alias added
	 * to this array or it will be ignored.
	 *
	 * @var array
	 */
	protected $provides = [
		'health_check',
		'health_check_page_cache',
		'action_scheduler_check',
	];

	/**
	 * Registers items with the container
	 *
	 * @return void
	 */
	public function register() {
		$this->getContainer()->share( 'health_check', HealthCheck::class )
			->addArgument( $this->getContainer()->get( 'options' ) )
			->addTag( 'admin_subscriber' );
		$this->getContainer()->share( 'health_check_page_cache', PageCache::class )
			->addTag( 'common_subscriber' );
		$this->getContainer()->share( 'action_scheduler_check', ActionSchedulerCheck::class )
			->addTag( 'common_subscriber' );
	}
}
