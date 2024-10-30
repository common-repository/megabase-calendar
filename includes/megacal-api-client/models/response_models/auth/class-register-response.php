<?php 

// Response Model for /auth/register

namespace MegaCal\Client;

class RegisterResponse extends MegaCalResponse {

	private $access_token = '';
	private $refresh_token = '';

	public function __construct( $response, $request_args, $request ) {
		
		parent::__construct( $response, $request_args, $request );

		$this->access_token = $this->response_body['accessToken'];
		$this->refresh_token = $this->response_body['refreshToken'];
		
	}

	// Getters & Setters

		public function get_access_token() { return $this->access_token; }
		private function set_access_token( $access_token ) { $this->access_token = $access_token; }

		public function get_refresh_token() { return $this->refresh_token; }
		private function set_refresh_token( $refresh_token ) { $this->refresh_token = $refresh_token; }


}