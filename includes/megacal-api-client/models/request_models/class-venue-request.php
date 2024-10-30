<?php

namespace MegaCal\Client;

class VenueRequest extends MegaCalRequest {

	const BASE_ENDPOINT     = '/venue';

	const LABEL_LIST = 'list';
	const LABEL_UPDATE = 'update';

	/**
	 **	Request Validation Rules
	 **
	 **	'method_identifier' => rules (
	 **		'arg_name' => 'arg_type'
	 ** 	)
	 **/
	const VALIDATION_RULES = array(

		self::LABEL_LIST => array(
			'start_row' => array(
				'type'     => MegaCalRequest::TYPE_INT,
				'required' => false,
				'transform' => 'start-row',
			),
			'max_result' => array(
				'type'     => MegaCalRequest::TYPE_INT,
				'required' => false,
				'transform' => 'max-result',
			),
			'published' => array(
				'type' => MegaCalRequest::TYPE_BOOL,
				'required' => false,
			)
		),

		self::LABEL_UPDATE      => array(
			'venue_id' => array(
				'type' => MegaCalRequest::TYPE_INT,
				'required' => true,
			),
			'name' => array(
				'type'     => MegaCalRequest::TYPE_STRING,
				'required' => false,
			),
			'location' => array(
				'type'     => MegaCalRequest::TYPE_STRING,
				'required' => false,
			),
			'published' => array(
				'type'     => MegaCalRequest::TYPE_BOOL,
				'required' => false,
			),
		),

	);

	/**
	 **	endpoint: GET /venue
	 ** 	Get a list of venues
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return GetVenuesResponse The get venue response
	 **/
	public function get_venues( $args = array() ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_LIST];
		$args = $this->sanitize_and_transform_args( $args, $validation_rules );
		$request = self::BASE_ENDPOINT;
		
		$response          = $this->client->call( $request, MegaCalClient::$GET );
		$get_venues_response = new GetVenuesResponse( $response, $args, $request );

		return $get_venues_response;

	}

	/**
	 **	endpoint: PUT  /venue/{venue_id}
	 ** Update a venue's details
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return UpdateVenueResponse The put venue response
	 **/
	public function update_venue( $args ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_UPDATE];
		$request          = self::BASE_ENDPOINT;
		
		$args = $this->sanitize_and_transform_args( $args, $validation_rules );

		if( !empty( $args['venue_id'] ) ) {
			$request = sprintf( '%s/%d', $request, $args['venue_id'] );
			unset( $args['venue_id'] );
		}

		$response              = $this->client->call( $request, MegaCalClient::$PUT, array(), $args );
		$put_approval_response = new UpdateVenueResponse( $response, $args, $request );

		return $put_approval_response;

	}
	
}