<?php

namespace MegaCal\Client;

class CustomRecurrence extends MegaCalModel {

	const RECURRENCE_TYPES = array(
		EventRecurrenceDetail::TYPE_DAILY,
		EventRecurrenceDetail::TYPE_WEEKLY,
		EventRecurrenceDetail::TYPE_MONTHLY,
		EventRecurrenceDetail::TYPE_ANNUALLY,	
	);

	const VALIDATION_RULES = array(
		'endCondition' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
			'method_name' => 'end_condition',
		),
		'availableTypes' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
			'method_name' => 'available_types',
		),
		'type' => array(
			'type' => MegaCalModel::TYPE_STRING,
		),
		'repetition' => array(
			'type' => MegaCalModel::TYPE_INT,
			'required' => true,
		),
		'dailyCustom' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
			'method_name' => 'daily_custom',
		),
		'weeklyCustom' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
			'method_name' => 'weekly_custom',
		),
		'monthlyCustom' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
			'method_name' => 'monthly_custom',
		),
		'annuallyCustom' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
			'method_name' => 'annually_custom',
		),
	);

	protected $end_condition;
	protected $available_types;
	protected $type;
	protected $repetition;
	protected $daily_custom;
	protected $weekly_custom;
	protected $monthly_custom;
	protected $annually_custom;

	public function __construct( $data ) {

		$this->store_data( $data, self::VALIDATION_RULES );

	}

	/** Getters & Setters */		
		protected function set_end_condition( $end_condition ) { $this->end_condition = new EndCondition( $end_condition ); }
		public function get_end_condition() { return $this->end_condition; } 

		protected function set_available_types( $available_types ) { 
			
			foreach( $available_types as $type ) {
				if( in_array( $type, self::RECURRENCE_TYPES ) ) {
					$this->available_types[] = $type; 
				}
			}

		}
		public function get_available_types() { return $this->available_types; } 

		protected function set_type( $type ) { 

			if( !in_array( $type, self::RECURRENCE_TYPES ) ) {
				throw new ApiException( sprintf( '%s: Invalid custom recurrence type: %s', __METHOD__, $type ) );
			}

			$this->type = $type; 

		}
		public function get_type() { return $this->type; } 

		protected function set_repetition( $repetition ) { $this->repetition = intval( $repetition ); }
		public function get_repetition() { return $this->repetition; } 

		protected function set_daily_custom( $daily_custom ) { $this->daily_custom = new DailyCustomRecurrence( $daily_custom ); }
		public function get_daily_custom() { return $this->daily_custom; } 

		protected function set_weekly_custom( $weekly_custom ) { $this->weekly_custom = new WeeklyCustomRecurrence( $weekly_custom ); }
		public function get_weekly_custom() { return $this->weekly_custom; } 

		protected function set_monthly_custom( $monthly_custom ) { $this->monthly_custom = new MonthlyCustomRecurrence( $monthly_custom ); }
		public function get_monthly_custom() { return $this->monthly_custom; } 

		protected function set_annually_custom( $annually_custom ) { $this->annually_custom = new AnnuallyCustomRecurrence( $annually_custom ); }
		public function get_annually_custom() { return $this->annually_custom; } 

}