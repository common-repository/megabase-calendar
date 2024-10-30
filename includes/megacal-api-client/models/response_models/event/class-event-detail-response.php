<?php 

namespace MegaCal\Client;

class EventDetailResponse extends MegaCalResponse {

	private $event;

	public function __construct( $response, $request_args, $request ) {

		parent::__construct( $response, $request_args, $request );

		$this->set_event( $this->response_body );
		
	}

	// Getters & Setters 

		public function get_event() { return $this->event; } 
		private function set_event( $event ) { $this->event = new Event( $event ); } 

}