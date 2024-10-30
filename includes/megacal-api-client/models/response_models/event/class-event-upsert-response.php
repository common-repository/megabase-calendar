<?php 

// Response Model for POST & PUT /event

namespace MegaCal\Client;

class EventUpsertResponse extends MegaCalResponse {

	private $event_id = 0;

	public function __construct( $response, $request_args, $request ) {
		
		parent::__construct( $response, $request_args, $request );

		$this->set_event_id( $this->response_body['id'] );
		$this->store_execution_id();
		
	}

	// Getters & Setters
		
		public function get_event_id() { return $this->event_id; }
		private function set_event_id( $event_id ) { $this->event_id = intval( $event_id ); }

}