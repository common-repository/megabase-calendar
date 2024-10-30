<?php 

// Response Model for GET /event/recurrence

namespace MegaCal\Client;

class EventRecurrenceResponse extends MegaCalResponse {

	private $event_recurrence_details;

	public function __construct( $response, $request_args, $request ) {
		
		parent::__construct( $response, $request_args, $request );

		$this->set_event_recurrence_details( $this->response_body );
		
	}

	public function get_event_recurrence_details() { return $this->event_recurrence_details; }
	private function set_event_recurrence_details( $event_recurrence_details ) { $this->event_recurrence_details = new EventRecurrenceDetail( $event_recurrence_details ); }

}