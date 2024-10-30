<?php 
/** Templating: Copy this file to mytheme/megabase-calendar/views/megacal-events-sc-output.php to override it. */

if( !defined( 'ABSPATH' ) ) die( 'Not Allowed' );

if( $connected ) : ?>
	<?php 
		//Set/Validate shortcode atts
		
		$megacal_plugin = MegabaseCalendar::get_instance();
		$settings = MegabaseCalendar::megacal_get_settings();

		$default_style = $settings['megacal_default_style'];

		$themeAtt = !empty( $atts['theme'] ) ? $megacal_plugin->megacal_strip_unicode( $atts['theme'] ) : 'light';
		$theme = ($themeAtt == 'dark') ? 'blackBack' : 'lightBack';
		$descrip = !empty( $atts['descrip'] ) ? $megacal_plugin->megacal_strip_unicode( strtolower( $atts['descrip'] ) ) : 'false';
		$view = ( !empty( $atts['view'] ) && $atts['view'] == 'cal') ? 'cal' : 'list';
		$display = ( !empty( $atts['display'] ) && $atts['display'] == 'img') ? 'img' : 'text';
		$buttons = ( !empty( $atts['buttons'] ) && is_string($atts['buttons'])) ? $megacal_plugin->megacal_strip_unicode( $atts['buttons'] ) : 'left';
		$list_style = !empty( $atts['style'] ) ? $megacal_plugin->megacal_strip_unicode( $atts['style'] ) : $default_style;
		$event_owner = !empty( $atts['eventowner'] ) && intval( $atts['eventowner'] ) == $atts['eventowner'] ? $megacal_plugin->megacal_strip_unicode( $atts['eventowner'] ) : '';
		$event_cat = !empty( $atts['category'] ) && intval( $atts['category'] ) == $atts['category'] ? intval( $megacal_plugin->megacal_strip_unicode( $atts['category'] ) ) : '';
		$img_height = !empty( $atts['imgheight'] ) && intval( $atts['imgheight'] ) == $atts['imgheight'] ? $megacal_plugin->megacal_strip_unicode( $atts['imgheight'] ) : 20;
		$hide_view_selector = !empty( $atts['hideview'] ) ? $megacal_plugin->megacal_strip_unicode( strtolower( $atts['hideview'] ) ) : 'false';

		if($buttons != 'left' && $buttons != 'right' && $buttons != 'center')
			$buttons = 'left';

		$show_filters = !empty( $atts['showfilters'] ) ? $megacal_plugin->megacal_strip_unicode( strtolower( $atts['showfilters'] ) ) : 'false';
	?>

