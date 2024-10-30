<?php 

// Response Model for GET /event/category

namespace MegaCal\Client;

class GetCategoriesResponse extends MegaCalResponse {

	private $count = 0;
	private $categories = array();

	public function __construct( $response, $request_args, $request ) {
		
		parent::__construct( $response, $request_args, $request );

		$this->set_count( $this->response_body['count'] );
		$this->categories = $this->parse_categories( $this->response_body['categories'] );

	}

	public function get_count() { return $this->count; }
	private function set_count( $count ) { $this->count = intval( $count ); }

	public function get_categories() { return $this->categories; }

}