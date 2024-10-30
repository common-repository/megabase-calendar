<?php 

// Response Model for /user/approval

namespace MegaCal\Client;

class GetApprovalResponse extends EventListResponse {

	public function __construct( $response, $request_args, $request ) {
		
		parent::__construct( $response, $request_args, $request );

	}

}