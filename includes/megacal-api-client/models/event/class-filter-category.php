<?php

namespace MegaCal\Client;

use MegaCal\Client\EventCategory;

class FilterCategory extends EventCategory {

	const VALIDATION_RULES = array(
		'owner' => array(
			'type' => MegaCalModel::TYPE_BOOL,
		),
		'count' => array(
			'type' => MegaCalModel::TYPE_INT,
		),
	);

	protected $owner;
	protected $count;

	public function __construct( $data ) {

		parent::__construct( $data );
		$this->store_data( $data, self::VALIDATION_RULES );

	}

	/** Getters & Setters */		
		protected function set_owner( $owner ) { $this->owner = boolval( $owner ); }
		public function get_owner() { return $this->owner; }
		  	
		protected function set_count( $count ) { $this->count = intval( $count ); }
		public function get_count() { return $this->count; }
}