<?php 

// Response Model for PUT /user/approval

namespace MegaCal\Client;

class PutApprovalResponse extends MegaCalResponse {

	public function __construct( $response, $request_args, $request ) {
		
		parent::__construct( $response, $request_args, $request );
		
	}

}