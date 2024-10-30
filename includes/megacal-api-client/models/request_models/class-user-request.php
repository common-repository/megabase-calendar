<?php

namespace MegaCal\Client;

class UserRequest extends MegaCalRequest {

	const BASE_ENDPOINT     = '/user';
	const APPROVAL_ENDPOINT = self::BASE_ENDPOINT . '/approval';

	const LABEL_GET_USER	 = 'get-user';
	const LABEL_GET_APPROVAL = 'get-approval';
	const LABEL_PUT_APPROVAL = 'put-approval';

	const STATUS_YES = 'yes';
	const STATUS_NO = 'no';
	const STATUS_ALL = 'all';
	const STATUS_APPROVE_PENDING = 'approve_pending';
	const STATUS_DENY_PENDING = 'deny_pending';

	/**
	 **	Request Validation Rules
	 **
	 **	'method_identifier' => rules (
	 **		'arg_name' => 'arg_type'
	 ** 	)
	 **/
	const VALIDATION_RULES = array(

		self::LABEL_GET_USER => array(
			'user_id' => array(
				'type' => MegaCalRequest::TYPE_INT,
				'required' => true,
			),
		),

		self::LABEL_GET_APPROVAL => array(
			'user_id' => array(
				'type' => MegaCalRequest::TYPE_INT,
				'required' => false,
			),
		),

		self::LABEL_PUT_APPROVAL      => array(
			'user_id' => array(
				'type' => MegaCalRequest::TYPE_INT,
				'required' => true,
			),
			'event_id' => array(
				'type'     => MegaCalRequest::TYPE_INT,
				'required' => false,
			),
			'approbation' => array(
				'type'     => MegaCalRequest::TYPE_STRING, // yes/no/all/approve_pending/deny_pending
				'required' => true,
			),
		),

	);

	/**
	 **	endpoint: GET /user/{user_id}
	 ** 	Get a user's account details
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return GetUserResponse The get user response
	 **/
	public function get_user( $args = array() ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_GET_USER];
		$args = $this->sanitize_and_transform_args( $args, $validation_rules );
		$request = self::BASE_ENDPOINT;

		if( !empty( $args['user_id'] ) ) {
			$request = sprintf( '%s/%d', $request, $args['user_id'] );
			unset( $args['user_id'] );
		}
		
		$response          = $this->client->call( $request, MegaCalClient::$GET );
		$get_user_response = new GetUserResponse( $response, $args, $request );

		return $get_user_response;
	
	}

	/**
	 **	endpoint: GET /user/approval
	 ** 	Get a list of events pending approval
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return GetApprovalResponse The get approval response
	 **/
	public function get_approval( $args = array() ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_GET_APPROVAL];
		$args = $this->sanitize_and_transform_args( $args, $validation_rules );
		$request = self::APPROVAL_ENDPOINT;

		if( !empty( $args['user_id'] ) ) {
			$request = sprintf( '%s/%d', $request, $args['user_id'] );
			unset( $args['user_id'] );
		}
		
		$response          = $this->client->call( $request, MegaCalClient::$GET );
		$get_approval_response = new GetApprovalResponse( $response, $args, $request );

		return $get_approval_response;

	}

	/**
	 **	endpoint: PUT  /user/approval
	 ** Approve or deny an event 
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return PutApprovalResponse The put approval response
	 **/
	public function put_approval( $args ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_PUT_APPROVAL];
		$request          = self::APPROVAL_ENDPOINT;

		$args = $this->sanitize_and_transform_args( $args, $validation_rules );

		$user_id = $args['user_id'];
		unset( $args['user_id'] );
		$request = sprintf( '%s/%d', $request, $user_id );

		if( !empty( $args['event_id'] ) ) {
			$event_id = $args['event_id'];
			unset( $args['event_id'] );
			$request = sprintf( '%s/%d', $request, $event_id );
		}

		$response              = $this->client->call( $request, MegaCalClient::$PATCH, $args );
		$put_approval_response = new PutApprovalResponse( $response, $args, $request );

		return $put_approval_response;

	}
	
}