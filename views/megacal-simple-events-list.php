<?php
/** Templating: Copy this file to mytheme/megabase-calendar/views/megacal-simple-events-list.php to override it. */

use MegaCal\Client\MegaCalClient;

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directlya

	if( empty( $response ) ) {
		return;
	}

	/**
	 * Filter Hook: megacal_simple_events_list_events
	 * Filters the events on the simple event list view
	 * 
	 * @param array<Event> The list of Events
	 */
	$events = apply_filters( 'megacal_simple_events_list_events', $response->get_events() );
?>

<style>
	.megaSimpleList .megaSimpleEvent .rightEventContent .megaDetails .megaEventLinks a.megaEventButton {
		<?php if( !empty( $settings['megacal_custom_simple_details_btn_color'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_custom_simple_details_btn_color'] ); ?> !important;
		<?php endif; ?>
		<?php if( !empty( $settings['megacal_custom_simple_details_btn_text_color'] ) ): ?>
			color: <?php esc_html_e( $settings['megacal_custom_simple_details_btn_text_color'] ); ?> !important;
		<?php endif; ?>
	}
	.megaSimpleList .megaSimpleEvent .rightEventContent .megaDetails .megaEventLinks a.megaEventButton.megaExternalLink {
		<?php if( !empty( $settings['megacal_tickets_btn_color'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_tickets_btn_color'] ); ?> !important;
		<?php endif; ?>
		<?php if( !empty( $settings['megacal_tickets_btn_textcolor'] ) ): ?>
			color: <?php esc_html_e( $settings['megacal_tickets_btn_textcolor'] ); ?> !important;
		<?php endif; ?>
	}
	.megaSimpleList .megaSimpleEvent .rightEventContent .megaDetails .megaEventLinks a.megaEventButton.megaExternalLink:hover {
		<?php if( !empty( $settings['megacal_tickets_btn_hovercolor'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_tickets_btn_hovercolor'] ); ?> !important;
		<?php endif; ?>
		<?php if( !empty( $settings['megacal_tickets_btn_textcolor'] ) ): ?>
			color: <?php esc_html_e( $settings['megacal_tickets_btn_textcolor'] ); ?> !important;
		<?php endif; ?>
	}
	<?php if( isset( $settings['megacal_invert_colors_dark_mode'] ) && $settings['megacal_invert_colors_dark_mode'] === "true" ): ?>
		.blackBack .megaSimpleList .megaSimpleEvent .rightEventContent .megaDetails .megaEventLinks a.megaEventButton,
		.blackBack .megaSimpleList .megaSimpleEvent .rightEventContent .megaDetails .megaEventLinks a.megaEventButton.megaExternalLink {
			filter: invert( 100% ) !important;
		}
	<?php endif; ?>
</style>

<?php if( !empty( $events ) && !( $events instanceof WP_Error ) ): ?>	
	
	<div class="customList megaSimpleList megaEvents">
	
		<?php
			$settings = MegabaseCalendar::megacal_get_settings();
			$event_detail_path = $this->get_event_detail_url();
		?>
	
		<?php foreach( $events as $event ): ?>
	
			<?php 
				$date = new DateTimeImmutable( $event->get_event_date() );
				include trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-month-label.php';
			?>
	
			<div class="megaSimpleEvent">

				<p class="screen-reader-text"><?php esc_html_e( date( 'l, F d, Y', strtotime( $event->get_event_date() ) ) ); ?></p>

				<div class="leftDate" style="background:url('<?php esc_html_e( $event->get_image_url_square() ); ?>') no-repeat center center; background-size:cover;" aria-hidden="true">

					<div class="megaDateRegion dateMask">

						<h3 class="megaDate" title="<?php echo esc_attr( date('D M d, Y', strtotime( $event->get_event_date() ) ) ); ?>">
							<span class="monthName dayNameAbb">
								<?php esc_html_e( date( 'D', strtotime( $event->get_event_date() ) ) ) ; ?>
							</span>

							<span class="monthName">
								<?php esc_html_e( date( 'M', strtotime( $event->get_event_date() ) ) ); ?>
							</span>

							<span class="dayNum">
								<?php esc_html_e(  date( 'd', strtotime( $event->get_event_date() ) ) ); ?>
							</span>

							<span class="yearNum">
								<?php esc_html_e( date( 'Y', strtotime( $event->get_event_date() ) ) ); ?>
							</span>
						</h3>

					</div>		

				</div>						

				<div class="rightEventContent">
	
					<div class="megaDetails">
						<div class="megaEventTitle">
							<?php 
								/**
								 * Filter Hook: megacal_simple_events_list_heading
								 * Filters the heading text on the Event Detail page
								 * 
								 * @param string $heading The heading text
								 * @param Event $event The event
								 */
								$event_heading = apply_filters( 'megacal_simple_events_list_heading', $event->get_title(), $event ); 
							?>
							<h3><?php esc_html_e( $event_heading ); ?></h3>
						</div>

						<div class="megaMeta">
	
							<?php 
							/* Time */
							if( 
								!empty( $event->get_start_time() ) 
								|| !empty( $event->get_end_time() ) 
							): ?>
								<p class="eventTimep">
							<?php endif; ?>
								
								<?php 
									/**
									 * Filter Hook: megacal_simple_events_list_time_fmt
									 * Filters the time format on the Simple Events list, allowing for custom time formatting if needed
									 * 
									 * @param string $fmt The time format - Default g:ia OR H:i, depending on your settings 
									 */
									$fmt = apply_filters( 'megacal_simple_events_list_time_fmt', $this->megacal_get_time_fmt() ); 
								?>
	
								<?php if( !empty( $event->get_start_time() ) ): ?>
									<?php esc_html_e( date( $fmt, strtotime( $event->get_start_time() ) ) ); ?> 
								<?php endif; ?>
								
								<?php if( !empty( $event->get_end_time() ) ): ?>
									- <?php esc_html_e( date( $fmt, strtotime( $event->get_end_time() ) ) ); ?>
								<?php endif; ?>
	
							<?php if( 
								!empty( $event->get_start_time() ) 
								|| !empty( $event->get_end_time() ) 
							): ?>
								</p>
							<?php endif; ?>
	
							<?php 
								$venue = $event->get_venue();
								$venue_name = $this->megacal_get_venue_name( $event );
							?>
							<?php if( !empty( $venue_name ) ): ?>
								<p class="venueTitle">
									<?php esc_html_e( $venue_name ); ?>
								</p>

								<?php if( !empty( $venue ) ): ?>
									<p class="venueLocation">
										<?php esc_html_e( $venue->get_location() ); ?>
									</p>
								<?php endif; ?>		
							<?php endif; ?>

							<?php 
								/** 
								 * Filter Hook: megacal_simple_events_list_hidden_categories
								 * Allows you to modify the categories that are hidden on the Simple Event list 
								 * 
								 * @param array $categories The hidden categories - Default: array( 'Default' )
								 */
								$hidden_categories = apply_filters( 
									'megacal_simple_events_list_hidden_categories', 
									array( MEGACAL_DEFAULT_CATEGORY_NAME ) 
								);
							?>
							<?php if( !in_array( $event->get_event_category()->get_name(), $hidden_categories ) ): ?>
								<p class="event-category event-category-<?php esc_attr_e( $event->get_event_category()->get_id() ); ?>"><?php esc_html_e( $event->get_event_category()->get_name() ); ?></p>
							<?php endif; ?>

						</div>

						<div class="megaEventLinks">
							<a href="<?php echo esc_url( trailingslashit( $event_detail_path ) . $event->get_id() ); ?>" class="megaEventButton megaDetailLink" title="View details for <?php esc_attr_e( $event->get_title() ); ?>">Details <span aria-hidden="true">&raquo;</span></a>

							<?php if( !empty( $event->get_ticket_url() ) ): ?>
								<a href="<?php esc_attr_e( $event->get_ticket_url() ); ?>" class="megaEventButton megaExternalLink" title="More information at <?php esc_attr_e( $event->get_ticket_url() ); ?>" target="_blank"><?php esc_html_e( $settings['megacal_event_url_label'] ); ?> <span aria-hidden="true">&#8599;</span></a>
							<?php endif; ?>
						</div>

					</div>
				</div>										
			</div>
	
		<?php endforeach; ?>

		<?php include trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-list-total-pages.php'; ?>
	
	</div>

<?php else: ?>

	<?php
		if( !empty( $start_date ) )  {
			$date = new DateTimeImmutable( $start_date );
			include trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-month-label.php';
		}
	?>

	<li id="event-none" class="summaryContent listEvent listItem cf">
		<p><?php echo esc_html( $settings['megacal_no_event_msg'] ); ?></p>

		<?php if( $events instanceof WP_Error && is_user_logged_in() ): ?>
			<p><?php echo esc_html( $events->get_error_message() ); ?></p>	
		<?php endif; ?>
	</li>
<?php endif; ?>

<?php
