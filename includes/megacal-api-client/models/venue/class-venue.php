<?php

namespace MegaCal\Client;

class Venue extends MegaCalModel {

	const VALIDATION_RULES = array(
		'id' => array(
			'type' => MegaCalModel::TYPE_INT,
		),
		'name' => array(
			'type' => MegaCalModel::TYPE_STRING,
		),
		'location' => array(
			'type' => MegaCalModel::TYPE_STRING,
		),
		'published' => array(
			'type' => MegaCalModel::TYPE_BOOL,
		),
	);

	protected $name;
	protected $location;
	protected $published;

	public function __construct( $data ) {

		$this->store_data( $data, self::VALIDATION_RULES );

	}

	/** Getters & Setters */
		protected function set_name( $name ) { $this->name = $name; }
		public function get_name() { return $this->name; }
		
		protected function set_location( $location ) { $this->location = $location; }
		public function get_location() { return $this->location; }

		protected function set_published( $published ) { $this->published = boolval( $published ); }
		public function get_published() { return $this->published; }
		  	
}