<?php 

// Response Model for GET /venue

namespace MegaCal\Client;

class GetVenuesResponse extends MegaCalResponse {

	private $count = 0;
	private $venues = array();

	public function __construct( $response, $request_args, $request ) {
		
		parent::__construct( $response, $request_args, $request );

		$this->set_count( $this->response_body['count'] );
		$this->venues = $this->parse_venues( $this->response_body['venues'] );

	}

	public function get_count() { return $this->count; }
	private function set_count( $count ) { $this->count = intval( $count ); }

	public function get_venues() { return $this->venues; }

}