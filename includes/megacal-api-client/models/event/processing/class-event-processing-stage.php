<?php

namespace MegaCal\Client;

class EventProcessingStage extends MegaCalModel {

	const STAGE_PROCESS_EVENT_USER = 'PROCESS_EVENT_USER'; 
	const STAGE_VALIDATE_PRO_ACCOUNT = 'VALIDATE_PRO_ACCOUNT'; 
	const STAGE_PROCESS_AUTO_APPROVAL = 'PROCESS_AUTO_APPROVAL'; 
	const STAGE_GENERATE_RECURRING_EVENT_DATES = 'GENERATE_RECURRING_EVENT_DATES'; 
	const STAGE_PROCESS_EVENT_RECURRENCE = 'PROCESS_EVENT_RECURRENCE'; 
	const STAGE_PROCESS_CHANGE_EVENT_RECURRENCE = 'PROCESS_CHANGE_EVENT_RECURRENCE'; 
	const STAGE_PROCESS_RECURRING_EVENT_ATTRIBUTE = 'PROCESS_RECURRING_EVENT_ATTRIBUTE'; 
	const STAGE_PROCESS_EVENT_DELETION = 'PROCESS_EVENT_DELETION';
	const PHASES = array(
		'IN_PROGRESS', 
		'FAILED', 
		'TERMINATED',
		'COMPLETED',
	);

	const PHASE_TYPE_IN_PROGRESS = 'IN_PROGRESS';
	const PHASE_TYPE_FAILED = 'FAILED';
	const PHASE_TYPE_TERMINATED = 'TERMINATED';
	const PHASE_TYPE_COMPLETED = 'COMPLETED';

	const VALIDATION_RULES = array(
		'startTimestamp' => array(
			'type' => MegaCalModel::TYPE_DATE,
			'format' => 'Y-m-d\TH:i:s\Z',
			'method_name' => 'start_timestamp',
		),
		'endTimestamp' => array(
			'type' => MegaCalModel::TYPE_DATE,
			'format' => 'Y-m-d\TH:i:s\Z',
			'method_name' => 'end_timestamp',
		),
		'name' => array(
			'type' => MegaCalModel::TYPE_STRING,
		),
		'phase' => array(
			'type' => MegaCalModel::TYPE_STRING,
		),
		'messageId' => array(
			'type' => MegaCalModel::TYPE_STRING,
			'method_name' => 'message_id',
		),
	);

	protected $start_timestamp;
	protected $end_timestamp;
	protected $name;
	protected $phase;
	protected $message_id;

	public function __construct( $data ) {
		$this->store_data( $data, self::VALIDATION_RULES );
	}

	/** Getters & Setters */		
		protected function set_start_timestamp( $start_timestamp ) { $this->start_timestamp = $start_timestamp; }
		public function get_start_timestamp() { return $this->start_timestamp; }
		  	
		protected function set_end_timestamp( $end_timestamp ) { $this->end_timestamp = $end_timestamp; }
		public function get_end_timestamp() { return $this->end_timestamp; }

		protected function set_name( $name ) { $this->name = $name; }
		public function get_name() { return $this->name; }

		protected function set_phase( $phase ) { 
			$this->phase = $phase; 
		}
		public function get_phase() { return $this->phase; }

		protected function set_message_id( $message_id ) { $this->message_id = $message_id; }
		public function get_message_id() { return $this->message_id; }

}