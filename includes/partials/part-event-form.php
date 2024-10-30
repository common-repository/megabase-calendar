<?php
//Add Event Admin Side Form

	if( !defined( 'ABSPATH' ) ) die( 'Not Allowed' );

	$settings = self::megacal_get_settings();

	$venues = $this->megacal_get_venue_list( array( 'published' => true ) );
	$categories = $this->megacal_get_my_category_list( array( 'published' => true ) );

	$event_id = !empty( $event ) ? $event->get_id() : '';
	$event_title = !empty( $event ) ? $event->get_title() : '';
	$event_date = !empty( $event ) ? date( 'm/d/Y', strtotime( $event->get_event_date() ) ) : '';
	$start_time = !empty( $event ) ? $event->get_start_time() : '';
	$end_time = !empty( $event ) ? $event->get_end_time() : '';
	$all_day = !empty( $event ) && empty( $start_time ) && empty( $end_time );

	$event_img = !empty( $event ) ? $event->get_image_url() : '';

	$venue = !empty( $event ) ? $event->get_venue() : '';
	$venue_id = !empty( $venue ) ? $venue->get_id() : '';
	$venue_name = !empty( $venue ) ? $venue->get_name() : '';
	$venue_location = !empty( $venue ) ? $venue->get_location() : '';

	$category = !empty( $event ) ? $event->get_event_category() : '';
	$category_id = !empty( $category ) ? $category->get_id() : '';

	$organizers = !empty( $event ) ? $event->get_organizer() : '';
	$facebook_url = !empty( $event ) ? $event->get_facebook_url() : '';
	$ticket_url = !empty( $event ) ? $event->get_ticket_url() : '';
	$event_price = !empty( $event ) ? $event->get_price_details() : '';
	$description = !empty( $event ) ? $event->get_description() : '';
	$private_notes = !empty( $event ) ? $event->get_private_note() : '';
	$published = !empty( $event ) ? $event->get_published() : true;

	$tagged_users = !empty( $event ) ? $event->get_tagged_users() : '';
	$recurrence = !empty( $event ) ? $event->get_recurrence() : '';

	$default_user_handles = !empty( $settings['megacal_default_handles'] ) ? $settings['megacal_default_handles'] : array();
	$tagged_user_handles = array();
	$invalid_users = array();

	if( !empty( $tagged_users ) ) {

		foreach( $tagged_users as $user ) {
	
			$handle = $user->get_handle();
			$tagged_user_handles[$handle] = $handle;
			
			if( $user->get_valid() === false ) {
				$invalid_users[] = $user->get_handle();
			}

		}

	}

