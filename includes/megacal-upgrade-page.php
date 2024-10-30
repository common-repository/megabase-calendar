<?php 

	if( !defined( 'ABSPATH' ) ) die( 'Not Allowed' );
	$hidden_settings = self::megacal_get_settings( 'megacal_hidden_options' );

?>

<div id="megacal-upgrade-options" class="megacal-settings-page">

	<h2>Upgrade to Pro</h2>

	<div class="megacal-upgrade-wrap">
		
		<div class="postbox-container">

			<div class="card card-free">
				
				<div class="card-header"><h3>MegaCalendar</h3></div>

				<div class="card-body">

					<ul class="features">
						<li>Unlimited Events</li>
						<li>Calendar View Shortcode</li>
						<li>Event List View Shortcode</li>
						<li>Simple List View Shortcode</li>
					</ul>

					<p class="price"><em>FREE</em></p>
					
					<a class="button button-secondary megacal-button-free" href="<?php echo esc_url( MEGACAL_SETTINGS_URL ); ?>">Go with Free &raquo;</a>

				</div>

			</div>

		</div>

		<div class="postbox-container">

			<div class="card card-upgrade">
					
				<div class="card-header"><h3>MegaCalendar Pro</h3></div>

				<div class="card-body">
					All Free Features plus: 
					<ul class="features">
						<li>Receive events from other calendars</li>
						<li>Recurring Events (Including weekly/monthly, 2nd Tuesday etc)</li>
						<li>Ability to manage Venue and Category details</li>
					</ul>

					<!-- <p class="price"><em>$50 USD / Month</em></p> -->
					<p class="price"><em>Click below for price and special offers</em></p>

					<a href="https://megabase.co/products/megacalendar/megacal-upgrade?stripe_link_back=<?php echo rawurlencode( esc_url( MEGACAL_SETTINGS_URL ) . '&paid=true' ); ?>&client_reference_id=<?php echo ( !empty( $hidden_settings['handle'] ) ) ? urlencode( esc_attr( $hidden_settings['handle'] ) ) : '' ?>" class="button button-primary megacal-button-upgrade" target="_blank">Go Pro &raquo;</a>

				</div>

			</div>

		</div>

	</div>

</div>