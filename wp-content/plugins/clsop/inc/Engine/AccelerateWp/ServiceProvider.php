<?php
/**
 * Source file was changed on the Tue Sep 6 16:23:37 2022 +0200
 */

/**
 * Copyright (с) Cloud Linux GmbH & Cloud Linux Software, Inc 2010-2023 All Rights Reserved
 */

namespace WP_Rocket\Engine\AccelerateWp;

use WP_Rocket\Dependencies\League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Service provider for AccelerateWP
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
		'awp_sentry',
		'awp_subscriber',
	];

	/**
	 * Registers items with the container
	 *
	 * @return void
	 */
	public function register() {
		$this->getContainer()->share( 'awp_sentry', Sentry::class );

		$this->getContainer()->share( 'awp_subscriber', Subscriber::class )
			->addArgument( $this->getContainer()->get( 'awp_sentry' ) );
	}
}
