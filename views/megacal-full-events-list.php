<?php
/** Templating: Copy this file to mytheme/megabase-calendar/views/megacal-full-events-list.php to override it. */

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	if( empty( $response ) ) {
		return;
	}

	/**
	 * Filter Hook: megacal_full_events_list_events
	 * Filters the events on the full event list view
	 * 
	 * @param array<Event> The list of Events
	 */
	$events = apply_filters( 'megacal_full_events_list_events', $response->get_events() );
?>

<style>
	.megacal-events-integration .megacal-list-view .eventsList .controlbar > li a.TicketLink {
		<?php if( !empty( $settings['megacal_tickets_btn_color'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_tickets_btn_color'] ); ?> !important;
		<?php endif; ?>
		<?php if( !empty( $settings['megacal_tickets_btn_textcolor'] ) ): ?>
			color: <?php esc_html_e( $settings['megacal_tickets_btn_textcolor'] ); ?> !important;
		<?php endif; ?>
	}
	.megacal-events-integration .megacal-list-view .eventsList .controlbar > li a.TicketLink:hover {
		<?php if( !empty( $settings['megacal_tickets_btn_hovercolor'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_tickets_btn_hovercolor'] ); ?> !important;
		<?php endif; ?>		
	}
	<?php if( isset( $settings['megacal_invert_colors_dark_mode'] ) && $settings['megacal_invert_colors_dark_mode'] === "true" ): ?>
		.megacal-events-integration.blackBack .megacal-list-view .eventsList .controlbar > li a.TicketLink,
		.megacal-events-integration.blackBack .megacal-list-view .eventsList .controlbar > li a.TicketLink:hover {
			filter: invert( 100% ) !important;
		}
	<?php endif; ?>
</style>

<?php if( !empty( $events ) && !( $events instanceof WP_Error ) ): ?>
	<?php foreach($events as $event): ?>

		<?php

			$date = new DateTimeImmutable( $event->get_event_date() );

			include trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-month-label.php';

			$venue = $event->get_venue();
			$venue_name = $this->megacal_get_venue_name( $event );

			if( !empty( $event->get_event_date() ) ):
				
				$event_date = $event->get_event_date();
				?>

				<li id="event-<?php esc_attr_e( $event->get_id() ); ?>" class="summaryContent listEvent listItem cf">

					<p class="screen-reader-text"><?php esc_html_e( date( 'l, F d, Y', strtotime( $event_date ) ) ); ?></p>

					<?php if( !empty( $event->get_description() ) ): ?>
						<?php $description_class = ( $descrip ) ? 'expanded' : 'collapsed'; ?> 
						<button class="summaryToggle <?php esc_attr_e( $description_class ); ?>" title="Click to expand event details for <?php esc_attr_e( $event->get_title() ); ?>">
							<i class="fui-plus-circle" aria-hidden="true"></i>
						</button>
					<?php endif; ?>

					<div class="leftDate" aria-hidden="true">
						<div class="megaDateRegion">
							<h3 class="megaDate" title="<?php echo esc_html( date('D M d, Y', strtotime( $event_date ) ) ); ?>">
								<span class="monthName dayNameAbb"><?php echo esc_html( date('D', strtotime( $event_date ) ) ); ?></span>
								<span class="monthName"><?php echo esc_html( date('M', strtotime( $event_date ) ) ); ?></span>
								<span class="dayNum"><?php echo esc_html( date('d', strtotime( $event_date ) ) ); ?></span>
								<span class="yearNum"><?php echo esc_html( date('Y', strtotime( $event_date ) ) ); ?></span>
							</h3>
						</div>
					</div>

					<div class="eventPosterArea">
						<?php $ticket_link = !empty( $event->get_ticket_url() ) ? esc_url( $event->get_ticket_url(), array( 'http', 'https' ) ) : false; ?>

						<?php if( !empty( $ticket_link ) ): ?>
							<a href="<?php echo esc_url( $ticket_link, array( 'http', 'https' ) ); ?>" target="_blank" title="View ticket information at <?php esc_attr_e( $ticket_link ); ?>">
						<?php endif; ?>

						<!-- If a Poster or Event Thumbnail Exists -->
						<?php if( !empty( $event->get_image_url_square() ) ): ?>
								<?php $thumbnail_src = $event->get_image_url_square(); ?>
								<img src="<?php echo esc_url( $thumbnail_src ); ?>" class="eventImg imgShadow alignleft" alt="An image representing <?php esc_attr_e( $event->get_title() ); ?>" />
						<?php else: ?>
							<div>
								<img src="<?php echo esc_url( megacal_get_default_event_image_path(), array( 'http', 'https' ) ); ?>" class="artistReplace alignleft defaultPic" alt="An image representing <?php esc_attr_e( $event->get_title() ); ?>" />
							</div>
						<?php endif; ?>

						<?php if( !empty( $ticket_link ) ): ?>
							</a>
						<?php endif; ?>
					</div>

					<div class="listingBody">
						<h3 class="titleofevent">
							<a href="<?php echo esc_url( trailingslashit( $this->get_event_detail_url( $event->get_id() ) ) ); ?>" class="showDetailsLink" title="View Details">
								<?php 
									if( !empty( $event->get_title() ) ) { 
										esc_html_e( $event->get_title() ); 
									} 
								?>
								<?php if( !empty( $venue_name ) ): ?><span class="atText">at</span> <?php esc_html_e( $venue_name ); ?><?php endif; ?>
							</a>
						</h3><!-- /.titleofevent -->

						
						<div class="eventInfoArea">
							<div class="eventInfoWide">
								<?php if( !empty( $venue ) ): ?><p class="megacal-venue-location"><?php esc_html_e( $venue->get_location() ); ?></p><?php endif; ?>

								<p class="eventLogistics">
									<?php esc_html_e( $this->megacal_get_event_time_string( $event ) ); ?> 
									
									<?php if( !empty( $event->get_price_details() ) ): ?>
										<?php
											/**
											 * Filter Hook: megacal_full_events_list_cost_label
											 * Filters the Cost label on the full Events list
											 * 
											 * @param string $label The label - Default: 'Cost: '
											 */ 
											$cost_label = apply_filters( 'megacal_full_events_list_cost_label', 'Cost: ' ); 

											/**
											 * Filter Hook: megacal_full_events_list_detail_separator
											 * Filters the details separator on the full Events list
											 * 
											 * @param string $separator The separator - Default: '&bull;'
											 */ 
											$separator = apply_filters( 'megacal_full_events_list_detail_separator', '&bull;' );
										?>
										<span class="sep"><?php esc_html_e( $separator ); ?></span> <?php esc_html_e( $cost_label . $event->get_price_details() ); ?>
									<?php endif; ?>
								</p>
								<?php 
									/** 
									 * Filter Hook: megacal_full_events_list_hidden_categories
									 * Allows you to modify the categories that are hidden on the Full Event list 
									 * 
									 * @param array $categories The hidden categories - Default: array( 'Default' )
									 */
									$hidden_categories = apply_filters( 
										'megacal_full_events_list_hidden_categories', 
										array( MEGACAL_DEFAULT_CATEGORY_NAME ) 
									);
								?>
								<?php if( !in_array( $event->get_event_category()->get_name(), $hidden_categories ) ): ?>
									<p class="event-category event-category-<?php esc_attr_e( $event->get_event_category()->get_id() ); ?>"><?php esc_html_e( $event->get_event_category()->get_name() ); ?></p>
								<?php endif; ?>

								<p class="marginBottom">
									<a href="<?php echo esc_url( trailingslashit( $this->get_event_detail_url( $event->get_id() ) ) ); ?>" class="inconViewLink showDetailsLink" title="View Details for <?php esc_attr_e( $event->get_title() ); ?>">View Event</a>
								</p>

								<?php if( !empty( $event->get_description() ) ): ?>
									<div class="fullInfo" <?php if( $descrip == false ): ?>style="display: none;"<?php endif; ?>>
										<div class="eventDescription">
											<?php 						
												/**
												 * Filter Hook: megacal_full_events_list_description_do_shortcode
												 * Allows you to apply do_shortcode to the event description output on the Full Events list.
												 * Enable at your own risk, all shortcodes in the description will be parsed and rendered
												 * 
												 * @param bool $do_shortcode True/False: Apply do_shortcode to the event description - Default: False
												 */
												$do_shortcode = apply_filters( 'megacal_full_events_list_description_do_shortcode', false );
												
												/**
												 * Filter Hook: megacal_full_events_list_description_do_the_content
												 * Allows you to apply the_content to the event description output on the Full Events list. 
												 * Enable at your own risk, all shortcodes in the description will be parsed and rendered. 
												 * Takes precedence over megacal_full_events_list_description_do_shortcode
												 * 
												 * @param bool $do_the_content True/False: Apply the_content to the event description - Default: False
												 */
												$do_the_content = apply_filters( 'megacal_full_events_list_description_do_the_content', false );

												$event_description = $event->get_description();

												if( true === $do_the_content ) {
													$event_description = apply_filters( 'the_content', $event_description );
												} else if( true === $do_shortcode ) {
													$event_description = do_shortcode( $event_description );
												}

												echo $this->megacal_esc_wysiwyg( $event_description );
											?>
										</div>
									</div>
								<?php endif; ?>

								<?php if( !empty( $event->get_organizer() ) ): ?>
									<div class="eventOrganizers">
										<?php 
											/**
											 * Filter Hook: megacal_full_events_list_organizers_do_shortcode
											 * Allows you to apply do_shortcode to the event organizers output on the Full Events list. 
											 * Enable at your own risk, all shortcodes in the organizers will be parsed and rendered
											 * 
											 * @param bool $do_shortcode True/False: Apply do_shortcode to the event organizers - Default: False
											 */
											$do_shortcode = apply_filters( 'megacal_full_events_list_organizers_do_shortcode', false );
											
											/**
											 * Filter Hook: megacal_full_events_list_organizers_do_the_content
											 * Allows you to apply the_content to the event organizers output on the Full Events list. 
											 * Enable at your own risk, all shortcodes in the organizers will be parsed and rendered. 
											 * Takes precedence over megacal_full_events_list_organizers_do_shortcode
											 * 
											 * @param bool $do_the_content True/False: Apply the_content to the event organizers - Default: False
											 */
											$do_the_content = apply_filters( 'megacal_full_events_list_organizers_do_the_content', false );

											$event_organizer = $event->get_organizer();

											if( true === $do_the_content ) {
												$event_organizer = apply_filters( 'the_content', $event_organizer );
											} else if( true === $do_shortcode ) {
												$event_organizer = do_shortcode( $event_organizer );
											}

											echo $this->megacal_esc_wysiwyg( $event->get_organizer() ); 
										?>
									</div>
								<?php endif; ?>

							</div><!-- /.eventInfoWide -->
						</div><!-- /.eventInfoArea -->
					</div><!-- /.listingBody -->

					<?php
						$className = "";

						if($buttons == 'left')
							$className = "moveLeft";
						elseif($buttons == 'right')
							$className = "moveRight";
						elseif($buttons == 'center')
							$className = "moveCenter";
					?>
					<ul class="controlbar cf <?php esc_attr_e( $className ); ?>">
						<?php if( !empty( $event->get_ticket_url() ) ): ?>
							<li>
								<a href="<?php echo esc_url( $event->get_ticket_url(), array( 'http', 'https' ) ); ?>" class="greenBtn TicketLink" target="_blank" title="More information at <?php esc_attr_e( $event->get_ticket_url() ); ?>">
								<span><?php esc_html_e( $settings['megacal_event_url_label'] ); ?></span>
								</a>
							</li>
						<?php endif; ?>

						<?php if( !empty( $event->get_facebook_url() ) ): ?>
							<li>
								<a href="<?php echo esc_url( $event->get_facebook_url(), array( 'http', 'https' ) ); ?>" class="ticketsLink btn fbLinkWide" title="RSVP on Facebook" target="_blank"><i class="fui-facebook"></i>RSVP</a>
							</li>
						<?php endif; ?>
					</ul>
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
		<p><?php echo esc_html( $settings['megacal_no_event_msg'] ); ?></p>

		<?php if( $events instanceof WP_Error && is_user_logged_in() ): ?>
			<p><?php echo esc_html( $events->get_error_message() ); ?></p>	
		<?php endif; ?>
	</li>
<?php endif; ?>

<?php
