<?php 
/** Templating: Copy this file to mytheme/megabase-calendar/includes/partials/part-popup-content.php to override it. */

	if( !defined( 'ABSPATH' ) ) 
		die( 'Not Allowed' );
?>
<?php /*  mega-tooltip */ ?>
<div class="megacal-event-popup-inner cardFloater">

	<div class="thumbTile">
	
		<div class="eventFrame">
			<?php $event_img = $event->get_image_url_square(); ?>

			<?php if(!empty( $event_img )): ?>
				
				<div class="frameImagePic">
					<img src="<?php echo ( esc_url( $event_img ) ); ?>" alt="<?php esc_html_e( $event->get_title() ); ?> Graphic" class="cardEventImage" />	
				</div>

			<?php else:  ?>							

				<div class="frameImagePic frameDefaultPic">
					<img src="<?php echo esc_url( megacal_get_default_event_image_path() ); ?>" alt="<?php esc_html_e( $event->get_title() ); ?> Graphic not available" class="cardEventImage cardDefaultPic" />
				</div>

			<?php endif; ?>		

			<div class="tileData">

				<h3><?php esc_html_e( $event->get_title() ); ?></h3>
				
				<div class="megacal-event-details">			

					<div class="megaMeta">

						<?php 
						/* Time */
						if( 
							!empty( $event->get_start_time() ) 
							|| !empty( $event->get_end_time() ) 
						): ?>
							<p class="eventTimep">
						<?php endif; ?>

						<?php $fmt = $this->megacal_get_time_fmt(); ?>
							<?php if( !empty( $event->get_start_time() ) ): ?>
								<i class="fas fa-clock"></i><span class="eventTime"><?php esc_html_e( date( $fmt, strtotime( $event->get_start_time() ) ) ); ?> </span>
							<?php endif; ?>
							
							<?php if( !empty( $event->get_end_time() ) ): ?>
								<span class="eventTime">- <?php esc_html_e( date( $fmt, strtotime( $event->get_end_time() ) ) ); ?></span>
							<?php endif; ?>

						<?php if( 
							!empty( $event->get_start_time() ) 
							|| !empty( $event->get_end_time() ) 
						): ?>
							</p>
						<?php endif; ?>

						
						<?php
						/* Venue */
						$venue = $event->get_venue();
						$venue_name = $this->megacal_get_venue_name( $event );
						$venue_location = !empty( $venue ) ? $venue->get_location() : '';

						if( !empty( $venue_name ) ): ?>
							<p class="venueTitle">
								<i class="fas fa-map-marker-alt"></i><?php esc_html_e( $venue_name ); ?>

								<?php if( !empty( $venue_location ) ): ?>
									- 
									<?php esc_html_e( $venue_location ); ?>
								<?php endif; ?>
							</p>
						<?php endif; ?>					
						

						<?php 
						/* Description */
						if( !empty( $event->get_description() ) ): ?>
							<p class="eventTimep">
								<?php 
								$content = $event->get_description();
								echo esc_html( $this->trim_content( $content ) );
								?>							
							</p>
						<?php endif; ?>

						
					</div>			
					
				</div>

			</div>

		</div>
	
		
	
	</div>

</div>