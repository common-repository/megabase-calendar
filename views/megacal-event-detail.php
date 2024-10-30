<?php
/** Templating: Copy this file to mytheme/megabase-calendar/views/megacal-event-detail.php to override it. */

if ( ! defined( 'ABSPATH' ) ) 
	die( 'Not Allowed' ); // Exit if accessed directly

// Send a 404 if event does not exist or is not published 
// Allow users with the correct capability to preview drafted Events
if( empty( $event ) || ( !$event->get_published() && !current_user_can( MEGACAL_PLUGIN_VISIBILITY_CAP ) ) ) {
	
	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	get_template_part( 404 ); 
	exit();

}

$settings = MegabaseCalendar::megacal_get_settings();

/**
 * Filter Hook: megacal_event_detail_wrapper_classes
 * Filters the classes on the Event Detail wrapper
 * 
 * @param string $classes The classes for the Event Detail wrapper
 */
$wrapper_classes = apply_filters( 'megacal_event_detail_wrapper_classes', 'megacal-event megaEventDetail' );
?>

<?php if( $settings['megacal_events_list_page'] ): ?>
	<a href="<?php echo esc_url( get_permalink( intval( $settings['megacal_events_list_page'] ) ) ); ?>" class="megaBack">
		<span aria-hidden="true">&laquo;</span> Back To Calendar
	</a>
<?php endif; ?>

