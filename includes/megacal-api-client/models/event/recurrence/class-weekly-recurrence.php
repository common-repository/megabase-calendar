<?php

namespace MegaCal\Client;

class WeeklyRecurrence extends MegaCalModel {

	const DAYS = array(
		'SUNDAY',
		'MONDAY',
		'TUESDAY',
		'WEDNESDAY',
		'THURSDAY',
		'FRIDAY',
		'SATURDAY',
	);

	const VALIDATION_RULES = array(
		'dayOfWeek' => array(
			'type' => MegaCalModel::TYPE_STRING,
			'required' => true,
			'method_name' => 'day_of_week',
		),
	);

	protected $day_of_week;

	public function __construct( $data ) {

		$this->store_data( $data, self::VALIDATION_RULES );

	}

	/** Getters & Setters */		
		protected function set_day_of_week( $day_of_week ) { 
			
			if( !in_array( $day_of_week, self::DAYS ) ) {
				throw new ApiException( sprintf( 'Invalid day_of_week value. %s', __METHOD__ ) );
			}
			
			$this->day_of_week = $day_of_week; 

		}
		public function get_day_of_week() { return $this->day_of_week; }
		  	
}