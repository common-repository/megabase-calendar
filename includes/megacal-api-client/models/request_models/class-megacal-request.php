<?php

namespace MegaCal\Client;

class MegaCalRequest {
	const TYPE_INT    = 'int';
	const TYPE_BOOL   = 'boolean';
	const TYPE_STRING = 'string';
	const TYPE_URL    = 'url';
	const TYPE_ARRAY  = 'array';
	const TYPE_MODEL  = 'model';

	protected $client;

	public function __construct() {
		$this->client = new MegaCalClient();
	}

	protected function sanitize_and_transform_args( $args, $validation_rules = array() ) {

		$sanitized_args = array();

		if ( !is_array( $validation_rules ) ) {
			throw new ApiException( 'Error: Invalid validation rules!' );
		}

		if( empty( $validation_rules ) ) {
			return array();
		}

		// Check for required params
		foreach ( $validation_rules as $key => $rule ) {

			if ( empty( $rule['required'] ) ) {
				continue;
			}

			if ( ! array_key_exists( $key, $args ) ) {
				throw new ApiException( 
					sprintf( 'Error: Required request parameter %s was not supplied. caller: %s, args: %s, rules: %s', 
							$key, 
							print_r( debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 2 )[1]['function'], true ),
							print_r( $args, true ), 
							print_r( $validation_rules, true ) 
					) 
				);
			}

		}

		// Validate and sanitize
		foreach ( $args as $key => $arg_val ) {

			if ( ! array_key_exists( $key, $validation_rules ) ) {
				throw new ApiException( 'Error: Request parameter "' . $key . '" not recognized' );
			}

			$is_multiple = ( isset( $validation_rules[$key]['multiple'] ) && true === $validation_rules[$key]['multiple'] );

			if ( self::TYPE_MODEL !== $validation_rules[$key]['type'] && ( self::TYPE_ARRAY !== $validation_rules[$key]['type'] && false === $is_multiple ) && is_array( $arg_val ) ) {
				throw new ApiException( 'Error: Unexpected value for parameter "' . $key . '". Expected: ' . $validation_rules[$key]['type'] . ' Got: Array. Did you forget to specify \'multiple\' in the validation rules for the request?' );
			}

			if ( self::TYPE_ARRAY === $validation_rules[$key]['type'] && ( empty( $validation_rules[$key]['vals'] ) && empty( $validation_rules[$key]['multidim'] ) ) ) {
				throw new ApiException( 'Error: Property rules must be specified for type: ' . self::TYPE_ARRAY );
			}

			$vals               = is_array( $arg_val ) ? $arg_val : array( $arg_val );
			$sanitized_multiple = array();

			foreach ( $vals as $val ) {

				$sanitized_val = false;
				$valid         = false;

				switch ( $validation_rules[$key]['type'] ) {
				case self::TYPE_INT:
					$valid         = is_numeric( $val );
					$sanitized_val = intval( $val );
					break;
				case self::TYPE_BOOL:
					$valid         = is_bool( $val );
					$sanitized_val = boolval( $val ) ? 'true' : 'false';
					break;
				case self::TYPE_STRING:
					$valid         = is_string( $val );
					$sanitized_val = strval( $val );
					break;
				case self::TYPE_ARRAY:
					$valid         = is_array( $vals );
					$sanitized_val = $this->sanitize_array_vals( $vals, $validation_rules[$key], $is_multiple );
					break;
				case self::TYPE_MODEL:
					$valid 		   = $val instanceof $validation_rules[$key]['model'];
					$sanitized_val = $val->request_serialize();
					break;
				case self::TYPE_URL:
					$valid = true; // We simply sanitize urls
					$sanitized_val = sanitize_url( $val );
					break;

				default:
					throw new ApiException( 'Error: Validation type "' . $validation_rules[$key]['type'] . '" not recognized' );
				}

				if ( false === $valid ) {
					throw new ApiException( 'Error: Unexpected value for parameter "' . $key . '". Expected: ' . $validation_rules[$key]['type'] . ' Got: ' . gettype( $val ) );
				}

				if ( true === $is_multiple ) {
					if ( is_array( $sanitized_val ) ) {
						$sanitized_multiple = $sanitized_val;
					} else {
						$sanitized_multiple[] = $sanitized_val;
					}
				}

			}

			// Transform
			$new_key = !empty( $validation_rules[$key]['transform'] ) ? $validation_rules[$key]['transform'] : $key;
			$sanitized_args[$new_key] = ( false === $is_multiple ) ? $sanitized_val : $sanitized_multiple;

		}

		return $sanitized_args;
	}

	function sanitize_array_vals( $arr, $rules, $is_multiple = false ) {

		if ( ! empty( $rules['vals'] ) ) {

			$val = array();

			if ( true === $is_multiple ) {

				// handle associative arrays
				foreach ( $arr as $a ) {
					$val[] = $this->sanitize_and_transform_args( $a, $rules['vals'] );
				}

			} else {

				$val = $this->sanitize_and_transform_args( $arr, $rules['vals'] );

			}

			return $val;

		}

		if ( ! empty( $rules['multidim']['type'] ) ) {

			$all_vals = array();

			foreach ( $arr as $arg_val ) {

				$vals = array();
				foreach ( $arg_val as $val ) {

					$sanitized_val = '';
					switch ( $rules['multidim']['type'] ) {

					case self::TYPE_INT:
						$sanitized_val = intval( $val );
						break;

					case self::TYPE_BOOL:
						$sanitized_val = boolval( $val );
						break;

					case self::TYPE_STRING:
						$sanitized_val = strval( $val );
						break;

					case self::TYPE_URL:
						$sanitized_val = sanitize_url( $val );
						break;

					default:
						throw new ApiException( 'Error: Validation type "' . $rules['multidim']['type'] . '" not recognized' );

					}

					$vals[] = $sanitized_val;

				}

				if ( ! empty( $vals ) ) {
					$all_vals[] = $vals;
				}

			}

			return $all_vals;

		}

		throw new ApiException( 'Error: Missing TYPE_ARRAY properties in validation rules. Did you mean to use \'multiple\'?' );

	}

}