<?php

namespace MegaCal\Client;

class EventRecurrenceDetail extends MegaCalModel {

	const TYPE_DAILY    = 'DAILY';
	const TYPE_WEEKLY   = 'WEEKLY';
	const TYPE_MONTHLY  = 'MONTHLY';
	const TYPE_ANNUALLY = 'ANNUALLY';
	const TYPE_WEEKDAY  = 'WEEKDAY';
	const TYPE_CUSTOM   = 'CUSTOM';

	const RECURRENCE_TYPES = array(
		self::TYPE_DAILY,
		self::TYPE_WEEKLY,
		self::TYPE_MONTHLY,
		self::TYPE_ANNUALLY,
		self::TYPE_WEEKDAY,
		self::TYPE_CUSTOM,
	);

	const VALIDATION_RULES = array(
		'type' => array(
			'type' => MegaCalModel::TYPE_STRING,
		),
		'availableTypes' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
			'method_name' => 'available_types',
		),
		'weekly' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
		),
		'monthly' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
		),
		'annually' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
		),
		'custom' => array(
			'type' => MegaCalModel::TYPE_ARRAY,
		),
	);

	protected $type;
	protected $available_types;
	protected $weekly;
	protected $monthly;
	protected $annually;
	protected $custom;

	public function __construct( $data ) {

		$this->store_data( $data, self::VALIDATION_RULES );

	}

	/** Getters & Setters */
	
	protected function set_type( $type ) { 
	
		if( !in_array( $type, self::RECURRENCE_TYPES ) ) {
			throw new ApiException( sprintf( '%s: Invalid event recurrence type: %s', __METHOD__, $type ) );
		}

		$this->type = $type; 
	
	}
	public function get_type() { return $this->type; }

	protected function set_available_types( $available_types ) { 
	
		foreach( $available_types as $type ) {
			if( in_array( $type, self::RECURRENCE_TYPES ) ) {
				$this->available_types[] = $type; 
			}
		}
	
	}
	public function get_available_types() { return $this->available_types; }

	protected function set_weekly( $weekly ) { $this->weekly = new WeeklyRecurrence( $weekly ); }
	public function get_weekly() { return $this->weekly; }

	protected function set_monthly( $monthly ) { $this->monthly = new MonthlyRecurrence( $monthly ); }
	public function get_monthly() { return $this->monthly; }

	protected function set_annually( $annually ) { $this->annually = new AnnuallyRecurrence( $annually ); }
	public function get_annually() { return $this->annually; }

	protected function set_custom( $custom ) { $this->custom = new CustomRecurrence( $custom ); }
	public function get_custom() { return $this->custom; }

}