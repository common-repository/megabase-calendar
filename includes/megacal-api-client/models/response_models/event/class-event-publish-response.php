<?php 

// Response Model for /event/publish

namespace MegaCal\Client;

class EventPublishResponse extends MegaCalResponse {

	public function __construct( $response, $request_args, $request ) {
		
		parent::__construct( $response, $request_args, $request );
		
	}

}