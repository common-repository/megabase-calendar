<?php 

// Response Model for DELETE /event/{event_id}

namespace MegaCal\Client;

class EventDeleteResponse extends MegaCalResponse {

	public function __construct( $response, $request_args, $request ) {
		
		parent::__construct( $response, $request_args, $request );
		
	}

}