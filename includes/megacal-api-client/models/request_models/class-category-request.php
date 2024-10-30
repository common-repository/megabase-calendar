<?php

namespace MegaCal\Client;

class CategoryRequest extends MegaCalRequest {

	const BASE_ENDPOINT     = '/event/category';

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
			'category_id' => array(
				'type' => MegaCalRequest::TYPE_INT,
				'required' => true,
			),
			'name' => array(
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
	 **	endpoint: GET /event/category
	 ** 	Get a list of categories
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return GetCategoriesResponse The get categories response
	 **/
	public function get_categories( $args = array() ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_LIST];
		$args = $this->sanitize_and_transform_args( $args, $validation_rules );
		$request = self::BASE_ENDPOINT;
		
		$response          = $this->client->call( $request, MegaCalClient::$GET );
		$get_venues_response = new GetCategoriesResponse( $response, $args, $request );

		return $get_venues_response;

	}

	/**
	 **	endpoint: PUT  /event/category/{category_id}
	 ** Update a category's details
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return UpdateCategoryResponse The put category response
	 **/
	public function update_category( $args ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_UPDATE];
		$request          = self::BASE_ENDPOINT;

		$args = $this->sanitize_and_transform_args( $args, $validation_rules );
		
		if( !empty( $args['category_id'] ) ) {
			$request = sprintf( '%s/%d', $request, $args['category_id'] );
			unset( $args['category_id'] );
		}

		$response              = $this->client->call( $request, MegaCalClient::$PUT, array(), $args );
		$put_approval_response = new UpdateCategoryResponse( $response, $args, $request );

		return $put_approval_response;

	}
	
}