<?php
/**
 * Source file was changed on the Fri Nov 24 13:30:07 2023 +0100
 * License section template.
 *
 * @since 3.0
 *
 * @param array {
 *     Section arguments.
 *
 *     @type string $id    Page section identifier.
 *     @type string $title Page section title.
 * }
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="wpr-sectionHeader">
	<h2 id="<?php echo esc_attr( $data['id'] ); ?>" class="wpr-title1 wpr-icon-important"><?php echo esc_html( $data['title'] ); ?></h2>
	<div class="wpr-sectionHeader-title wpr-title3">
		<?php
		/*
		// Temporary off
		esc_html_e( 'AccelerateWP was not able to automatically validate your license.', 'rocket' );
		*/
		?>
	</div>
	<div class="wpr-sectionHeader-description">
		<?php
		// Translators: %1$s = tutorial URL, %2$s = support URL.

		/*
		// Temporary off
		printf(
			// translators: %1$s = tutorial URL, %2$s = support URL.
			esc_html__( 'Follow this %1$s, or contact %2$s to get the engine started.', 'rocket' ),
			sprintf(
				// translators: %1$s = <a href=", %2$s =  tutorial href,  %3$s =  " target="_blank">,  %4$s =  </a>.
				esc_html__( '%1$s%2$s%3$stutorial%4$s', 'rocket' ),
				'<a href="',
				esc_url( __( 'https://docs.cloudlinux.com/article/100-resolving-problems-with-license-validation/?utm_source=wp_plugin&utm_medium=cloudlinux_site_optimization_plugin', 'rocket' ) ),
				'" target="_blank">',
				'</a>'
			),
			sprintf(
				// translators: %1$s = <a href=", %2$s =  support href,  %3$s =  " target="_blank">,  %4$s =  </a>.
				esc_html__( '%1$s%2$s%3$ssupport%4$s', 'rocket' ),
				'<a href="',
				rocket_get_external_url( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Dynamic content is properly escaped in the view.
					'support',
					[
						'utm_source' => 'wp_plugin',
						'utm_medium' => 'wp_rocket',
					]
				),
				'" target="_blank">',
				'</a>'
			)
		);
		*/
		?>
	</div>
</div><br>

<div class="wpr-fieldsContainer">
	<div class="wpr-fieldsContainer-fieldset wpr-fieldsContainer-fieldset--split">
		<?php $this->render_settings_sections( $data['id'] ); ?>
	</div>
</div>
