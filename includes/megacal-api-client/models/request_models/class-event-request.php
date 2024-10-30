<?php

namespace MegaCal\Client;

class EventRequest extends MegaCalRequest {

	const BASE_ENDPOINT         = '/event';
	const FETCH_UPSERT_ENDPOINT = 'upsert';
	const PUBLISH_ENDPOINT      = 'publish';
	const FILTER_ENDPOINT       = 'filter';
	const RECURRENCE_ENDPOINT   = self::BASE_ENDPOINT . '/recurrence';
	const PROCESSING_ENDPOINT   = self::BASE_ENDPOINT . '/processing';

	const LABEL_UPSERT     = 'upsert';
	const LABEL_UPSERT_NEW = 'upsert-new';
	const LABEL_CREATE     = 'create';
	const LABEL_UPDATE     = 'update';
	const LABEL_DETAIL     = 'detail';
	const LABEL_PUBLISH    = 'publish';
	const LABEL_LIST       = 'list';
	const LABEL_FILTER     = 'filter';
	const LABEL_DELETE     = 'delete';
	const LABEL_RECURRENCE = 'recurrence';
	const LABEL_PROCESSING = 'processing';

	/**
	 **	Request Validation Rules
	 **
	 **	'method_identifier' => rules (
	 **		'arg_name' => 'arg_type'
	 ** 	)
	 **/
	const VALIDATION_RULES = array(

		self::LABEL_UPSERT     => array(
			'event_id' => array(
				'type'      => MegaCalRequest::TYPE_INT,
				'required'  => true,
				'transform' => 'event-id',
			),
		),

		self::LABEL_UPSERT_NEW => array(
			// No Args
		),

		self::LABEL_CREATE     => array(
			'title'          => array(
				'type'     => MegaCalRequest::TYPE_STRING,
				'required' => true,
			),
			'image_url'      => array(
				'type'      => MegaCalRequest::TYPE_URL,
				'required'  => false,
				'transform' => 'imageUrl',
			),
			'image_url_square'      => array(
				'type'      => MegaCalRequest::TYPE_URL,
				'required'  => false,
				'transform' => 'imageUrlSquare',
			),
			'image_url_detail'      => array(
				'type'      => MegaCalRequest::TYPE_URL,
				'required'  => false,
				'transform' => 'imageUrlDetail',
			),
			'image_url_banner'      => array(
				'type'      => MegaCalRequest::TYPE_URL,
				'required'  => false,
				'transform' => 'imageUrlBanner',
			),
			'event_date'     => array(
				'type'      => MegaCalRequest::TYPE_STRING,
				'required'  => true,
				'transform' => 'eventDate',
			),
			'start_time'     => array(
				'type'      => MegaCalRequest::TYPE_STRING,
				'required'  => false,
				'transform' => 'startTime',
			),
			'end_time'       => array(
				'type'      => MegaCalRequest::TYPE_STRING,
				'required'  => false,
				'transform' => 'endTime',
			),
			'description'    => array(
				'type'     => MegaCalRequest::TYPE_STRING,
				'required' => false,
			),
			'venue'          => array(
				'type'     => MegaCalRequest::TYPE_ARRAY,
				'required' => false,
				'vals'     => array(
					'id'       => array(
						'type'     => MegaCalRequest::TYPE_INT,
						'required' => false,
					),
					'name'     => array(
						'type'     => MegaCalRequest::TYPE_STRING,
						'required' => false,
					),
					'location' => array(
						'type'     => MegaCalRequest::TYPE_STRING,
						'required' => false,
					),
				),
			),
			'event_category' => array(
				'type'      => MegaCalRequest::TYPE_ARRAY,
				'required'  => false,
				'vals'      => array(
					'id'   => array(
						'type'     => MegaCalRequest::TYPE_INT,
						'required' => false,
					),
					'name' => array(
						'type'     => MegaCalRequest::TYPE_STRING,
						'required' => false,
					),
				),
				'transform' => 'category',
			),
			'tagged_users'   => array(
				'type'      => MegaCalRequest::TYPE_STRING,
				'multiple'  => true,
				'required'  => true,
				'transform' => 'taggedUsers',
			),
			'organizer'      => array(
				'type'     => MegaCalRequest::TYPE_STRING,
				'required' => false,
			),
			'private_note'   => array(
				'type'      => MegaCalRequest::TYPE_STRING,
				'required'  => false,
				'transform' => 'privateNote',
			),
			'facebook_url'   => array(
				'type'      => MegaCalRequest::TYPE_URL,
				'required'  => false,
				'transform' => 'facebookUrl',
			),
			'ticket_url'     => array(
				'type'      => MegaCalRequest::TYPE_URL,
				'required'  => false,
				'transform' => 'ticketUrl',
			),
			'price_details'  => array(
				'type'      => MegaCalRequest::TYPE_STRING,
				'required'  => false,
				'transform' => 'priceDetails',
			),
			'published'      => array(
				'type'     => MegaCalRequest::TYPE_BOOL,
				'required' => true,
			),
			'recurrence'	=> array(
				'type' => MegaCalRequest::TYPE_MODEL,
				'model' => EventRecurrenceDetail::class,
				'required' => false,
			),
		),

		self::LABEL_UPDATE     => array(
			'event_id'       => array(
				'type'      => MegaCalRequest::TYPE_INT,
				'required'  => true,
				'transform' => 'event-id',
			),
			'title'          => array(
				'type'     => MegaCalRequest::TYPE_STRING,
				'required' => false,
			),
			'image_url'      => array(
				'type'      => MegaCalRequest::TYPE_URL,
				'required'  => false,
				'transform' => 'imageUrl',
			),
			'image_url_square'      => array(
				'type'      => MegaCalRequest::TYPE_URL,
				'required'  => false,
				'transform' => 'imageUrlSquare',
			),
			'image_url_detail'      => array(
				'type'      => MegaCalRequest::TYPE_URL,
				'required'  => false,
				'transform' => 'imageUrlDetail',
			),
			'image_url_banner'      => array(
				'type'      => MegaCalRequest::TYPE_URL,
				'required'  => false,
				'transform' => 'imageUrlBanner',
			),
			'event_date'     => array(
				'type'      => MegaCalRequest::TYPE_STRING,
				'required'  => false,
				'transform' => 'eventDate',
			),
			'start_time'     => array(
				'type'      => MegaCalRequest::TYPE_STRING,
				'required'  => false,
				'transform' => 'startTime',
			),
			'end_time'       => array(
				'type'      => MegaCalRequest::TYPE_STRING,
				'required'  => false,
				'transform' => 'endTime',
			),
			'description'    => array(
				'type'     => MegaCalRequest::TYPE_STRING,
				'required' => false,
			),
			'venue'          => array(
				'type'     => MegaCalRequest::TYPE_ARRAY,
				'required' => false,
				'vals'     => array(
					'id'       => array(
						'type'     => MegaCalRequest::TYPE_INT,
						'required' => false,
					),
					'name'     => array(
						'type'     => MegaCalRequest::TYPE_STRING,
						'required' => false,
					),
					'location' => array(
						'type'     => MegaCalRequest::TYPE_STRING,
						'required' => false,
					),
				),
			),
			'event_category' => array(
				'type'      => MegaCalRequest::TYPE_ARRAY,
				'required'  => false,
				'vals'      => array(
					'id'   => array(
						'type'     => MegaCalRequest::TYPE_INT,
						'required' => false,
					),
					'name' => array(
						'type'     => MegaCalRequest::TYPE_STRING,
						'required' => false,
					),
				),
				'transform' => 'category',
			),
			'tagged_users'   => array(
				'type'      => MegaCalRequest::TYPE_STRING,
				'multiple'  => true,
				'required'  => false,
				'transform' => 'taggedUsers',
			),
			'organizer'      => array(
				'type'     => MegaCalRequest::TYPE_STRING,
				'required' => false,
			),
			'private_note'   => array(
				'type'      => MegaCalRequest::TYPE_STRING,
				'required'  => false,
				'transform' => 'privateNote',
			),
			'facebook_url'   => array(
				'type'      => MegaCalRequest::TYPE_URL,
				'required'  => false,
				'transform' => 'facebookUrl',
			),
			'ticket_url'     => array(
				'type'      => MegaCalRequest::TYPE_URL,
				'required'  => false,
				'transform' => 'ticketUrl',
			),
			'price_details'  => array(
				'type'      => MegaCalRequest::TYPE_STRING,
				'required'  => false,
				'transform' => 'priceDetails',
			),
			'published'      => array(
				'type'     => MegaCalRequest::TYPE_BOOL,
				'required' => false,
			),
			'recurrence'	=> array(
				'type' => MegaCalRequest::TYPE_MODEL,
				'model' => EventRecurrenceDetail::class,
				'required' => false,
			),
			'change_type' 	=> array(
				'type' => MegaCalRequest::TYPE_STRING,
				'transform' => 'changeType',
				'required' => true,
			),
		),

		self::LABEL_DETAIL     => array(
			'event_id' => array(
				'type'      => MegaCalRequest::TYPE_INT,
				'required'  => false,
				'transform' => 'event-id',
			),
		),

		self::LABEL_PUBLISH    => array(
			'event_id'  => array(
				'type'      => MegaCalRequest::TYPE_INT,
				'required'  => true,
				'transform' => 'event-id',
			),
			'published' => array(
				'type'     => MegaCalRequest::TYPE_BOOL,
				'required' => true,
			),
		),

		self::LABEL_LIST       => array(
			'start_date'  => array(
				'type'      => MegaCalRequest::TYPE_STRING,
				'required'  => false,
				'transform' => 'start-date',
			),
			'end_date'    => array(
				'type'      => MegaCalRequest::TYPE_STRING,
				'required'  => false,
				'transform' => 'end-date',
			),
			'upcoming'    => array(
				'type'     => MegaCalRequest::TYPE_BOOL,
				'required' => false,
			),
			'start_row'   => array(
				'type'      => MegaCalRequest::TYPE_INT,
				'required'  => false,
				'transform' => 'start-row',
			),
			'max_result'  => array(
				'type'      => MegaCalRequest::TYPE_INT,
				'required'  => false,
				'transform' => 'max-result',
			),
			'event_owner' => array(
				'type'      => MegaCalRequest::TYPE_INT,
				'required'  => false,
				'transform' => 'event-owner',
			),
			'venue'       => array(
				'type'     => MegaCalRequest::TYPE_INT,
				'required' => false,
			),
			'category'    => array(
				'type'     => MegaCalRequest::TYPE_INT,
				'multiple' => true,
				'required' => false,
			),
			'published'   => array(
				'type'     => MegaCalRequest::TYPE_BOOL,
				'required' => false,
			),
		),

		self::LABEL_FILTER     => array(
			'published' => array(
				'type'     => MegaCalRequest::TYPE_BOOL,
				'required' => false,
			),
		),

		self::LABEL_DELETE     => array(
			'event_id' => array(
				'type'     => MegaCalRequest::TYPE_INT,
				'required' => true,
			),
			'change_type' => array( 
				'type' => MegaCalRequest::TYPE_STRING,
				'required' => true,
				'transform' => 'change-type',
			),
		),

		self::LABEL_RECURRENCE => array(
			'event_date' => array(
				'type'     => MegaCalRequest::TYPE_STRING,
				'required' => false,
				'transform' => 'event-date',
			),
		),

		self::LABEL_PROCESSING => array(
			'execution_id' => array(
				'type' => MegaCalRequest::TYPE_STRING,
				'required' => true,
				'transform' => 'Execution-Id',
			)
		),

	);

