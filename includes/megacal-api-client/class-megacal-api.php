<?php
/**
 * MegaCal API
 *
 * API wrapper for MegaCal WordPress plugins
 */

namespace MegaCal\Client;

class MegaCalAPI {

	private static $instance;

	const EVENT_REQUEST = 'event';
	const AUTH_REQUEST = 'auth';
	const PING_REQUEST = 'ping';
	const USER_REQUEST = 'user';
	const VENUE_REQUEST = 'venue';
	const CATEGORY_REQUEST = 'category';

	// Recurrence Chagne Types
	const UPDATE_THIS = 'UPDATE_THIS';
	const UPDATE_THIS_ONWARD = 'UPDATE_THIS_ONWARD';
	const UPDATE_ALL = 'UPDATE_ALL';

	const DELETE_THIS = 'DELETE_THIS';
	const DELETE_THIS_ONWARD = 'DELETE_THIS_ONWARD';
	const DELETE_ALL = 'DELETE_ALL';

	private static $event_request;
	private static $auth_request;
	private static $ping_request;
	private static $user_request;
	private static $venue_request;
	private static $category_request;

	private function __construct() {

		self::$event_request = new EventRequest();
		self::$auth_request = new AuthRequest();
		self::$user_request = new UserRequest();
		self::$ping_request = new PingRequest();
		self::$venue_request = new VenueRequest();
		self::$category_request = new CategoryRequest();

	}

	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new MegaCalAPI();
		}

		return self::$instance;

	}

	/**
	 *  Make an API request
	 *
	 * @param  string $type     	The type of request
	 * @param  string $action 		The request action
	 * @param  array  $args     	The request parameters
	 *
	 * @return MegaCalResponse 	The response object
	 */
	public static function request( $request_type, $action, $args = array() ) {

		$current_request = null;

		switch ( strtolower( $request_type ) ) {
		case self::EVENT_REQUEST:
			$current_request = self::$event_request;
			break;
		case self::AUTH_REQUEST:
			$current_request = self::$auth_request;
			break;
		case self::PING_REQUEST:
			$current_request = self::$ping_request;
			break;
		case self::USER_REQUEST:
			$current_request = self::$user_request;
			break;
		case self::VENUE_REQUEST:
			$current_request = self::$venue_request;
			break;
		case self::CATEGORY_REQUEST:
			$current_request = self::$category_request;
			break;	
		default:
			throw new ApiException( 'Invalid request type: "' . $request_type . '"' );
			break;
		}

		if ( null === $current_request ) {
			throw new ApiException( 'Request was null' );
		}

		if ( false === method_exists( $current_request, $action ) ) {
			throw new ApiException( 'Invalid request action: "' . $action . '"' );
		}

		// finally call the method
		$response = false;

		if ( ! empty( $args ) ) {
			$response = $current_request->$action( $args );
		} else {
			$response = $current_request->$action();
		}

		return $response;

	}

}