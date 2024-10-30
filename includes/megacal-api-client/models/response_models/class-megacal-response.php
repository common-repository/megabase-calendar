<?php

namespace MegaCal\Client;

use MegabaseCalendar;

abstract class MegaCalResponse {

	const STATUS_200 = 200;
	const STATUS_400 = 400;
	const STATUS_401 = 401;
	const STATUS_404 = 404;
	const STATUS_500 = 500;

	protected $status;
	protected $code;
	protected $message;

	// passed from request
	protected $request;
	protected $request_args;

	protected $headers;
	protected $response;
	protected $response_body;
	protected $response_body_raw;
	protected $execution_id;

	public function __construct( $response, $request_args, $request ) {

		$this->headers = !empty( $response['headers'] ) ? $response['headers'] : array();
		$this->response = !empty( $response['response'] ) ? $response['response'] : array(); 
		$this->response_body = !empty( $response['body'] ) ? json_decode( $response['body'], true ) : array();
		$this->response_body_raw = !empty( $response['body'] ) ? $response['body'] : '';

		// Handle response status codes
		$this->status = $this->response['code'];

		$this->code = !empty( $this->response['code'] ) ? $this->response['code'] : '';
		$this->message = !empty( $this->response_body['message'] ) ? $this->response_body['message'] : '';

		$this->request = $request;
		$this->request_args = $request_args;
		$this->execution_id = $this->headers['Execution-Id'];

		error_log( 
			sprintf(
				"%s DEBUG:\nRequest: %s\nResponse Type: %s\nRequest Args: %s\nExecution ID: %s\nStatus: %d\n\n",
				current_time( 'Y-m-d H:i:s' ),
				$this->request,
				get_class( $this ),
				json_encode( $this->request_args ),
				$this->execution_id,
				$this->status,
			), 
			3, 
			trailingslashit( MEGACAL_PLUGIN_DIR ) . 'debug.log' 
		);

		if( self::STATUS_200 !== $this->status ) {
			throw new ApiException( 
				sprintf( 
					'ERROR: %s, Code: %s, HTTP Status: %d, Execution ID: %s', 
					$this->message, 
					$this->code, 
					$this->status,
					$this->execution_id 
				),
				$this->status,
				$this->message
			);
		}
		
		if( !empty( $this->headers['Access-Token'] ) ) {
			MegabaseCalendar::maybe_update_access_token( $this->headers['Access-Token'] );
		}

	}

	/** Utility Functions **/
		protected function parse_categories( $categories ) {

			if( empty( $categories ) ) {
				return array();
			}

			$category_objects = array();
			foreach ( $categories as $category ) {
				$category_objects[] = new EventCategory( $category );
			}

			return $category_objects;
			
		}

		protected function parse_venues( $venues ) {

			if( empty( $venues ) ) {
				return array();
			}

			$venue_objects = array();
			foreach ( $venues as $venue ) {
				$venue_objects[] = new Venue( $venue );
			}

			return $venue_objects;

		}

		protected function store_execution_id() {
			MegabaseCalendar::store_execution_id( $this->execution_id );
		}

	/** Getters & Setters **/
		public function get_status() { return $this->status; }
		public function get_code() { return $this->code; }
		public function get_message() { return $this->message; }
		public function get_request_arg() { return $this->request_args; }
		public function get_headers() { return $this->headers; }
		public function get_response_body() { return $this->response_body; }
		public function get_response_body_raw() { return $this->response_body_raw; }
		public function get_props() { return get_object_vars( $this ); }
		public function get_execution_id() { return $this->execution_id; }

}