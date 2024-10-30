<?php 

// Response Model for /auth/check-handle

namespace MegaCal\Client;

class CheckHandleResponse extends MegaCalResponse {

	private $unique = false;

	public function __construct( $response, $request_args, $request ) {
		
		parent::__construct( $response, $request_args, $request );

		$this->set_unique( $this->response_body['unique'] );
		
	}

	public function get_unique() { return $this->unique; }
	private function set_unique( $unique ) { $this->unique = boolval( $unique ); }

}