<?php 

// Response Model for /event/processing

namespace MegaCal\Client;

class EventProcessingResponse extends MegaCalResponse {

	protected $event_processing_details;

	public function __construct( $response, $request_args, $request ) {
		
		parent::__construct( $response, $request_args, $request );

		$this->set_event_processing_details( $this->response_body );

	}

	public function get_event_processing_details() { return $this->event_processing_details; }
	private function set_event_processing_details( $event_processing_details ) { $this->event_processing_details = new EventProcessingDetail( $event_processing_details ); }

}