<style type="text/css">
	.megaEventDetail .controlbar li a.ticketLink {
		<?php if( !empty( $settings['megacal_tickets_btn_color'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_tickets_btn_color'] ); ?> !important;
			border:none !important;
		<?php endif; ?>
		<?php if( !empty( $settings['megacal_tickets_btn_textcolor'] ) ): ?>
			color: <?php esc_html_e( $settings['megacal_tickets_btn_textcolor'] ); ?> !important;
		<?php endif; ?>
	}
	.megaEventDetail .controlbar li a.ticketLink:hover {
		<?php if( !empty( $settings['megacal_tickets_btn_hovercolor'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_tickets_btn_hovercolor'] ); ?> !important;
			border:none !important;
		<?php endif; ?>
		<?php if( !empty( $settings['megacal_tickets_btn_textcolor'] ) ): ?>
			color: <?php esc_html_e( $settings['megacal_tickets_btn_textcolor'] ); ?> !important;
		<?php endif; ?>
	}
</style>

<article id="megacal-event-detail-<?php esc_attr_e( $event->get_id() ); ?>" class="<?php esc_attr_e( $wrapper_classes ); ?>">
	
	<div class="megaContent">

		<?php if( !$event->get_published() ): ?>
			<div class="megaPreviewDraftNotice">
				<h3>UNPUBLISHED EVENT</h3>
				<p>This event is not yet published, only you and other site authors will be able to view this Event until it is published.</p>
			</div>
		<?php endif; ?>

		<?php 
			/**
			 * Filter Hook: megacal_event_detail_event_image
			 * Filters the Event Detail images URL
			 * 
			 * @param string $image_url The image url
			 */
			$event_img = apply_filters( 'megacal_event_detail_event_image', $event->get_image_url_detail() ); 
			if( !empty( $event_img ) ):
		?>
			<div class="megacal-event-image megacalSection">
				<img src="<?php echo esc_url( $event_img ); ?>" alt="An image representing <?php esc_attr_e( $event->get_title() ); ?>" />
			</div>	
		<?php endif; ?>

		<?php 
		/**
		 * Filter Hook: megacal_event_detail_heading
		 * Filters the heading text on the Event Detail page
		 * 
		 * @param string $heading The heading text
		 */
		$event_heading = apply_filters( 'megacal_event_detail_heading', $event->get_title() ) 
		?>
		<h1 class="h2"><?php esc_html_e( $event_heading ); ?></h1>

		<div class="megacalSection">
			<div class="megaMeta megaMetaLeft">
				
				<?php $event_datetime = new DateTimeImmutable( $event->get_event_date() ); ?>

				<div class="megaMetaItem megacalEventDate">
					<h4 class="detailTitle" style="margin-bottom:4px;">Date</h4>

					<p class="eventDatep">
						<?php
							/**
							 * Filter Hook: megacal_event_detail_event_date_fmt
							 * Filters the event date format on Event Detail - Must be a valid PHP date format
							 * 
							 * @param string $fmt The date format - Default: 'l, F jS, Y'
							 */
							$event_date_fmt = apply_filters( 'megacal_event_detail_event_date_fmt', 'l, F jS, Y' );
						?>
						<span class="megacal-event-date">
							<?php esc_html_e( $event_datetime->format( $event_date_fmt ) ); ?>		
						</span> 
					</p>
				</div>

				<?php 
				$venue = $event->get_venue(); 
				$venue_name = $this->megacal_get_venue_name( $event );

				/**
				 * Filter Hook: megacal_event_detail_show_venue
				 * Allows you to hide the Venue from Event Detail, even when a Venue exists 
				 * 
				 * @param bool $show_venue True/False - Default: True
				 */
				$show_venue = apply_filters( 'megacal_event_detail_show_venue', true );
				?>				
				<?php if( !empty( $venue_name ) && true === $show_venue ): ?>					
					<div class="megaMetaItem megacalEventVenue">
						<h4 class="detailTitle" style="margin-bottom:4px;">
							<?php 
								/**
								 * Filter Hook: megacal_event_detail_venue_heading
								 * Filters the heading that appears before the Venue name on Event Detail
								 * 
								 * @param string $heading The heading - Default: 'Location'
								 */
								esc_html_e( apply_filters( 'megacal_event_detail_venue_heading', 'Location' ) ); 
							?>
						</h4>

						<p class="megacal-event-venue-name megaVenue">
							<?php esc_html_e( $venue_name ); ?>
							<?php if( !empty( $venue ) ): ?>
								<br><?php esc_html_e( $venue->get_location() ); ?>
							<?php endif; ?>
						</p>				
					</div>	
				<?php endif; ?>

				<?php if( !empty( $event->get_price_details() ) ): ?>
					<div class="megaMetaItem megacalPrice">
						<h4 class="detailTitle" style="margin-bottom:4px;">
							<?php 
								/**
								 * Filter Hook: megacal_event_detail_cost_label
								 * Filters the heading that appears before the Price section on Event Detail
								 * 
								 * @param string $heading The heading - Default: 'Price'
								 */
								esc_html_e( apply_filters( 'megacal_event_detail_cost_label', 'Price ' ) ); 
							?>
						</h4>

						<p class="megacal-event-cost megaPrice">						
							<?php esc_html_e( $event->get_price_details() ); ?>
						</p>
					</div>
				<?php endif; ?>			

			</div><!-- /.megaMeta -->		

			<div class="megaMeta megaMetaRight">

				<?php 
				/* Time */
				if( 
					!empty( $event->get_start_time() ) 
					|| !empty( $event->get_end_time() ) 
				): ?>					
					<div class="megaMetaItem megacalEventTime">
						<h4 class="detailTitle" style="margin-bottom:4px;">Time</h4>
						
						<p class="eventTimep">

							<?php endif; ?>
							
									<?php 
										/**
										 * Filter Hook: megacal_event_detail_event_time_fmt
										 * Filters the time format on the Event Detail page, allowing for custom time formatting if needed
										 * 
										 * @param string $fmt The time format - Default g:ia OR H:i, depending on your settings 
										 */
										$fmt = apply_filters( 'megacal_event_detail_event_time_fmt', $this->megacal_get_time_fmt() ); 
									?>
									<?php if( !empty( $event->get_start_time() ) ): ?>
										<?php esc_html_e( date( $fmt, strtotime( $event->get_start_time() ) ) ); ?> 
									<?php endif; ?>
									
									<?php if( !empty( $event->get_end_time() ) ): ?>
										- <?php esc_html_e( date( $fmt, strtotime( $event->get_end_time() ) ) ); ?>
									<?php endif; ?>

							<?php 
							if( 
								!empty( $event->get_start_time() ) 
								|| !empty( $event->get_end_time() ) 
							): ?>	
						</p>		
					</div>		
				<?php endif; ?>

				<?php 
				/** 
				 * Filter Hook: megacal_event_detail_hidden_categories
				 * Allows you to modify the categories that are hidden on the Event Detail page
				 * 
				 * @param array $categories The hidden categories - Default: array( 'Default' )
				 */
				$hidden_categories = apply_filters( 'megacal_event_detail_hidden_categories', array( MEGACAL_DEFAULT_CATEGORY_NAME ) );
				?>
				<?php if( !in_array( $event->get_event_category()->get_name(), $hidden_categories ) ): ?>
					<div class="megaMetaItem megacalEventCats">
						<h4 class="detailTitle" style="margin-bottom:4px;">Category</h4>

						<p class="event-category event-category-<?php esc_attr_e( $event->get_event_category()->get_id() ); ?>">
							<?php esc_html_e( $event->get_event_category()->get_name() ); ?>		
						</p>
					</div>
				<?php endif; ?>				

			</div>

		</div>

		<div class="megacalEventLinks megacalSection">

			<?php 
				/**
				 * Filter Hook: megacal_event_detail_control_bar_classes
				 * Filters the classes applied to the control bar on Event Detail
				 * 
				 * @param string $classes The additional classes to apply to the control bar - Default: 'moveCenter' 
				 */
				$classes = apply_filters( 'megacal_event_detail_control_bar_classes', 'moveCenter' ); 
			?>
			<ul class="controlbar cf <?php esc_attr_e( $classes ); ?>">
				<?php if( !empty( $event->get_ticket_url() ) ): ?>
					<li>
						<a href="<?php echo esc_url( $event->get_ticket_url(), array( 'http', 'https' ) ); ?>" class="ticketLink" target="_blank" title="More information at <?php esc_attr_e( $event->get_ticket_url() ); ?>">
							<span><?php esc_html_e( $settings['megacal_event_url_label'] ); ?></span>
						</a>
					</li>
				<?php endif; ?>

				<?php if( !empty( $event->get_facebook_url() ) ): ?>
					<li>
						<a href="<?php echo esc_url( $event->get_facebook_url(), array( 'http', 'https' ) ); ?>" class="ticketsLink btn fbLinkWide" title="RSVP on Facebook" target="_blank"><i class="fui-facebook"></i>RSVP</a>
					</li>
				<?php endif; ?>
			</ul><!-- /.controlbar -->

		</div>

		<div class="megacalEventDetails megacalSection">

			<?php if( !empty( $event->get_description() ) ): ?>
				<div class="megacal-event-description megaDescription">
					<?php 						
						/**
						 * Filter Hook: megacal_event_detail_description_do_shortcode
						 * Allows you to apply do_shortcode to the event description output - Enable at your own risk, all shortcodes in the 
						 * description will be parsed and rendered
						 * 
						 * @param bool $do_shortcode True/False: Apply do_shortcode to the event description - Default: False
						 */
						$do_shortcode = apply_filters( 'megacal_event_detail_description_do_shortcode', false );
						
						/**
						 * Filter Hook: megacal_event_detail_description_do_the_content
						 * Allows you to apply the_content to the event description output - Enable at your own risk, all shortcodes in the 
						 * description will be parsed and rendered. Takes precedence over megacal_event_detail_description_do_shortcode
						 * 
						 * @param bool $do_the_content True/False: Apply the_content to the event description - Default: False
						 */
						$do_the_content = apply_filters( 'megacal_event_detail_description_do_the_content', false );

						$event_description = $event->get_description();

						if( true === $do_the_content ) {
							$event_description = apply_filters( 'the_content', $event_description );
						} else if( true === $do_shortcode ) {
							$event_description = do_shortcode( $event_description );
						}

						echo $this->megacal_esc_wysiwyg( $event_description );
					?>
				</div>
			<?php endif; ?>

			<?php if( !empty( $event->get_organizer() ) ): ?>
				<div class="megacal-event-organizers megaOrganizers">
					<?php 
						/**
						 * Filter Hook: megacal_event_detail_organizers_do_shortcode
						 * Allows you to apply do_shortcode to the event organizers output - Enable at your own risk, all shortcodes in the 
						 * organizers will be parsed and rendered
						 * 
						 * @param bool $do_shortcode True/False: Apply do_shortcode to the event organizers - Default: False
						 */
						$do_shortcode = apply_filters( 'megacal_event_detail_organizers_do_shortcode', false );
						
						/**
						 * Filter Hook: megacal_event_detail_organizers_do_the_content
						 * Allows you to apply the_content to the event organizers output - Enable at your own risk, all shortcodes in the 
						 * organizers will be parsed and rendered. Takes precedence over megacal_event_detail_organizers_do_shortcode
						 * 
						 * @param bool $do_the_content True/False: Apply the_content to the event organizers - Default: False
						 */
						$do_the_content = apply_filters( 'megacal_event_detail_organizers_do_the_content', false );

						$event_organizer = $event->get_organizer();

						if( true === $do_the_content ) {
							echo apply_filters( 'the_content', $this->megacal_esc_wysiwyg( $event_organizer ) );
						} else if( true === $do_shortcode ) {
							echo do_shortcode( $this->megacal_esc_wysiwyg( $event_organizer ) );
						} else {
							echo $this->megacal_esc_wysiwyg( $event_organizer ); 
						}

					?>
				</div>
			<?php endif; ?>

		</div>

		

	</div>

</article>
