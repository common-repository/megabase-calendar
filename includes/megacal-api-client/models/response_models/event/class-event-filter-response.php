<?php 

// Response Model for /events/filter
namespace MegaCal\Client;

class EventFilterResponse extends MegaCalResponse {

	private $event_owners = array();
	private $venues = array();
	private $event_categories = array();

	public function __construct( $response, $request_args, $request ) {

		parent::__construct( $response, $request_args, $request );

		$this->set_event_owners( $this->response_body['owners'] );
		$this->set_venues( $this->response_body['venues'] );
		$this->set_event_categories( $this->response_body['categories'] );
		
	}

	// Getters & Setters 

		public function get_event_owners() { return $this->event_owners; } 
		private function set_event_owners( $event_owners ) { 
		
			foreach( $event_owners as $event_owner ) {
				
				$this->event_owners[] = new User( $event_owner ); 
			
			}
		
		} 

		public function get_venues() { return $this->venues; }
		private function set_venues( $venues ) { $this->venues = $this->parse_venues( $venues ); }

		public function get_event_categories() { return $this->event_categories; }
		private function set_event_categories( $event_categories ) {
			
			if( empty( $event_categories ) ) {
				return array();
			}

			foreach ( $event_categories as $category ) {
				$this->event_categories[] = new FilterCategory( $category );
			}

		}

}