<?php
/**
 * Source file was changed on the Fri Nov 24 13:30:07 2023 +0100
 */

namespace WP_Rocket\Addon;

use WP_Rocket\Addon\ImageOptimization\NoticesHandler as ImageOptimizationNoticesHandler;
use WP_Rocket\Addon\ImageOptimization\RESTWP as ImageOptimizationRestWp;
use WP_Rocket\Addon\ImageOptimization\FileManager as ImageOptimizationFileManager;
use WP_Rocket\Addon\ImageOptimization\FileScanner as ImageOptimizationFileScanner;
use WP_Rocket\Addon\ImageOptimization\Manager as ImageOptimizationManager;
use WP_Rocket\Addon\ImageOptimization\OptionsManager as ImageOptimizationOptionsManager;
use WP_Rocket\Addon\ImageOptimization\FileScannerProcess as ImageOptimizationFileScannerProcess;
use WP_Rocket\Addon\ImageOptimization\QueueWorkerProcess as ImageOptimizationQueueWorkerProcess;
use WP_Rocket\Addon\ImageOptimization\Subscriber as ImageOptimizationSubscriber;
use WP_Rocket\Addon\ImageOptimization\APIClient as ImageOptimizationAPIClient;
use WP_Rocket\Addon\ImageOptimization\Database\Tables\ImageOptimization as ImageOptimizationTable;
use WP_Rocket\Addon\ImageOptimization\Database\Queries\ImageOptimization as ImageOptimizationQuery;

use WP_Rocket\Dependencies\League\Container\ServiceProvider\AbstractServiceProvider;
use WP_Rocket\Admin\Options_Data;
use WP_Rocket\Addon\Sucuri\Subscriber as SucuriSubscriber;
use WP_Rocket\Addon\WebP\AdminSubscriber as WebPAdminSubscriber;
use WP_Rocket\Addon\WebP\Subscriber as WebPSubscriber;

/**
 * Service provider for WP Rocket addons.
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
		'sucuri_subscriber',
		'webp_subscriber',
		'webp_admin_subscriber',
	];

	/**
	 * Registers items with the container.
	 *
	 * @return void
	 */
	public function register() {
		$options = $this->getContainer()->get( 'options' );

		// Sucuri Addon.
		$this->getContainer()->share( 'sucuri_subscriber', SucuriSubscriber::class )
			->addArgument( $options )
			->addTag( 'common_subscriber' );

		$this->getContainer()->share( 'webp_admin_subscriber', WebPAdminSubscriber::class )
			->addArgument( $options )
			->addArgument( $this->getContainer()->get( 'cdn_subscriber' ) )
			->addArgument( $this->getContainer()->get( 'beacon' ) )
			->addTag( 'common_subscriber' );

		$this->getContainer()->share( 'webp_subscriber', WebPSubscriber::class )
			->addArgument( $options )
			->addArgument( $this->getContainer()->get( 'options_api' ) )
			->addArgument( $this->getContainer()->get( 'cdn_subscriber' ) )
			->addTag( 'common_subscriber' );

		// Image Optimization Addon.
		$this->addon_image_optimization( $options );
	}

	/**
	 * Adds Image Optimization Addon into the Container when the addon is enabled.
	 *
	 * @param Options_Data $options Instance of options.
	 *
	 * @since 3.12.6.1_1.1-1
	 */
	protected function addon_image_optimization( Options_Data $options ) {
		$this->provides[] = 'image_optimization_subscriber';
		$this->provides[] = 'image_optimization_query';
		$this->provides[] = 'image_optimization_table';

		$filesystem    = rocket_direct_filesystem();
		$download_path = rocket_get_constant( 'WP_ROCKET_IMAGE_OPTIMIZATION_DOWNLOAD_PATH' );
		$backup_path   = rocket_get_constant( 'WP_ROCKET_IMAGE_OPTIMIZATION_BACKUP_PATH' );
		$upload_config = wp_upload_dir();
		$source_path   = trailingslashit( WP_CONTENT_DIR );
		$source_folder = str_replace( $source_path, '', $upload_config['basedir'] );
		$source_url    = trailingslashit( rtrim( $upload_config['baseurl'], $source_folder ) );

		$this->getContainer()->share( 'image_optimization_table', ImageOptimizationTable::class );

		$table = $this->getContainer()->get( 'image_optimization_table' );

		$this->getContainer()->share( 'image_optimization_query', ImageOptimizationQuery::class );

		$query = $this->getContainer()->get( 'image_optimization_query' );

		$this->getContainer()->share( 'image_optimization_options_manager', ImageOptimizationOptionsManager::class )
			->addArgument( $this->getContainer()->get( 'options_api' ) )
			->addArgument( $options );

		$options_manager = $this->getContainer()->get( 'image_optimization_options_manager' );

		$this->getContainer()->share( 'image_optimization_api_client', ImageOptimizationAPIClient::class )
			->addArgument( $options_manager );

		$api_client = $this->getContainer()->get( 'image_optimization_api_client' );

		$this->getContainer()->share( 'image_optimization_file_manager', ImageOptimizationFileManager::class )
			->addArgument( $download_path )
			->addArgument( $backup_path )
			->addArgument( $filesystem );

		$file_manager = $this->getContainer()->get( 'image_optimization_file_manager' );

		$this->getContainer()->share( 'image_optimization_file_scanner', ImageOptimizationFileScanner::class );

		$this->getContainer()->share( 'image_optimization_file_scanner_process', ImageOptimizationFileScannerProcess::class )
			->addArgument( $this->getContainer()->get( 'image_optimization_file_scanner' ) )
			->addArgument( $backup_path )
			->addArgument( $source_path )
			->addArgument( $source_folder )
			->addArgument( $source_url );

		$this->getContainer()->share( 'image_optimization_queue_worker_process', ImageOptimizationQueueWorkerProcess::class )
			->addArgument( $api_client )
			->addArgument( $query )
			->addArgument( $file_manager )
			->addArgument( $options_manager );

		$this->getContainer()->share( 'image_optimization_rest_wp', ImageOptimizationRestWp::class )
			->addArgument( $options_manager )
			->addArgument( $query );

		$restwp = $this->getContainer()->get( 'image_optimization_rest_wp' );

		$this->getContainer()->share( 'image_optimization_manager', ImageOptimizationManager::class )
			->addArgument( $this->getContainer()->get( 'image_optimization_file_scanner_process' ) )
			->addArgument( $this->getContainer()->get( 'image_optimization_queue_worker_process' ) )
			->addArgument( $query )
			->addArgument( $restwp );

		$this->getContainer()->share( 'image_optimization_notices_handler', ImageOptimizationNoticesHandler::class )
			->addArgument( $options_manager )
			->addArgument( $table )
			->addArgument( $query )
			->addArgument( $api_client )
			->addArgument( $file_manager );

		$this->getContainer()->share( 'image_optimization_subscriber', ImageOptimizationSubscriber::class )
			->addArgument( $options_manager )
			->addArgument( $this->getContainer()->get( 'image_optimization_manager' ) )
			->addArgument( $table )
			->addArgument( $restwp )
			->addArgument( $file_manager )
			->addArgument( $this->getContainer()->get( 'image_optimization_notices_handler' ) )
			->addTag( 'common_subscriber' );
	}
}
