<?php

namespace MegaCal\Client;

use Error;
use JsonSerializable;

use function PHPSTORM_META\type;

abstract class MegaCalModel implements JsonSerializable {

	const TYPE_INT = 'int';
	const TYPE_BOOL = 'boolean';
	const TYPE_STRING = 'string';
	const TYPE_URL = 'url';
	const TYPE_DATE = 'date';
	const TYPE_ARRAY = 'array';

	protected $id;

	/**
	 *  Store the data for this model
	 * 
	 *  @param  array 	$data 				The response data as an array
	 *  @param  array   $validation_rules  	The validation rules for this model
	 * 
	 * 	@return void
	 */
	protected function store_data( $data, $validation_rules = array() ) {

		if( empty( $validation_rules ) ) {
			throw new ApiException( 'No validation rules provided for model' );
		}

		if( empty( $data ) )
			throw new ApiException( 'ERROR: Response data was empty' );

		// Check required
		foreach( $validation_rules as $key => $rule ) {
			
			if( empty( $rule['required'] ) ) {
				continue;
			}

			if( !array_key_exists( $key, $data ) ) {
				throw new ApiException( 
					sprintf( 
						'%s: Missing required parameter "%s". data: %s',	
						print_r( debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 2 )[1]['function'], true ),
						$key,
						print_r( $data, true)
					) 
				);
			}

		}

		foreach ( $data as $key => $value ) {
			
			// Remove the key from data if
			// it is not specified
			if( !array_key_exists( $key, $validation_rules ) ) {
				continue;
			}

			$valid = true;

			switch( $validation_rules[$key]['type'] ) {

				case self::TYPE_INT:
					$valid = is_int( $value );

					if( !empty( $validation_rules[$key]['minimum'] ) ) {
						
						if( is_int( $validation_rules[$key]['minimum'] ) ) {

							$min = intval( $validation_rules[$key]['minimum'] );
							if( $value < $min ) {
								throw new ApiException( sprintf( 'Invalid value: %d. min: %d', $value, $min ) );
							}

						}

					}

					if( !empty( $validation_rules[$key]['maximum'] ) ) {
					
						if( is_int( $validation_rules[$key]['maximum'] ) ) {
						
							$max = intval( $validation_rules[$key]['maximum'] );
							if( $value > $max ) {
								throw new ApiException( sprintf( 'Invalid value: %d. max: %d', $value, $max ) );
							}

						}

					}
					
					break;

				case self::TYPE_BOOL:
					$valid = is_bool( $value );
					break;

				case self::TYPE_STRING:
					$valid = is_string( $value );
					break;

				case self::TYPE_URL:
					$valid = ( false !== stripos( $value, 'http' ) );
					break;

				case self::TYPE_DATE:
					$format = $validation_rules[$key]['format'];
					$valid = $this->validate_date( $format, $value );
					break;

				case self::TYPE_ARRAY:
					$valid = is_array( $value );
					break;

				default:
					$valid = false;
					break;

			}

			if( false === $valid ) {
				continue;
			}

			if( !empty( $validation_rules[$key]['method_name'] ) )
				$this->set( $validation_rules[$key]['method_name'], $value );
			else
				$this->set( $key, $value );

		}

	}

	/**
	 * Check that a string is a valid date
	 * 
	 * @param  string $format  The date format that the string is passed in
	 * @param  string $value   The string to check
	 * 
	 * @return boolean 	True / False - Valid date; Returns false is format or 
	 *                  value is empty, or if value is not a string
	 */
	protected function validate_date( $format, $value ) {

		$valid = false;

		if( empty( $format ) )
			return false;

		if( empty( $value ) )
			return false;

		if( !is_string( $value ) )
			return false;

		$d = \DateTime::createFromFormat( $format, $value );
    	$valid = ( $d && $d->format($format) == $value );

    	return $valid;
	}

	/** Getters & Setters **/

		public function get($attr) {
	        $getter = "get_{$attr}";
	        
	        if(method_exists($this, $getter)) {
	            return $this->$getter();
	        } else {
	            error_log("attribute '{$attr}' was not found.");
	        }
	    }

	    public function set($attr, $value) {
	        $setter = "set_{$attr}";
	        
	        if (method_exists($this, $setter)) {
	            $this->$setter($value);
	        } else {
	            error_log("attribute '{$attr}' was not found.");
	        }
	    }

		protected function set_id( $id ) { $this->id = $id; }
		public function get_id() { return $this->id; }

		#[\ReturnTypeWillChange] // Suppress deprecation warning
		public function jsonSerialize() {

			$vars = get_object_vars( $this );
			return $vars;

		}

		public function request_serialize() {

			$vars = get_object_vars( $this );
			return $this->transform_vars( $vars );

		}
		
		private function transform_vars( $vars ) {
			
			$transformed = array();

			foreach( $vars as $key => $val ) {
				
				if( $val == null ) {
					continue;
				}

				if( $val instanceof MegaCalModel ) {
					$val = $val->request_serialize();
				} else if( is_array( $val ) ) {
					$val = $this->transform_vars( $val );
				}

				$new_key = $this->transform_key( $key );
				$transformed[$new_key] = $val;

			}

			return $transformed;

		}

		private function transform_key( $key ) {

			$camel_case = str_replace( ' ', '', ucwords( str_replace( '_', ' ', $key ) ) );
			$camel_case[0] = strtolower( $camel_case[0] );
			return $camel_case;

		} 

}