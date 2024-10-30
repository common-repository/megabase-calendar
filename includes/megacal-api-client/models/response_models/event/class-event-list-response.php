<?php 

// Response Model for /events

namespace MegaCal\Client;

class EventListResponse extends MegaCalResponse {

	private $count = 0;
	private $events = array(); 

	public function __construct( $response, $request_args, $request ) {
		
		parent::__construct( $response, $request_args, $request );

		$this->set_count( $this->response_body['count'] );

		if( $this->response_body['count'] > 0 ) {
			$this->set_events( $this->response_body['events'] );
		}
		
	}

	// Getters & Setters

		public function get_events() { return $this->events; }
		private function set_events( $events ) {

			foreach( $events as $event ) {
				$this->events[] = new Event( $event );
			}
	
		}
	
		public function get_count() { return $this->count; }
		public function set_count( $count ) { $this->count = intval( $count ); }

}