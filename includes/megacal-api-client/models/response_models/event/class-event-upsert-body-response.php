<?php 

// Response Model for GET /event/upsert

namespace MegaCal\Client;

class EventUpsertBodyResponse extends MegaCalResponse {

	private $event;
	private $categories = array();
	private $venues = array();

	public function __construct( $response, $request_args, $request ) {
		
		parent::__construct( $response, $request_args, $request );

		if( !empty( $this->response_body['event'] ) ) {
			$this->set_event( $this->response_body['event'] );
		}

		$this->categories = $this->parse_categories( $this->response_body['categories'] );
		$this->venues = $this->parse_venues( $this->response_body['venues'] );
		
	}

	// Getters & Setters
		public function get_event() { return $this->event; }
		private function set_event( $event ) { $this->event = new Event( $event ); }
		
		public function get_categories() { return $this->categories; }
		public function get_venues() { return $this->venues; }

}