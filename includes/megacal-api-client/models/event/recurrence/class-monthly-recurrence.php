<?php

namespace MegaCal\Client;

class MonthlyRecurrence extends MegaCalModel {

	const VALIDATION_RULES = array(
		'dayOfWeek' => array(
			'type' => MegaCalModel::TYPE_STRING,
			'required' => true,
			'method_name' => 'day_of_week',
		),
		'weekOfMonth' => array(
			'type' => MegaCalModel::TYPE_INT,
			'required' => false,
			'method_name' => 'week_of_month',
		),
		'lastDayOfWeek' => array(
			'type' => MegaCalModel::TYPE_BOOL,
			'required' => false,
			'method_name' => 'last_day_of_week',
		),
	);

	protected $day_of_week;
	protected $week_of_month;
	protected $last_day_of_week;

	public function __construct( $data ) {

		$this->store_data( $data, self::VALIDATION_RULES );

	}

	/** Getters & Setters */		
		protected function set_day_of_week( $day_of_week ) { 
			
			if( !in_array( $day_of_week, WeeklyRecurrence::DAYS ) ) {
				throw new ApiException( sprintf( 'Invalid day_of_week value. %s', __METHOD__ ) );
			}
			
			$this->day_of_week = $day_of_week; 

		}
		public function get_day_of_week() { return $this->day_of_week; }
		
		protected function set_week_of_month( $week_of_month ) { 
			$this->week_of_month = intval( $week_of_month ); 
		}
		public function get_week_of_month() { return $this->week_of_month; }

		protected function set_last_day_of_week( $last_day_of_week ) { $this->last_day_of_week = boolval( $last_day_of_week ); }
		public function get_last_day_of_week() { return $this->last_day_of_week; }
		
}