?>

	<button class="button button-secondary megaCancel megacal-button-cancel-edit-event">Cancel</button>

	<form id="megacal-event-form" method="POST">

		<h2 class="megaMetaBoxTitle">Add New Event</h2>

		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content" style="position: relative;">
		
					<div class="megaMetaBox postbox">

						<div class="inside">

							<?php wp_nonce_field( '_megacal_event_upsert_nonce', '_megacal_event_upsert_nonce' ); ?>

							<input type="hidden" id="megacal-event-id" name="eventId" value="<?php esc_attr_e( $event_id ); ?>" />

							<table class="form-table" role="presentation">
								<tbody>
									<tr class="megacal_row">
										<th scope="row">
											<div class="labelColumn">
												<label for="megacal-event-title"><span class="red">*</span>Event Title</label>
											</div>
										</th>
										<td>
											<input type="text" id="megacal-event-title" class="required" name="eventTitle" value="<?php esc_attr_e( $event_title ); ?>" placeholder="" />
										</td>
									</tr>


									<tr class="megacal_row">
										<th scope="row">
											<div class="labelColumn">
												<label for="megacal-event-date"><span class="red">*</span>Date</label>
											</div>
										</th>
										<td>
											<input type="text" id="megacal-event-date" class="required" name="eventDate" value="<?php esc_attr_e( $event_date ); ?>" placeholder="mm/dd/yyyy" />
											<?php wp_nonce_field( '_megacal_event_recurrence_nonce', '_megacal_event_recurrence_nonce' ); ?>
											<input type="hidden" id="megacal-event-recurrence-details" name="eventRecurrenceDetails" value="<?php esc_attr_e( json_encode( $recurrence ) ); ?>" />
										</td>
									</tr>
									
									<tr class="megacal_row">
										<th scope="row">
											<div class="labelColumn">
												<label>Recurrence Details</label>
											</div>	
										</th>

										<td>
											<div class="megacal-event-recurrence-container"></div>
										</td>
									</tr>

									<tr class="megacal_row">
										<th scope="row">
											<div class="labelColumn">
												<label for="megacal-event-start-time">Start Time</label>
											</div>
										</th>
										<td>
											<input type="text" id="megacal-event-start-time" name="eventStartTime" autocomplete="off" class="timepicker" value="<?php esc_attr_e( $start_time ); ?>" placeholder="x:xx am" />
										</td>
									</tr>
									<tr class="megacal_row">
										<th scope="row">
											<div class="labelColumn">
												<label for="megacal-event-end-time">End Time</label>
											</div>
										</th>
										<td>
											<input type="text" id="megacal-event-end-time" name="eventEndTime" autocomplete="off" class="timepicker" value="<?php esc_attr_e( $end_time ); ?>" placeholder="x:xx pm" />
										</td>
									</tr>


									<tr class="megacal_row">
										<th scope="row">
											<div class="labelColumn">
												<label for="megacal-event-img">Image</label>
											</div>
										</th>
										<td>
											<img id="megacal-img-preview" class="<?php echo empty( $event_img ) ? 'hidden' : ''; ?>" src="<?php echo esc_url( $event_img ); ?>" width="250" />
											<button id="megacal-upload-event-img" class="button button-secondary <?php echo !empty( $event_img ) ? 'hidden' : ''; ?>">Upload</button>
											<button id="megacal-remove-event-img" class="button button-delete <?php echo empty( $event_img ) ? 'hidden' : ''; ?>">Remove</button>
											<input type="hidden" id="megacal-event-img" name="eventImg" value="<?php echo esc_url( $event_img ); ?>" />
										</td>
									</tr>


									<tr class="megacal_row">
										<th scope="row">
											<div class="labelColumn">
												<label for="megacal-event-venue-name">Venue</label>
											</div>
										</th>
										<td>
											<div>
												<input type="hidden" id="megacal-event-venue-id" name="eventVenueId" value="<?php esc_attr_e( $venue_id ); ?>" />
												<select id="megacal-event-venue-name" name="eventVenueName">
													<option value=""></option>
													<?php if( !empty( $venues ) ): ?>
														<?php foreach( $venues as $venue ): ?>
															<?php $selected = $venue_id === $venue->get_id() ? 'selected' : ''; ?>
															<option value="<?php esc_attr_e( $venue->get_id() ); ?>" data-location="<?php esc_attr_e( $venue->get_location() ); ?>" <?php esc_attr_e( $selected ); ?>>
																<?php esc_html_e( $venue->get_name() ); ?>
															</option>
														<?php endforeach; ?>		
													<?php endif; ?>
												</select>
												<p class="small">Location Name</p>
											</div>

											<div>
												<input type="text" id="megacal-event-venue-location" name="eventVenueLocation" value="<?php esc_attr_e( $venue_location ); ?>" <?php echo !empty( $venue_id ) ? 'disabled' : ''; ?> placeholder="Address, Room, etc" />
												<p class="small">Address / Location Line 2</p>
											</div>
										</td>
									</tr>

									<tr class="megacal_row">
										<th scope="row">
											<div class="labelColumn">
												<label for="megacal-event-category-name">Event Category</label>
											</div>
										</th>

										<td>
											<div>
												<input type="hidden" id="megacal-event-category-id" name="eventCatId" value="<?php esc_attr_e( $category_id ); ?>" />
												<select id="megacal-event-category-name" name="eventCatName">
													<option value=""></option>
													<?php if( !empty( $categories ) ): ?>
														<?php foreach( $categories as $cat ): ?>
															<?php $selected = $category_id === $cat->get_id() ? 'selected' : ''; ?>
															<option value="<?php esc_attr_e( $cat->get_id() ); ?>" <?php esc_attr_e( $selected ); ?>>
																<?php esc_html_e( $cat->get_name() ); ?>
															</option>	
														<?php endforeach; ?>
													<?php endif; ?>
												</select>
											</div>
										</td>

									</tr>

									<tr class="megacal_row">
										<th scope="row">
											<div class="labelColumn">
												<label for="megacal-event-description">Description</label>
											</div>
										</th>
										<td>
											<?php wp_editor( $description, 'megacal-event-description' ); ?>
										</td>
									</tr>


									
									<tr class="megacal_row">
										<th scope="row">
											<div class="labelColumn">
												<label for="megacal-event-facebook-url">Facebook URL</label>
											</div>
										</th>
										<td>
											<input type="text" id="megacal-event-facebook-url" name="eventFacebookUrl" value="<?php esc_attr_e( $facebook_url ); ?>" />
										</td>
									</tr>


									<tr class="megacal_row">
										<th scope="row">
											<div class="labelColumn">
												<label for="megacal-event-ticket-url">Event or Ticket Link</label>
											</div>
										</th>
										<td>
											<input type="text" id="megacal-event-ticket-url" name="eventTicketUrl" value="<?php esc_attr_e( $ticket_url ); ?>" />
										</td>
									</tr>


									<tr class="megacal_row">
										<th scope="row">
											<div class="labelColumn">
												<label for="megacal-event-price">Ticket Prices</label>
											</div>
										</th>
										<td>
											<input type="text" id="megacal-event-price" name="eventPrice" value="<?php esc_attr_e( $event_price ); ?>" placeholder="$xx GA / $xx Balcony" />
										</td>
									</tr>


									<tr class="megacal_row">
										<th scope="row">
											<div class="labelColumn">
												<label for="megacal-event-organizer">Organizers/Sponsors</label>
											</div>
										</th>
										<td>
											<?php wp_editor( $organizers, 'megacal-event-organizer', array( 
												'tinymce' => true,
												'textarea_rows' => 10, 
											) ); ?>
										</td>
									</tr>


									<tr class="megacal_row">
										<th scope="row">
											<div class="labelColumn">
												<label for="megacal-event-private-notes">Private Notes</label>
											</div>
											<p class="small rightAligned">Only visible to your account here, not public anywhere.</p>
										</th>
										<td>
											<?php wp_editor( $private_notes, 'megacal-event-private-notes' ); ?>
										</td>
									</tr>
									
								</tbody>
							</table>

						</div>

					</div>
				</div>

				<div id="postbox-container-1" class="postbox-container">
					<div id="side-sortables" class="meta-box-sortables ui-sortable" style="">

						<div id="otherPublish" class="postbox">
							<h2 class="">Send to</h2>

							<div class="inside">
														
								<!-- <h3><label for="megacal-event-tagged-users">Send to other calendars</label></h3> -->

								<?php $saved_accounts_str = !empty( $settings['megacal_frequent_handles'] ) ? $settings['megacal_frequent_handles'] : ''; ?>
								<?php if( !empty( $saved_accounts_str ) ): ?>
									<h4>Saved calendars</h4>
									<?php 

										$saved_accounts = explode( ',', $saved_accounts_str );
										foreach( $saved_accounts as $handle ) {

											$handle = trim( $handle );

											if( empty( $handle ) ) {
												continue;
											}

											$field_id = 'megacal-handle-cb-' . $handle;

											$tagged = in_array( $handle, $tagged_user_handles ) && !empty( $event );
											$default = in_array( $handle, $default_user_handles ) && empty( $event );
											$checked =  $tagged || $default ? 'checked' : '';

											if( $tagged ) {
												unset( $tagged_user_handles[$handle] );
											}

											printf( 
												'<p><label for="%s"><input type="checkbox" id="%s" value="%s" name="eventTaggedUsers" %s /><span class="screen-reader-text">Send to</span> %s</label></p>', 
												esc_attr( $field_id ), 
												esc_attr( $field_id ), 
												esc_attr( $handle ), 
												esc_attr( $checked ),
												esc_html( $handle ) 
											);

										}
									?>
								<?php endif; ?>																

								<h4>Other calendars</h4>
								<p class="small">Tag pro account handles - recipient can approve all your events or one at a time.</p>
								<p>
									<label for="megacal-event-tagged-users" class="screen-reader-text">Add a comma-separated list of user handles to share this event with</label>
									<input type="text" id="megacal-event-tagged-users" name="eventTaggedUsersExtra" value="<?php esc_attr_e( implode( ', ', $tagged_user_handles ) ); ?>" placeholder="" />
								</p>
								
								<?php if( !empty( $invalid_users ) ): ?>
									<?php $invalid_user_count = count( $invalid_users ); ?>
									<p class="megacal-warning">You have tagged <?php esc_html_e( $invalid_user_count ); ?> invalid <?php echo $invalid_user_count > 1 ? 'users' : 'user'; ?>: <?php esc_html_e( implode( ', ', $invalid_users ) ); ?></p>
								<?php endif; ?>
								
							</div>
						</div>

						<?php if( !empty( $event ) ): ?>
							<div id="previewBox" class="postbox">
								<h2>View Event</h2>
								<div class="inside">
									<p>View this Event as site visitors will see it.</p>
									<a href="<?php echo esc_url( $this->get_event_detail_url( $event_id ) ); ?>" class="button button-secondary" target="_blank">View</a>
								</div>	
							</div>
						<?php endif; ?>

						<div id="submitdiv" class="postbox">

							<h2 class="">Save</h2>
							<div class="inside">
								<div class="misc-pub-section">

									<div class="publishOption">
										<?php $checked = $published ? 'checked' : ''; ?>
										<label for="megacal-pubilsh-event">
											<input type="checkbox" name="publishEvent" id="megacal-pubilsh-event" <?php esc_attr_e( $checked ); ?> />
											Publish This Event
											<i class="icon-bullhorn" aria-hidden="true"></i>
										</label>
										<p class="small">&nbsp;&nbsp;&nbsp;Uncheck to save as a draft</p>
									</div>

									<button type="submit" class="button button-primary megacal-button-save-event" disabled>Save</button>
									<button type="button" class="button button-secondary megacal-button-cancel-edit-event">Cancel</button>

									<?php if( !empty( $event ) ): ?>
										<?php wp_nonce_field( '_megacal_delete_event_nonce', '_megacal_delete_event_nonce' ); ?>
										<button type="button" class="button megacal-button-delete-event">Delete</button>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<?php if( !empty( $recurrence ) ): ?>
			<div id="megacal-change-type-modal">

				<h2>I would like to...</h2>

				<ul id="megacal-change-type-options">
					<li><label for="megacal-change-type-this">
						<input type="radio" id="megacal-change-type-this" name="eventChangeType" value="UPDATE_THIS" checked />
						Update only this event
					</label></li>
					
					<li><label for="megacal-change-type-this-onward">
						<input type="radio" id="megacal-change-type-this-onward" name="eventChangeType" value="UPDATE_THIS_ONWARD" />
						Update this and future events
					</label></li>

					<li><label for="megacal-change-type-all">
						<input type="radio" id="megacal-change-type-all" name="eventChangeType" value="UPDATE_ALL" />
						Update all events
					</label></li>
				</ul>

				<ul id="megacal-delete-type-options">
					<li><label for="megacal-delete-type-this">
						<input type="radio" id="megacal-delete-type-this" name="eventChangeType" value="DELETE_THIS" />
						Delete only this event
					</label></li>
					
					<li><label for="megacal-delete-type-this-onward">
						<input type="radio" id="megacal-delete-type-this-onward" name="eventChangeType" value="DELETE_THIS_ONWARD" />
						Delete this and future events
					</label></li>

					<li><label for="megacal-delete-type-all">
						<input type="radio" id="megacal-delete-type-all" name="eventChangeType" value="DELETE_ALL" />
						Delete all events
					</label></li>
				</ul>

				<button type="button" class="button button-secondary megacal-button-cancel-save-delete">Cancel</button>
				<button type="submit" class="button button-primary megacal-button-save-event">Save</button>
				<button type="button" class="button megacal-button-delete-event">Delete</button>

			</div>
			<div id="megacal-admin-mask"></div>
		<?php endif; ?>

	</form>	
