<?php

namespace MegaCal\Client;

class EndCondition extends MegaCalModel {

	const VALIDATION_RULES = array(
		'on' => array(
			'type' => MegaCalModel::TYPE_DATE,
			'format' => 'Y-m-d',
		),
		'afterOccurrence' => array(
			'type' => MegaCalModel::TYPE_INT,
			'method_name' => 'after_occurrence',
		),
	);

	protected $on;
	protected $after_occurrence;

	public function __construct( $data ) {

		$this->store_data( $data, self::VALIDATION_RULES );

	}

	/** Getters & Setters */		
		protected function set_on( $on ) { $this->on = $on; }
		public function get_on() { return $this->on; }

		protected function set_after_occurrence( $after_occurrence ) { $this->after_occurrence = intval( $after_occurrence ); }
		public function get_after_occurrence() { return $this->after_occurrence; }
		  	
}