<?php

namespace MegaCal\Client;

class WeeklyCustomRecurrence extends MegaCalModel {

	const VALIDATION_RULES = array(
		'endCondition' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
			'method_name' => 'end_condition',
		),
		'repeatOn' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
			'method_name' => 'repeat_on',
			'required' => true,
		),
		'selectedDayOfWeek' => array(
			'type' => MegaCalModel::TYPE_STRING,
			'method_name' => 'selected_day_of_week',
		),
	);

	protected $end_condition;
	protected $repeat_on;
	protected $selected_day_of_week;

	public function __construct( $data ) {

		$this->store_data( $data, self::VALIDATION_RULES );

	}

	/** Getters & Setters */		
		protected function set_end_condition( $end_condition ) { $this->end_condition = new EndCondition( $end_condition ); }
		public function get_end_condition() { return $this->end_condition; }

		protected function set_repeat_on( $repeat_on ) { 

			foreach( $repeat_on as $day ) {
				
				if( !in_array( $day, WeeklyRecurrence::DAYS ) ) {
					throw new ApiException( sprintf( '%s: Invalid repeat_on value: %s', __METHOD__, $day ) );
				}

			}

			$this->repeat_on = $repeat_on;

		}
		public function get_repeat_on() { return $this->repeat_on; }

		protected function set_selected_day_of_week( $selected_day_of_week ) {

			if( !in_array( $selected_day_of_week, WeeklyRecurrence::DAYS ) ) {
				throw new ApiException( sprintf( '%s: Invalid repeat_on value: %s', __METHOD__, $selected_day_of_week ) );
			}

			$this->selected_day_of_week = $selected_day_of_week;

		}
		public function get_selected_day_of_week() { return $this->selected_day_of_week; }
	
}