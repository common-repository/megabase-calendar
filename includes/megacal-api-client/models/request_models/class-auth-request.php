<?php

namespace MegaCal\Client;

class AuthRequest extends MegaCalRequest {

	const BASE_ENDPOINT         = '/auth';
	const REGISTER_ENDPOINT     = self::BASE_ENDPOINT . '/register';
	const CHECK_HANDLE_ENDPOINT = self::BASE_ENDPOINT . '/check-handle';

	const LABEL_REGISTER     = 'register';
	const LABEL_CHECK_HANDLE = 'check-handle';

	/**
	 **	Request Validation Rules
	 **
	 **	'method_identifier' => rules (
	 **		'arg_name' => 'arg_type'
	 ** 	)
	 **/
	const VALIDATION_RULES = array(

		self::LABEL_REGISTER     => array(
			'first_name' => array(
				'type' => MegaCalRequest::TYPE_STRING,
				'required' => true,
				'transform' => 'firstName',
			),
			'last_name' => array(
				'type' => MegaCalRequest::TYPE_STRING,
				'required' => true,
				'transform' => 'lastName',
			),
			'handle' => array(
				'type' => MegaCalRequest::TYPE_STRING,
				'required' => true,
			),
			'email' => array(
				'type' => MegaCalRequest::TYPE_STRING,
				'required' => true,
			),
			'phone' => array(
				'type' => MegaCalRequest::TYPE_STRING,
			),
			'calendar_name' => array(
				'type' => MegaCalRequest::TYPE_STRING,
				'required' => true,
				'transform' => 'calendarName',
			),
		),

		self::LABEL_CHECK_HANDLE => array(
			'handle' => array(
				'type'     => MegaCalRequest::TYPE_STRING,
				'required' => true,
			),
		),

	);

	/**
	 **	endpoint: POST /auth/register
	 ** 	Register a new user
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return RegisterResponse The register response
	 **/
	public function register( $args ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_REGISTER];
		$request          = self::REGISTER_ENDPOINT;

		$args = $this->sanitize_and_transform_args( $args, $validation_rules );
		$params = array();

		$response              = $this->client->raw_call( $request, MegaCalClient::$POST, $params, $args );
		$register_response = new RegisterResponse( $response, $args, $request );

		return $register_response;

	}

	/**
	 **	endpoint: GET /auth/check-handle
	 ** 	Check a user handle for uniqueness
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return CheckHandleResponse The check handle response
	 **/
	public function check_handle( $args ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_CHECK_HANDLE];
		$request          = self::CHECK_HANDLE_ENDPOINT;

		$args = $this->sanitize_and_transform_args( $args, $validation_rules );

		$response              = $this->client->raw_call( $request, MegaCalClient::$GET, $args );
		$check_handle_response = new CheckHandleResponse( $response, $args, $request );

		return $check_handle_response;

	}

}