	/**
	 **	endpoint: GET /event/{eventId}/upsert
	 ** 	Get event details for upsert
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return EventUpsertBodyResponse The upsert response body
	 **/
	public function get_event_upsert( $args = array() ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_UPSERT];
		$args             = $this->sanitize_and_transform_args( $args, $validation_rules );

		$event_id = $args['event-id'];
		unset( $args['event-id'] );

		$request = sprintf( '%s/%d/%s', self::BASE_ENDPOINT, $event_id, self::FETCH_UPSERT_ENDPOINT );

		$response              = $this->client->call( $request, MegaCalClient::$GET, $args );
		$event_upsert_response = new EventUpsertBodyResponse( $response, $args, $request );

		return $event_upsert_response;

	}

	/**
	 **	endpoint: GET /event/upsert
	 ** 	Get details for a new upsert
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return EventUpsertBodyResponse The upsert response body
	 **/
	public function get_new_upsert( $args = array() ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_UPSERT_NEW];
		$args             = $this->sanitize_and_transform_args( $args, $validation_rules );

		$request = sprintf( '%s/%s', self::BASE_ENDPOINT, self::FETCH_UPSERT_ENDPOINT );

		$response              = $this->client->call( $request, MegaCalClient::$GET, $args );
		$event_upsert_response = new EventUpsertBodyResponse( $response, $args, $request );

		return $event_upsert_response;

	}

	/**
	 **	endpoint: POST /event
	 ** 	Create new event
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return EventUpsertResponse The upsert response
	 **/
	public function create_event( $args = array() ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_CREATE];
		$request          = self::BASE_ENDPOINT;

		$args = $this->sanitize_and_transform_args( $args, $validation_rules );

		$params = array();

		$response              = $this->client->call( $request, MegaCalClient::$POST, $params, $args );
		$event_upsert_response = new EventUpsertResponse( $response, $args, $request );

		return $event_upsert_response;

	}

	/**
	 **	endpoint: PUT /event/{eventId}
	 ** 	Update event details
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return EventUpsertResponse The upsert response
	 **/
	public function update_event( $args = array() ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_UPDATE];
		$args             = $this->sanitize_and_transform_args( $args, $validation_rules );

		$event_id = $args['event-id'];
		unset( $args['event-id'] );

		$request = sprintf( '%s/%d', self::BASE_ENDPOINT, $event_id );

		$params    = array();
		$body_args = $args;

		$response              = $this->client->call( $request, MegaCalClient::$PUT, $params, $body_args );
		$event_upsert_response = new EventUpsertResponse( $response, $args, $request );

		return $event_upsert_response;

	}

	/**
	 **	endpoint: GET /event/{eventId}
	 ** 	Fetch event details
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return EventDetailResponse The event detail response
	 **/
	public function get_event( $args = array() ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_DETAIL];
		$args             = $this->sanitize_and_transform_args( $args, $validation_rules );

		$event_id = $args['event-id'];
		unset( $args['event-id'] );

		$request = sprintf( '%s/%d', self::BASE_ENDPOINT, $event_id );

		$response              = $this->client->call( $request, MegaCalClient::$GET, $args );
		$event_detail_response = new EventDetailResponse( $response, $args, $request );

		return $event_detail_response;

	}

	/**
	 **	endpoint: PUT /event/{eventId}/publish
	 ** 	Publish an event
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return EventPublishResponse The publish response
	 **/
	public function publish_event( $args = array() ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_PUBLISH];
		$args             = $this->sanitize_and_transform_args( $args, $validation_rules );

		$event_id = $args['event-id'];
		unset( $args['event-id'] );

		$request = sprintf( '%s/%d/%s', self::BASE_ENDPOINT, $event_id, self::PUBLISH_ENDPOINT );

		$params = $args;

		$response               = $this->client->call( $request, MegaCalClient::$PATCH, $params );
		$event_publish_response = new EventPublishResponse( $response, $args, $request );

		return $event_publish_response;

	}

	/**
	 **	endpoint: GET /event
	 ** 	Fetch list of events
	 **
	 **	@param array $args 	The api endpoint params
	 **
	 ** @return EventListResponse The event list response
	 **/
	public function get_events( $args = array() ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_LIST];
		$args             = $this->sanitize_and_transform_args( $args, $validation_rules );

		$request = self::BASE_ENDPOINT;

		$response            = $this->client->call( $request, MegaCalClient::$GET, $args );
		$event_list_response = new EventListResponse( $response, $args, $request );

		return $event_list_response;

	}

	/**
	 **	endpoint: GET /event/filter
	 ** 	Get event list filters
	 **
	 ** @return EventFilterResponse The filter response
	 **/
	public function get_event_filters( $args = array() ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_FILTER];
		$args             = $this->sanitize_and_transform_args( $args, $validation_rules );

		$request = sprintf( '%s/%s', self::BASE_ENDPOINT, self::FILTER_ENDPOINT );

		$response            = $this->client->call( $request, MegaCalClient::$GET, $args );
		$event_list_response = new EventFilterResponse( $response, $args, $request );

		return $event_list_response;

	}

	/**
	 ** endpoint: DELETE /event/{event_id}
	 ** 	Delete an event by id
	 **
	 ** @return EventDeleteResponse The delete event response
	 */
	public function delete_event( $args = array() ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_DELETE];
		$args             = $this->sanitize_and_transform_args( $args, $validation_rules );

		$request = sprintf( '%s/%d', untrailingslashit( self::BASE_ENDPOINT ), $args['event_id'] );

		unset( $args['event_id'] );

		$response              = $this->client->call( $request, MegaCalClient::$DELETE, $args );
		$event_delete_response = new EventDeleteResponse( $response, $args, $request );

		return $event_delete_response;

	}

	/**
	 * endpoint: GET /event/recurrence
	 * 		Get details for recurrence event for event creation
	 *
	 * @return EventRecurrenceResponse The event recurrence response
	 */
	public function get_event_recurrence( $args = array() ) {

		$validation_rules = self::VALIDATION_RULES[self::LABEL_RECURRENCE];
		$args             = $this->sanitize_and_transform_args( $args, $validation_rules );
		$request          = self::RECURRENCE_ENDPOINT;

		$response              = $this->client->call( $request, MegaCalClient::$GET, $args );
		$event_recurrence_response = new EventRecurrenceResponse( $response, $args, $request );

		return $event_recurrence_response; 

	}

	/** 
	 * endpoint: GET /event/processing
	 */
	public function get_event_processing( $args = array() ) {

		// Execution-Id
		$validation_rules = self::VALIDATION_RULES[self::LABEL_PROCESSING];
		$args             = $this->sanitize_and_transform_args( $args, $validation_rules );
		$request          = self::PROCESSING_ENDPOINT;

		$response         = $this->client->call( $request, MegaCalClient::$GET, array(), array(), $args );
		$event_processing_response = new EventProcessingResponse( $response, $args, $request );

		return $event_processing_response; 

	}

}
