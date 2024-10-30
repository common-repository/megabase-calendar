<?php 

// Response Model for /auth/check-handle

namespace MegaCal\Client;

class PingResponse extends MegaCalResponse {

	private $user_id = 0;
	private $handle = '';
	private $pro_account = false;
	private $calendar_name = '';

	public function __construct( $response, $request_args, $request ) {
		
		parent::__construct( $response, $request_args, $request );

		$this->set_pro_account( $this->response_body['proAccount'] );
		$this->set_handle( $this->response_body['handle'] );
		$this->set_user_id( $this->response_body['id'] );
		$this->set_calendar_name( $this->response_body['calendarName'] );
		
	}

	public function get_pro_account() { return $this->pro_account; }
	private function set_pro_account( $pro_account ) { $this->pro_account = boolval( $pro_account ); }

	public function get_handle() { return $this->handle; }
	private function set_handle( $handle ) { $this->handle = $handle; }

	public function get_user_id() { return $this->user_id; }
	private function set_user_id( $user_id ) { $this->user_id = intval( $user_id ); }

	public function get_calendar_name() { return $this->calendar_name; }
	private function set_calendar_name( $calendar_name ) { $this->calendar_name = $calendar_name; }

}