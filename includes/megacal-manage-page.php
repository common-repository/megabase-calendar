<?php

use MegaCal\Client\ApiException;
use MegaCal\Client\MegaCalAPI;

if( !defined( 'ABSPATH' ) ) die( 'Not Allowed' );

$categories = $this->megacal_get_category_list( array( 'published' => true ) );
$settings = self::megacal_get_settings();
?>


<div id="megacal-manage-events" class="megacal-settings-page wrap">

	<h1>
		MegaCalendar Events
		<?php if( $settings['megacal_events_list_page'] ): ?>
			<a href="<?php echo esc_url( get_permalink( intval( $settings['megacal_events_list_page'] ) ) ); ?>" class="button button-primary" target="_blank">
				View Calendar
			</a>
		<?php endif; ?>
	</h1>

	<?php include( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-notice-container.php' ); ?>

	<?php wp_nonce_field( '_megacal_get_event_upsert_nonce', '_megacal_get_event_upsert_nonce' ); ?>

	<div id="eventManageMask" class="hidden"></div>

	<div id="save-event-wrap">
		<?php require( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-event-form.php' ); ?>
	</div>

	<div id="megacal-calendar-outer" class="postbox">

		<?php wp_nonce_field( '_megacal_fetch_events_nonce', '_megacal_fetch_events_nonce' ); ?>

		<?php if( !empty( $categories ) ): ?>

			<aside id="megacal-manage-filters">

				<h3 class="mega-collapsable-toggle" tabindex="0" role="button" aria-pressed="false"><i class="icon-chevron-right" aria-hidden="true"></i>Filter Events</h3>

	            <div class="optionDropdown mega-collapsable collapsed">                
	            	<form id="megacal-manage-filter-form">

						<div class="megacal-filter-section postbox">

							<h4>Event Category</h4>

							<?php foreach( $categories as $cat ): ?>
								<label for="megacal-filter-cat-<?php esc_attr_e( $cat->get_id() ); ?>" class="megacal-filter-cat">
									<input type="checkbox" id="megacal-filter-cat-<?php esc_attr_e( $cat->get_id() ); ?>" name="megacalFilterCategories" class="megacal-filter-cat-btn" value="<?php esc_attr_e( $cat->get_id() ); ?>" />	
									<?php esc_html_e( $cat->get_name() ); ?>
								</label>
							<?php endforeach; ?>

						</div>

					</form>
	            </div>

        	</aside>

		<?php endif; ?>

		<div id="megacal-manage-calendar"></div>
	</div>
	<?php $this->megacal_display_admin_links(); ?>

	<?php 
		/**
		 * Filter Hook: megacal_update_nag
		 * Allows you to turn off the update nag on the Manage Events screen
		 * 
		 * @param bool $update_nag True/False - Default: True  
		 */
		$update_nag = apply_filters( 'megacal_update_nag', true );
	?>
	<?php if( !$this->megacal_is_pro_account() && true === $update_nag ): ?>
		
		<div class="update-nag">
			<p><b>Want to receive events from other calendars? <a href="<?php echo esc_url( MEGACAL_UPGRADE_URL ); ?>">Upgrade Now</a></b></p>
		</div>

	<?php endif; ?>

</div>