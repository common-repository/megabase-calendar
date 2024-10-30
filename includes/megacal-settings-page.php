<?php

use MegaCal\Client\ApiException;
use MegaCal\Client\GetUserResponse;
use MegaCal\Client\MegaCalAPI;

if( !defined( 'ABSPATH' ) ) die();
if( !current_user_can( MEGACAL_PLUGIN_VISIBILITY_CAP ) ) wp_die( 'Not Allowed' );

// check if the user submitted the settings
// wordpress will add the "settings-updated" $_GET parameter to the url
if( isset( $_GET['settings-updated'] ) ) {
	// add settings saved message with the class of "updated"
	add_settings_error( 'megacal_options', 'megacal_message_updated', 'Settings Saved', 'success' );
}

$settings = self::megacal_get_settings();
$hidden_settings = self::megacal_get_settings( 'megacal_hidden_options' );

if( isset( $_GET['paid'] ) && boolval( $_GET['paid'] ) ) {
	delete_transient( MEGACAL_PING_RESPONSE_CACHE_KEY );
	add_settings_error( 'megacal_options', 'megacal_account_paid', 'Success: Payment received, thank you!', 'success' );
}

if( empty( $settings['megacal_access_token'] ) ) {
	add_settings_error( 'megacal_options', 'megacal_warning_megacal_access_token', 'Fill out the form to generate your API key or add your existing Access Token and Refresh Token on the General tab', 'warning' );
}

// show error/update messages
settings_errors( 'megacal_options' );
?>

<div id="megacal-events-settings" class="wrap megacal-settings-page">

	<h1>MegaCalendar</h1>

	<?php include( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-notice-container.php' ); ?>

	<?php if( current_user_can( MEGACAL_TOKEN_VISIBILITY_CAP ) ): ?>

		<?php if( empty( $settings['megacal_access_token'] ) ): ?>
			<ul class="megacal-admin-tabs tabs">
			
				<li class="current">
					<a href="#megacal-events-settings-register">Register</a>
				</li>

				<li class="<?php echo empty( $settings['megacal_access_token'] ) ? '' : 'current'; ?>">
					<a href="#megacal-events-settings-general">Settings</a>
				</li>

			</ul>
			
			<div id="megacal-events-settings-register" class="admin-tab">
				<h3 class="short-margin">Register</h3>
				<p class="docs-link">
					<a href="https://megabase.co/help_docs/setup/" target="_blank"><i class="fui-question-circle" aria-hidden="true"></i>Need Help?</a>
				</p>
				<p>If you do not have a MegaCalendar account, please register. <br />
				If you already have an account, enter your access and refresh tokens fields on the <b>Settings</b> tab.</p>
				<?php require_once( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-register-form.php' ); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<div id="megacal-events-settings-general" class="admin-tab megaFlexSection">
		<div class="leftArea">
			<?php if( current_user_can( MEGACAL_TOKEN_VISIBILITY_CAP ) ): ?>
				<ul class="megacal-admin-tabs tabs">

					<li class="current">
						<a href="#megacal-events-settings-general-tab">General</a>
					</li>

					<li>
						<a href="#megacal-events-settings-colors-tab">Theme Colors</a>
					</li>

				</ul>

				<form action="options.php" method="post">
					<?php
					// output security fields for the registered setting
					settings_fields(MEGACAL_SETTINGS_SLUG);
					
					// output setting sections and their fields
					do_settings_sections(MEGACAL_SETTINGS_SLUG);
					
					// output save settings button
					submit_button('Save Settings');
					?>
				</form>

				<?php if( !empty( $settings['megacal_access_token'] ) ): ?>
					<h2 class="mega-collapsable-toggle" role="button" aria-pressed="false">
						<i class="icon-chevron-right" aria-hidden="true"></i>Advanced
					</h2>

					<div class="mega-collapsable collapsed">
						<div>
							<p>Show Access Tokens</p>
							<p class="small">Use this if you need to copy or change your access/refresh tokens. <b>DO NOT SHARE THESE KEYS</b></p>
							<br />
							<button id="megacal-show-tokens" class="button button-secondary">Show Access Tokens</button>
						</div>
		
						<div>
							<p>Reset Account</p>
							<p class="small">Use this if you need to unlink your MegaCalendar account from the plugin. You can use this to start over after testing, switch between different accounts, or create a new account.</p> 
							<p class="small">NOTE: By unlinking your account, you will be losing access to any events saved in your calendar. Make a note of your Access Tokens before doing this if you will need to regain access to your existing account.</p>
							<br />
							<button id="megacal-reset-account" class="button button-secondary">Reset Account</button>
							<?php wp_nonce_field( '_megacal_unlink_account_nonce', '_megacal_unlink_account_nonce' ); ?>
						</div>
					</div>
				<?php endif; ?>

			<?php endif; ?>

			<?php $this->megacal_display_admin_links(); ?>
			
		</div>
		<div class="rightArea"> 			

			<?php if( !empty( $settings['megacal_access_token'] ) ): ?>
				<div class="megacal-account-details">
					<?php 
						$email = '';
						$handle = '';
						$user_id = $hidden_settings['user_id'];

						try {
							
							$user_response = MegaCalAPI::request( MegaCalAPI::USER_REQUEST, 'get_user', array( 
								'user_id' => $user_id 
							) );
							
							if( $user_response instanceof GetUserResponse ) {
								$email = $user_response->get_email();
								$handle = $user_response->get_handle();
							}

						} catch( ApiException $e ) {
							$email = '';
						}
					?>
					<h3>Account Details</h3>
					
					<?php if( !empty( $email ) ): ?>
						<p>Email Address: <b><?php esc_html_e( $email ); ?></b></p>
					<?php endif; ?>

					<?php if( !empty( $handle ) ): ?>
						<p>Handle: <b><?php esc_html_e( $handle ); ?></b></p>
					<?php endif; ?>

					<p>Account Type: <b><?php echo $this->megacal_is_pro_account() ? 'Pro' : 'Free'; ?></b></p>

					<?php if( $this->megacal_is_pro_account() ): ?>
						<a href="<?php echo esc_url( $this->get_stripe_portal_url() ); ?>" class="button button-secondary" target="_blank">Manage Subscription</a>
					<?php else: ?>
						<a href="<?php echo esc_url( MEGACAL_UPGRADE_URL ); ?>" class="button button-secondary">Upgrade to Pro</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
	
</div><!-- /.wrap -->