<?php 

// Response Model for PUT /venue/{venue_id}

namespace MegaCal\Client;

class UpdateVenueResponse extends MegaCalResponse {

	private $id = 0;

	public function __construct( $response, $request_args, $request ) {
		
		parent::__construct( $response, $request_args, $request );

		$this->set_id( $this->response_body['id'] );

	}

	private function set_id( $id ) { $this->id = intval( $id ); }
	public function get_id() { return $this->id; }

}