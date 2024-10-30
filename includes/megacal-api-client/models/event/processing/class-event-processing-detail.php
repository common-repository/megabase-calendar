<?php

namespace MegaCal\Client;

class EventProcessingDetail extends MegaCalModel {

	const EXECUTION_TYPES = array(
		'INSERT', 
		'UPDATE', 
		'DELETE',
	);

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
		'executionType' => array(
			'type' => MegaCalModel::TYPE_STRING,
			'method_name' => 'execution_type',
		),
		'phase' => array(
			'type' => MegaCalModel::TYPE_STRING,
		),
		'stages' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
		),
	);

	protected $start_timestamp;
	protected $end_timestamp;
	protected $execution_type;
	protected $phase;
	protected $stages;

	public function __construct( $data ) {

		$this->store_data( $data, self::VALIDATION_RULES );

	}

	/** Getters & Setters */		
		protected function set_start_timestamp( $start_timestamp ) { $this->start_timestamp = $start_timestamp; }
		public function get_start_timestamp() { return $this->start_timestamp; }
		  	
		protected function set_end_timestamp( $end_timestamp ) { $this->end_timestamp = $end_timestamp; }
		public function get_end_timestamp() { return $this->end_timestamp; }

		protected function set_execution_type( $execution_type ) { 

			if( !in_array( $execution_type, self::EXECUTION_TYPES ) ) {
				throw new ApiException( sprintf( 'Unexpected execution type: "%s"', $execution_type ) );
			}
			$this->execution_type = $execution_type;

		}
		public function get_execution_type() { return $this->execution_type; }

		protected function set_phase( $phase ) { 
			$this->phase = $phase; 
		}
		public function get_phase() { return $this->phase; }

		protected function set_stages( $stages ) { 

			$this->stages = array();
			foreach( $stages as $stage ) {
				$this->stages[] = new EventProcessingStage( $stage ); 
			}

		}
		public function get_stages() { return $this->stages; }

}