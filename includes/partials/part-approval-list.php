<?php

	use MegaCal\Client\ApiException;
	use MegaCal\Client\GetApprovalResponse;
	use MegaCal\Client\MegaCalAPI;

	if( !defined( 'ABSPATH' ) ) 
		die( 'Not Allowed' );

	// ds: This is NOT meant as a way to secure this pro feature.
	// The API will simply ignore any shared events if users are not flagged as
	// pro users in our db. This just saves the user time and prevents a 
	// needless request. 
	if( !$this->megacal_is_pro_account() ) {
		return; // Stop the request and save users the response time
	}

	try {

		$approval_response = MegaCalAPI::request( MegaCalAPI::USER_REQUEST, 'get_approval' );  
	
	} catch( ApiException $e ) {
?>
		<div class="notice-container error-notice">
			<p>Error: <?php esc_html_e( $e->getMessage() ); ?></p>
		</div>
<?php
		error_log( $e->getMessage() );
		return;

	}

	if( !( $approval_response instanceof GetApprovalResponse ) ) {
		return; // Something is funky
	}

	if( $approval_response->get_count() <= 0 ) {
		set_transient( MEGACAL_NOTICE_COUNT_CACHE_KEY, 0, MEGACAL_NOTICE_COUNT_EXPIRE_TIME );   
		return; // No Approvals to show
	} 
?>

	<h3>Events for Approval</h3>

<?php 

	wp_nonce_field( '_megacal_set_event_approval_nonce', '_megacal_set_event_approval_nonce' );

	$total_messages = $approval_response->get_count();
	set_transient( MEGACAL_NOTICE_COUNT_CACHE_KEY, $total_messages, MEGACAL_NOTICE_COUNT_EXPIRE_TIME );   

	$counter = 0;
	foreach( $approval_response->get_events() as $event ) {

		include( untrailingslashit( MEGACAL_PLUGIN_DIR ) . '/includes/partials/part-approval-notice.php' );
		$counter++;

		if( $counter > 4 ) {
			break;
		}

	}

	if( $total_messages > 5 ) {
		printf( '<p style="text-align: center;padding-right: 35px;}"><strong>+ %d more approvals in queue</strong></p>', $total_messages - $counter );
	}