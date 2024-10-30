<?php

namespace MegaCal\Client;

class AnnuallyCustomRecurrence extends MegaCalModel {

	const VALIDATION_RULES = array(
		'endCondition' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
			'method_name' => 'end_condition',
		),
	);

	protected $end_condition;

	public function __construct( $data ) {

		$this->store_data( $data, self::VALIDATION_RULES );

	}

	/** Getters & Setters */		
		protected function set_end_condition( $end_condition ) { $this->end_condition = new EndCondition( $end_condition ); }
		public function get_end_condition() { return $this->end_condition; }

}