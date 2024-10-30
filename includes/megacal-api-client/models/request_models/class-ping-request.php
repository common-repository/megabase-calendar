<?php

namespace MegaCal\Client;

class PingRequest extends MegaCalRequest {

	const BASE_ENDPOINT         = '/ping';
	const LABEL_PING 			= 'ping';

	/**
	 **	Request Validation Rules
	 **
	 **	'method_identifier' => rules (
	 **		'arg_name' => 'arg_type'
	 ** 	)
	 **/
	const VALIDATION_RULES = array(

		self::LABEL_PING     => array(
			// no params
		),

	);

	/**
	 **	endpoint: GET /ping
	 ** Pings the API for user details
	 **
	 ** @return PingResponse The ping response
	 **/
	public function ping() {

		$request          = self::BASE_ENDPOINT;

		$response              = $this->client->call( $request, MegaCalClient::$GET );
		$ping_response = new PingResponse( $response, array(), $request );

		return $ping_response;

	}

}