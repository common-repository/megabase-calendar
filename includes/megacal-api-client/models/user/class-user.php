<?php

namespace MegaCal\Client;

class User extends MegaCalModel {

	const VALIDATION_RULES = array(
		'id' => array(
			'type' => MegaCalModel::TYPE_INT
		),
		'handle' => array(
			'type' => MegaCalModel::TYPE_STRING
		),
		'proAccount' => array(
			'type' => MegaCalModel::TYPE_BOOL,
			'method_name' => 'pro_account',
		),
		'calendarName' => array(
			'type' => MegaCalModel::TYPE_STRING,
			'method_name' => 'calendar_name',
		),
	);

	protected $handle;
	protected $pro_account;
	protected $calendar_name;

	public function __construct( $data ) {

		$this->store_data( $data, self::VALIDATION_RULES );

	}

	/** Getters & Setters */		
		protected function set_handle( $handle ) { $this->handle = $handle; }
		public function get_handle() { return $this->handle; }

		protected function set_pro_account( $pro_account ) { $this->pro_account = boolval( $pro_account ); }
		public function get_pro_account() { return $this->pro_account; }

		protected function set_calendar_name( $calendar_name ) { $this->calendar_name = $calendar_name; }
		public function get_calendar_name() { return $this->calendar_name; }
		  	
}