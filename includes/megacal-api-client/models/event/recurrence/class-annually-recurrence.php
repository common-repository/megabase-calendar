<?php

namespace MegaCal\Client;

class AnnuallyRecurrence extends MegaCalModel {

	const MONTHS = array(
		'JANUARY',
		'FEBRUARY',
		'MARCH',
		'APRIL',
		'MAY',
		'JUNE',
		'JULY',
		'AUGUST',
		'SEPTEMBER',
		'OCTOBER',
		'NOVEMBER',
		'DECEMBER',
	);

	const VALIDATION_RULES = array(
		'dayOfMonth' => array(
			'type' => MegaCalModel::TYPE_INT,
			'required' => true,
			'method_name' => 'day_of_month',
		),
		'month' => array(
			'type' => MegaCalModel::TYPE_STRING,
			'required' => true,
		),
	);

	protected $day_of_month;
	protected $month;

	public function __construct( $data ) {

		$this->store_data( $data, self::VALIDATION_RULES );

	}

	/** Getters & Setters */		
		protected function set_day_of_month( $day_of_month ) { $this->day_of_month = intval( $day_of_month ); }
		public function get_day_of_month() { return $this->day_of_month; }
		
		protected function set_month( $month ) { 
			
			if( !in_array( $month, self::MONTHS ) ) {
				throw new ApiException( sprintf( '%s: Invalid month value: %s', __METHOD__, $month ) );
			}
			
			$this->month = $month; 

		}
		public function get_month() { return $this->month; }
		
}