<?php 

	if( !defined( 'ABSPATH' ) ) 
		die( 'Not Allowed' );

	// stranger has happened
	if( empty( $event ) )
		return;

?>

<div class="notice-container approval-notice" data-event-id="<?php esc_attr_e( $event->get_id() ); ?>" data-user-id="<?php esc_attr_e( $event->get_owner()->get_id() ); ?>">

	<div class="notice-text noticeFlexChild">
		<h3><?php esc_html_e( date( 'm/d/Y', strtotime( $event->get_event_date() ) ) ); ?> - <?php esc_html_e( $event->get_title() ); ?></h3>
		<p>
			Sent by: 
			<strong><?php esc_html_e( $event->get_owner()->get_calendar_name() ); ?></strong> 
			(<strong><?php esc_html_e( $event->get_owner()->get_handle() ); ?></strong>)
		</p>
	</div>
	
	<div class="rightArea noticeFlexChild">
		<div class="notice-buttons ">
			<h4>This Event</h4>
			<button class="button button-primary button-approval-action" data-action="approve">Accept</button>
			<button class="button button-delete button-approval-action" data-action="deny">Skip</button>
		</div>
		
		<div class="notice-buttons ">
			<h4>This Sender</h4>
			<button class="button button-secondary button-approval-action" data-action="always">Always Accept</button>
			<button class="button button-secondary button-approval-action" data-action="approve_pending">Accept All Pending</button>
			<button class="button button-delete button-approval-action lessSevere" data-action="deny_pending">Deny All Pending</button>
		</div>
	</div>

</div>