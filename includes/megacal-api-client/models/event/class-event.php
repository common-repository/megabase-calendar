<?php

namespace MegaCal\Client;

class Event extends MegaCalModel {

	const VALIDATION_RULES = array(
		'id' => array(
			'type' => MegaCalModel::TYPE_INT
		),
		'title' => array(
			'type' => MegaCalModel::TYPE_STRING
		),
		'imageUrl' => array(
			'type' => MegaCalModel::TYPE_STRING,
			'method_name' => 'image_url',
		),
		'imageUrlSquare'      => array(
			'type'      => MegaCalRequest::TYPE_URL,
			'required'  => false,
			'method_name' => 'image_url_square',
		),
		'imageUrlDetail'      => array(
			'type'      => MegaCalRequest::TYPE_URL,
			'required'  => false,
			'method_name' => 'image_url_detail',
		),
		'imageUrlBanner'      => array(
			'type'      => MegaCalRequest::TYPE_URL,
			'required'  => false,
			'method_name' => 'image_url_banner',
		),
		'eventDate' => array(
			'type' => MegaCalModel::TYPE_DATE,
			'format' => 'Y-m-d',
			'method_name' => 'event_date',
		),
		'startTime' => array(
			'type' => MegaCalModel::TYPE_STRING,
			'method_name' => 'start_time',
		),
		'endTime' => array(
			'type' => MegaCalModel::TYPE_STRING,
			'method_name' => 'end_time',
		),
		'description' => array(
			'type' => MegaCalModel::TYPE_STRING
		),
		'venue' => array(
			'type' => MegaCalModel::TYPE_ARRAY
		),
		'owner' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
		),
		'category' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
			'method_name' => 'event_category',
		),
		'organizer' => array(
			'type' => MegaCalModel::TYPE_STRING
		),
		'privateNote' => array(
			'type' => MegaCalModel::TYPE_STRING,
			'method_name' => 'private_note',
		),
		'facebookUrl' => array(
			'type' => MegaCalModel::TYPE_STRING,
			'method_name' => 'facebook_url',
		),
		'ticketUrl' => array(
			'type' => MegaCalModel::TYPE_STRING,
			'method_name' => 'ticket_url',
		),
		'priceDetails' => array(
			'type' => MegaCalModel::TYPE_STRING,
			'method_name' => 'price_details',
		),
		'published' => array(
			'type' => MegaCalModel::TYPE_BOOL
		),
		'taggedUsers' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
			'method_name' => 'tagged_users',
		),
		'createdByMe' => array(
			'type' => MegaCalModel::TYPE_BOOL,
			'method_name' => 'created_by_me',
		),
		'recurrence' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
		)
	);
	
	protected $title;
	protected $image_url;
	protected $image_url_square;
	protected $image_url_detail;
	protected $image_url_banner;
	protected $event_date;
	protected $start_time;
	protected $end_time;
	protected $description;
	protected $venue;
	protected $owner;
	protected $event_category;
	protected $organizer;
	protected $private_note;
	protected $facebook_url;
	protected $ticket_url;
	protected $price_details;
	protected $published;
	protected $tagged_users = array();
	protected $created_by_me;
	protected $recurrence;

	public function __construct( $data ) {

		$this->store_data( $data, self::VALIDATION_RULES );

	}

	/** Getters & Setters */

		protected function set_title( $title ) { $this->title = $title; }
		public function get_title() { return $this->title; }

		protected function set_image_url( $image_url ) { $this->image_url = $image_url; }
		public function get_image_url() { return $this->image_url; }

		protected function set_image_url_square( $image_url_square ) { $this->image_url_square = $image_url_square; }
		/**
		 * get_image_url_square
		 * Returns the event image at the size 'square'
		 * 
		 * @return string The event image url at size 'square', or the full-size image if empty
		 */
		public function get_image_url_square() { 
			return !empty( $this->image_url_square ) ? 
				$this->image_url_square 
				: $this->get_image_url();
		}

		protected function set_image_url_detail( $image_url_detail ) { $this->image_url_detail = $image_url_detail; }
		/**
		 * get_image_url_detail
		 * Returns the event image at the size 'detail'
		 * 
		 * @return string The event image url at size 'detail', or the full-size image if empty
		 */
		public function get_image_url_detail() { 
			return !empty( $this->image_url_detail ) ? 
				$this->image_url_detail 
				: $this->get_image_url();
		}

		protected function set_image_url_banner( $image_url_banner ) { $this->image_url_banner = $image_url_banner; }
		/**
		 * get_image_url_banner
		 * Returns the event image at the size 'banner'
		 * 
		 * @return string The event image url at size 'banner', or the full-size image if empty
		 */
		public function get_image_url_banner() { 
			return !empty( $this->image_url_banner ) ? 
				$this->image_url_banner 
				: $this->get_image_url();
		}

		protected function set_event_date( $event_date ) { $this->event_date = $event_date; }
		public function get_event_date() { return $this->event_date; }

		protected function set_start_time( $start_time ) { $this->start_time = $start_time; }
		public function get_start_time() { return $this->start_time; }

		protected function set_end_time( $end_time ) { $this->end_time = $end_time; }
		public function get_end_time() { return $this->end_time; }

		protected function set_description( $description ) { $this->description = $description; }
		public function get_description() { return $this->description; }
		
		protected function set_venue( $venue ) { $this->venue = new Venue( $venue ); }
		public function get_venue() { return $this->venue; }
		
		protected function set_owner( $owner ) { $this->owner = new User( $owner ); }
		public function get_owner() { return $this->owner; }

		protected function set_event_category( $event_category ) { $this->event_category = new EventCategory( $event_category ); }
		public function get_event_category() { return $this->event_category; }

		protected function set_organizer( $organizer ) { $this->organizer = $organizer; }
		public function get_organizer() { return $this->organizer; }
		
		protected function set_private_note( $private_note ) { $this->private_note = $private_note; }
		public function get_private_note() { return $this->private_note; }
		
		protected function set_facebook_url( $facebook_url ) { $this->facebook_url = $facebook_url; }
		public function get_facebook_url() { return $this->facebook_url; }
		
		protected function set_ticket_url( $ticket_url ) { $this->ticket_url = $ticket_url; }
		public function get_ticket_url() { return $this->ticket_url; }
		
		protected function set_price_details( $price_details ) { $this->price_details = $price_details; }
		public function get_price_details() { return $this->price_details; }
		
		protected function set_published( $published ) { $this->published = $published; }
		public function get_published() { return $this->published; }

		protected function set_tagged_users( $tagged_users ) { 

			foreach( $tagged_users as $user ) {
				$this->tagged_users[] = new TaggedUser( $user ); 
			}

		}
		public function get_tagged_users() { return $this->tagged_users; }

		protected function set_created_by_me( $created_by_me ) { $this->created_by_me = boolval( $created_by_me ); }
		public function get_created_by_me() { return $this->created_by_me; }

		protected function set_recurrence( $recurrence ) { $this->recurrence = new EventRecurrenceDetail( $recurrence ); }
		public function get_recurrence() { return $this->recurrence; }

}