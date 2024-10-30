<?php

namespace MegaCal\Client;

class TaggedUser extends User {

	const VALIDATION_RULES = array(

		'id' => array(
			'type' => MegaCalModel::TYPE_INT
		),
		'handle' => array(
			'type' => MegaCalModel::TYPE_STRING
		),
		'status' => array(
			'type' => MegaCalModel::TYPE_STRING
		),
		'valid' => array(
			'type' => MegaCalModel::TYPE_BOOL
		),
		'proAccount' => array(
			'type' => MegaCalModel::TYPE_BOOL,
			'method_name' => 'pro_account',
		),
		
	);

	// User Status Constants
	const STATUS_APPROVAL_REQUESTED = "APPROVAL_REQUESTED"; 
	const STATUS_APPROVED = "APPROVED"; 
	const STATUS_AUTO_APPROVED = "AUTO_APPROVED"; 
	const STATUS_INACTIVE_USER = "INACTIVE_USER"; 
	const STATUS_INVALID_CUSTOMER_ID = "INVALID_CUSTOMER_ID"; 
	const STATUS_INVALID_HANDLE = "INVALID_HANDLE"; 
	const STATUS_NON_PRO = "NON_PRO"; 
	const STATUS_PRE_VALIDATE = "PRE_VALIDATE"; 
	const STATUS_PRO_EXPIRED = "PRO_EXPIRED"; 
	const STATUS_REJECTED = "REJECTED"; 

	protected $valid;
	protected $status;

	public function __construct( $data ) {

		$this->store_data( $data, self::VALIDATION_RULES );

	}

	/** Getters & Setters */		
		protected function set_valid( $valid ) { $this->valid = boolval( $valid ); }
		public function get_valid() { return $this->valid; }

		protected function set_status( $status ) { $this->status = $status; }
		public function get_status() { return $this->status; }	

}