<style>
	/*	Upcoming Events / Past Events buttons*/
	/* 
	.megacal-events-integration .megacal-tabs ul.megacal-tabNav li.current a{
		<?php if( !empty( $settings['megacal_custom_simple_details_btn_color'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_btn_bg_hovercolor'] ); ?> !important;
		<?php endif; ?>		
	}
	*/
	.megacal-events-integration .megacal-tabs ul.megacal-tabNav li a:hover{
		<?php if( !empty( $settings['megacal_btn_bg_hovercolor'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_btn_bg_hovercolor'] ); ?> !important;
			border:1px solid <?php esc_html_e( $settings['megacal_btn_bg_hovercolor'] ); ?> !important;
		<?php endif; ?>
		<?php if( !empty( $settings['megacal_btn_text_hovercolor'] ) ): ?>
			color: <?php esc_html_e( $settings['megacal_btn_text_hovercolor'] ); ?> !important;
		<?php endif; ?>
	}

	/* Load More Button */
	.megacal-events-integration .megacal-list-view .loadMoreBtn {
		<?php if( !empty( $settings['megacal_custom_simple_details_btn_color'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_custom_simple_details_btn_color'] ); ?> !important;
		<?php endif; ?>
		<?php if( !empty( $settings['megacal_custom_simple_details_btn_text_color'] ) ): ?>
			color: <?php esc_html_e( $settings['megacal_custom_simple_details_btn_text_color'] ); ?> !important;
		<?php endif; ?>
	}
	.megacal-events-integration .megacal-list-view .loadMoreBtn:hover {
		<?php if( !empty( $settings['megacal_btn_bg_hovercolor'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_btn_bg_hovercolor'] ); ?> !important;
		<?php endif; ?>
		<?php if( !empty( $settings['megacal_btn_text_hovercolor'] ) ): ?>
			color: <?php esc_html_e( $settings['megacal_btn_text_hovercolor'] ); ?> !important;
		<?php endif; ?>
	}
	<?php if( isset( $settings['megacal_invert_colors_dark_mode'] ) && $settings['megacal_invert_colors_dark_mode'] === "true" ): ?>
		.megacal-events-integration.blackBack .megacal-list-view .loadMoreBtn,
		.megacal-events-integration.blackBack .megacal-tabs ul.megacal-tabNav li a:hover {
			filter: invert( 100% ) !important;
		}
	<?php endif; ?>
</style>

<div id="megacal-events-integration-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="megacal-events-integration <?php esc_attr_e( $theme ); ?> cf">
	
	<div id="event-list-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="inside cf">

		<input type="hidden" id="themeParam-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="themeParam" value="<?php echo esc_attr( $theme ); ?>" />
		<input type="hidden" id="descripParam-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="descripParam" value="<?php echo esc_attr( $descrip ); ?>" />
		<input type="hidden" id="viewParam-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="viewParam" value="<?php echo esc_attr( $view ); ?>" />
		<input type="hidden" id="buttonsParam-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="buttonsParam" value="<?php echo esc_attr( $buttons ); ?>" />
		<input type="hidden" id="listStyleParam-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="listStyleParam" value="<?php echo esc_attr( $list_style ); ?>" />
		<input type="hidden" id="eventOwnerParam-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="eventOwnerParam" value="<?php esc_attr_e( $event_owner ); ?>" />
		<input type="hidden" id="eventCatParam-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="eventCatParam" value="<?php esc_attr_e( $event_cat ); ?>" />
		<input type="hidden" id="displayParam-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="displayParam" value="<?php esc_attr_e( $display ); ?>" />
		<input type="hidden" id="imgHeightParam-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="imgHeightParam" value="<?php esc_attr_e( $img_height ); ?>" />
		<input type="hidden" id="siteUrl-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="siteUrl" value="<?php echo esc_url( site_url() ); ?>" />
		
		<div class="megacal-view-tabs megacal-tabs">
			<div class="singleWide <?php echo $hide_view_selector === 'true' ? 'hidden' : ''; ?>">
				<h3 id="megacal-view-type-tabs-label-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="screen-reader-text">View Type Tabs</h3>
				<ul class="calViewButtons megacal-tabNav" aria-label="megacal-view-type-tabs-label-<?php esc_attr_e( $shortcode_instance_id ); ?>">
					<li class="megacal-tab1">
						<a id="listViewToggle-<?php esc_attr_e( $shortcode_instance_id ); ?>" href="#listView-<?php esc_attr_e( $shortcode_instance_id ); ?>" aria-selected="<?php echo $view === 'list' ? 'true' : 'false'; ?>">
							<i class="fui-list-numbered" aria-hidden="true"></i><span class="screen-reader-text">View Events List</span><!-- List View -->
						</a>
					</li>

					<li class="megacal-tab2">
						<a id="calViewToggle-<?php esc_attr_e( $shortcode_instance_id ); ?>" href="#calView-<?php esc_attr_e( $shortcode_instance_id ); ?>" aria-selected="<?php echo $view === 'cal' ? 'true' : 'false'; ?>">
							<i class="fui-calendar" aria-hidden="true"></i><span class="screen-reader-text">View Events Calendar</span><!-- Calendar View -->				             	
						</a>
					</li>
				</ul>
			</div>

			<?php 
				wp_nonce_field( '_megacal_fetch_public_events_nonce', '_megacal_fetch_public_events_nonce' ); 
				wp_nonce_field( '_megacal_get_event_popup_nonce', '_megacal_get_event_popup_nonce' ); 
			?>

			<?php 
				if( 'true' === $show_filters && empty( $event_owner ) ) {
					require megacal_get_template_part( 'includes/partials/part', 'category-filters', false ); 
				}
			?>
	   		<div id="listView-<?php esc_attr_e( $shortcode_instance_id ); ?>" aria-label="List View" class="<?php if( 'list' == $view ): ?>current<?php endif; ?> megacal-list-view megacal-view-wrap megacal-tab <?php echo 'true' === $show_filters ? 'show-filters' : ''; ?>" data-category-filter="<?php esc_attr_e( $event_cat ); ?>">

				<div class="megacal-tabs ui-tabs-nav">
					<h3 id="megacal-list-type-tabs-label-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="screen-reader-text">List Type Tabs</h3>
		   			<ul aria-labelledby="megacal-list-type-tabs-label-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="megacal-tabNav eventTabsLinks">
		   				<li class="current"><a href="#megacalUpcomingEvents-<?php esc_attr_e( $shortcode_instance_id ); ?>" aria-selected="true">Upcoming Events</a></li>
		   				<li><a href="#megacalPastEvents-<?php esc_attr_e( $shortcode_instance_id ); ?>" aria-selected="false">Past Events</a></li>
		   			</ul>

					<!-- <input type="hidden" class="megacalUpcomingListDate" value="" /> -->
					<input type="hidden" class="megacalPastListDate" value="" />

					<div id="megacalUpcomingEvents-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="megacalUpcomingEvents megacal-tab current" aria-label="Upcoming Events List">						

						<a href="#upcoming-load-more" class="skip-link screen-reader-text">Skip to Load More</a>
						<ul class="eventsList cf"></ul>

						<div class="centerThisGuy">
							<?php if( is_admin() ): ?>
								<?php require megacal_get_template_part( 'includes/partials/part', 'admin-preview', false ); ?>
							<?php else: ?>
								<div class="loadUpcomingAnim loading-animation">
									<img src='<?php echo esc_url( plugins_url('/assets/img/loading.svg', MEGACAL_PLUGIN ) ); ?>' alt='Loading Spinner' class='preLoader' />
								</div>
							
								<button id="upcoming-load-more" class="loadMoreBtn btn greenBtn">Load More</button>
							<?php endif; ?>
						</div>

						<input type="hidden" class="pageNum" value="1" />
		   			</div><!-- /#upcomingEvents -->

		   			<div id="megacalPastEvents-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="megacalPastEvents megacal-tab" aria-label="Past Events List">

						<a href="#past-load-more" class="skip-link screen-reader-text">Skip to Load More</a>
						<ul class="eventsList cf"></ul>

						<div class="centerThisGuy">
							<div class="loadPastAnim loading-animation">
								<img src='<?php echo esc_url( plugins_url( '/assets/img/loading.svg', MEGACAL_PLUGIN ) ); ?>' alt='Loading Spinner' class='preLoader' />
							</div>

							<button id="past-load-more" class="loadMoreBtn btn greenBtn">Load More</button>
						</div>

						<input type="hidden" class="pageNum" value="1" />
		   			</div><!-- /#pastEvents -->

		   		</div><!-- /.tabs -->
	   		</div><!-- /#listView -->
			
			<div id="calView-<?php esc_attr_e( $shortcode_instance_id ); ?>" aria-label="Calendar View" class="<?php if( 'list' != $view ): ?>current<?php endif; ?> megacal-cal-view megacal-view-wrap megacal-tab <?php echo 'true' === $show_filters ? 'show-filters' : ''; ?>">
				<?php if( is_admin() ): ?>
					<?php require megacal_get_template_part( 'includes/partials/part', 'admin-preview', false ); ?>
				<?php else: ?>
					<?php require megacal_get_template_part( 'views/megacal', 'calendar-view', false ); ?>
				<?php endif; ?>
			</div>
		</div><!-- /.tabs -->

		<div class="megacal-subscribe-section">
			<?php 
				$webcal_url = site_url( MEGACAL_ICS_PATH );
				$webcal_url = preg_replace( '#^\w+://#', 'webcal://', $webcal_url );
			?>
			
			<?php /*
			<label for="megacal-subscribe-select-<?php esc_attr_e( $shortcode_instance_id ); ?>">
				<span class="screen-reader-text"> to this calendar</span>
			</label>
			*/ ?>

			<select id="megacal-subscribe-select-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="megacal-subscribe-select">
				<option value="">Subscribe</option>
				<option value="<?php echo esc_url( 'https://www.google.com/calendar/render?cid=' . urlencode( site_url( MEGACAL_ICS_PATH, 'http' ) ) ); ?>">Google Cal</option>
				<option value="<?php echo esc_url( $webcal_url, 'webcal' ); ?>">iCal / Outlook</option>
				<option value="<?php echo esc_url( site_url( MEGACAL_ICS_PATH ) ); ?>">Other Calendar</option>
			</select>

			<!-- https://www.google.com/calendar/render?cid=" -->
		</div>

   		<div class="eventDetailModal window">
   			<img src='<?php echo esc_url( plugins_url( '/assets/img/loading.svg', MEGACAL_PLUGIN ) ); ?>' alt='Loading Spinner' class='preLoader' />
   		</div><!-- /.eventDetailModal -->
   		
   		<div class="megacal-integration-mask"></div><!-- /.megacal-integration-mask -->

    </div><!-- /#event-list.inside -->

</div>	

<?php else: ?>
		<p>Could not connect to MegaCal API, please check plugin settings.</p>
<?php 
	endif; 