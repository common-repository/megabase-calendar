<?php
/** Templating: Copy this file to mytheme/megabase-calendar/views/megacal-compact-events-list.php to override it. */

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	$settings = self::megacal_get_settings();

	if( empty( $response ) ) {
		return;
	}

	/**
	 * Filter Hook: megacal_compact_events_list_events
	 * Filters the events on the compact event list view
	 * 
	 * @param array<Event> The list of Events
	 */
	$events = apply_filters( 'megacal_compact_events_list_events', $response->get_events() );
?>

<style>
	.megacal-events-integration .megacal-list-view .eventsList .simpleBtn.showDetailsLink {
		<?php if( !empty( $settings['megacal_custom_simple_details_btn_color'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_custom_simple_details_btn_color'] ); ?> !important;
			border:none !important;
		<?php endif; ?>
		<?php if( !empty( $settings['megacal_custom_simple_details_btn_text_color'] ) ): ?>
			color: <?php esc_html_e( $settings['megacal_custom_simple_details_btn_text_color'] ); ?> !important;
		<?php endif; ?>
	}
	.megacal-events-integration .megacal-list-view .eventsList .simpleBtn.showDetailsLink:hover {
		<?php if( !empty( $settings['megacal_btn_bg_hovercolor'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_btn_bg_hovercolor'] ); ?> !important;
			border:none !important;
		<?php endif; ?>
		<?php if( !empty( $settings['megacal_custom_simple_details_btn_text_color'] ) ): ?>
			color: <?php esc_html_e( $settings['megacal_custom_simple_details_btn_text_color'] ); ?> !important;
		<?php endif; ?>
	}
	.megacal-events-integration .megacal-list-view .eventsList .simpleBtn.ticketsLink {
		<?php if( !empty( $settings['megacal_tickets_btn_color'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_tickets_btn_color'] ); ?> !important;
			border:none !important;
		<?php endif; ?>
		<?php if( !empty( $settings['megacal_tickets_btn_textcolor'] ) ): ?>
			color: <?php esc_html_e( $settings['megacal_tickets_btn_textcolor'] ); ?> !important;
		<?php endif; ?>
	}
	.megacal-events-integration .megacal-list-view .eventsList .simpleBtn.ticketsLink:hover {
		<?php if( !empty( $settings['megacal_tickets_btn_hovercolor'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_tickets_btn_hovercolor'] ); ?> !important;
			border:none !important;
		<?php endif; ?>
		<?php if( !empty( $settings['megacal_tickets_btn_textcolor'] ) ): ?>
			color: <?php esc_html_e( $settings['megacal_tickets_btn_textcolor'] ); ?> !important;
		<?php endif; ?>
	}

	<?php if( isset( $settings['megacal_invert_colors_dark_mode'] ) && $settings['megacal_invert_colors_dark_mode'] === "true" ): ?>
		.megacal-events-integration.blackBack .megacal-list-view .eventsList .simpleBtn.showDetailsLink,
		.megacal-events-integration.blackBack .megacal-list-view .eventsList .simpleBtn.ticketsLink {
			filter: invert( 100% ) !important;
		}
	<?php endif; ?>
</style>

		<?php if( !empty($events) ): ?>

			<?php foreach($events as $event): ?>

				<?php

					$date = new DateTimeImmutable( $event->get_event_date() );
					include trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-month-label.php';
				
					if( !empty( $event->get_event_date() ) ):

						$event_date = $event->get_event_date();
						$venue = $event->get_venue();
						$venue_name = $this->megacal_get_venue_name( $event );
				?>

						<li id="event-<?php esc_attr_e( $event->get_id() ); ?>" class="rowView">
			
							<div class="rowColumn dateColumn">
								<p class="simpleDate" aria-hidden="true">
									<span><?php echo esc_html( date('D', strtotime( $event_date ) ) ); ?></span>
									<span><?php echo esc_html( date('M', strtotime( $event_date ) ) ); ?></span>
									<span><?php echo esc_html( date('d', strtotime( $event_date ) ) ); ?></span>
									<span class="yearNum"><?php echo esc_html( date('Y', strtotime( $event_date ) ) ); ?></span>
								</p>         		
								<span class="screen-reader-text"><?php esc_html_e( date( 'l, F d, Y', strtotime( $event_date ) ) ); ?></span>
							</div>

							<div class="rowColumn venueColumn titleColumn">
								<h3 class="simpleTitle">
									<a href="<?php echo esc_url( trailingslashit( $this->get_event_detail_url( $event->get_id() ) ) ); ?>" title="View Details for <?php esc_attr_e( $event->get_title() ); ?>">
										<?php esc_html_e( $event->get_title() ); ?><?php if( !empty( $venue_name ) ): ?> at <?php esc_html_e( $venue_name ); ?><?php endif; ?>
									</a>
								</h3>
							</div>
								
							<div class="rowColumn detailsColumn">
								<?php if( !empty( $venue ) ): ?>
									<?php $venue_address = $venue->get_location(); ?>
									<?php if( !empty( $venue_address ) ): ?>
										<p>
											<?php esc_html_e( $venue_address ); ?>
										</p>
									<?php endif; ?>
								<?php endif; ?>
									
								<p>
									<?php esc_html_e( $this->megacal_get_event_time_string( $event ) ); ?> 
									
									<?php if( !empty( $event->get_price_details() ) ): ?>
										<br /><?php esc_html_e( $event->get_price_details() ); ?>
									<?php endif; ?>
								</p>
							</div>
							
							<div class="rowColumn categoryColumn">
								<?php 
									/** 
									 * Filter Hook: megacal_compact_events_list_hidden_categories
									 * Allows you to modify the categories that are hidden on the Compact Event list 
									 * 
									 * @param array $categories The hidden categories - Default: array( 'Default' )
									 */
									$hidden_categories = apply_filters( 
										'megacal_compact_events_list_hidden_categories', 
										array( MEGACAL_DEFAULT_CATEGORY_NAME ) 
									);
								?>
								<?php if( !in_array( $event->get_event_category()->get_name(), $hidden_categories ) ): ?>
									<p class="event-category event-category-<?php esc_attr_e( $event->get_event_category()->get_id() ); ?>"><?php esc_html_e( $event->get_event_category()->get_name() ); ?></p>
								<?php endif; ?>
							</div>

							<div class="rowColumn buttonsColumn">

								<a href="<?php echo esc_url( trailingslashit( $this->get_event_detail_url( $event->get_id() ) ) ); ?>" 
									class="simpleBtn showDetailsLink"
									title="View Details for <?php esc_attr_e( $event->get_title() ); ?>" 
				                    >View Event</a>

								<?php if( !empty( $event->get_ticket_url() ) ): ?>

				                 	<a href="<?php echo esc_url( $event->get_ticket_url(), array( 'http', 'https' ) ); ?>" class="simpleBtn ticketsLink" target="_blank" title="More information at <?php echo esc_url( $event->get_ticket_url(), array( 'http', 'https' ) ); ?>">
										<?php esc_html_e( $settings['megacal_event_url_label'] ); ?>
									</a>
				                 	
				             	<?php endif; ?>
				             	
				             	<?php if( !empty( $event->get_facebook_url() ) ): ?>        
									
									<a href="<?php echo esc_url( $event->get_facebook_url(), array( 'http', 'https' ) ); ?>" class="simpleBtn btn fbLinkWide" title="RSVP on Facebook" target="_blank"><i class="fui-facebook" aria-hidden="true"></i>RSVP</a>
								
								<?php endif; ?>

							</div>

						</li>

						<?php 

					endif; 
				?>

			<?php endforeach; ?>
			
			<?php include trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-list-total-pages.php'; ?>

		<?php else: ?>

			<?php
				if( !empty( $start_date ) )  {
					$date = new DateTimeImmutable( $start_date );
					include trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-month-label.php';
				}
			?>

			<li id="event-none" class="summaryContent listEvent listItem cf">
				<p><?php echo esc_attr($settings['megacal_no_event_msg']); ?></p>
			</li>
		<?php endif; ?>

<?php
