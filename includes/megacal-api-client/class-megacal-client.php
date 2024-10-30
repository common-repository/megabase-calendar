<?php
/**
 * MegaCal API Client
 */

namespace MegaCal\Client;

use \MegabaseCalendar;

/**
 * MegaCalClient Class 
 *
 * @category Class
 * @package  MegaCal\Client
 */
class MegaCalClient {
    const PROD_API_BASE = 'https://22sursvh7k.execute-api.us-east-1.amazonaws.com/release';
    const PROD_API_KEY = 'fjxvk2TCWW6FZ5Z6lTM8l4NZNZH01n6v3rJKVaiW';
    const USER_AGENT = 'MegaCal/API-Client/php';
    const DEBUG_FILE = 'php://output';

    public static $PATCH = "PATCH";
    public static $POST = "POST";
    public static $GET = "GET";
    public static $HEAD = "HEAD";
    public static $OPTIONS = "OPTIONS";
    public static $PUT = "PUT";
    public static $DELETE = "DELETE";

    public function __construct() {
    }
    
    /**
     * Calls the API with authentication
     */
    public function call( $request, $method, $params = array(), $body_args = array(), $headers = array() ) {
        
        $megacal_integration = MegabaseCalendar::get_instance();

        $headers = wp_parse_args( $headers, array(
            'Access-Token' => $megacal_integration->get_access_token(),
            'Refresh-Token' => $megacal_integration->get_refresh_token(),
        ));

        return $this->raw_call( $request, $method, $params, $body_args, $headers );

    }

    /**
     * Calls the API 
     */
    public function raw_call( $request, $method, $params = array(), $body_args = array(), $headers = array() ) {

        if( empty( $this->get_api_key() ) ) {
            throw new ApiException( 'No API Key supplied' );
        }

        $headers = wp_parse_args( $headers, array(
            'Content-Type' => 'application/json',
            'Accept' => 'application/json; charset=utf-8', 
            'X-API-Key' => $this->get_api_key(), 
        ));

        $request_args = array(
            'method' => $method,
            'headers' => $headers,
            'timeout' => 30,
        );

        $params = array_filter( $params, function( $e ) {
            return !empty( $e ); 
        });

        switch( $method ) {
            case self::$GET:
            case self::$PATCH:
                break;
                
            case self::$PUT:
            case self::$POST:

                $request_args = array_merge( 
                    $request_args,
                    array(
                        'body' => json_encode( $body_args )
                    )
                );

                break;

            case self::$DELETE:
                
                break;
            
            default:
                throw new ApiException( 'Invalid or unimplemented HTTP method: "' . $method . '"' );
                break;

        }

        // build the query string and
        // append to request url
        if( !empty( $params ) ) {
            $query = '?' . $this->build_query( $params );
            $request .= $query;
        }

        $url = $this->get_api_base() . $request;
        $response = wp_remote_request( $url, $request_args );

        if( is_wp_error( $response ) ) {
            throw new ApiException( 'Error encountered: ' . $response->get_error_message() );
        }

        return $response;

    }

    /**
     * A simplified version of the WP _http_build_query function that converts bools to 'true' and 'false'
     * 
     * @param array $params An associative array of params
     * @param string $key An optional key which will override the param keys
     * 
     * @return string A formatted query string
     * 
     */
    private function build_query( $params, $key = '' ) {
        
        if( !is_array( $params ) ) {
            throw new ApiException( 'Params should be an array' );
        }

        $ret = array();
    
        foreach ( $params as $k => $v ) {

            if ( null === $v ) {
                continue;
            }
    
            $final_k = !empty( $key ) ? $key : $k;

            if ( is_array( $v ) || is_object( $v ) ) {
                // If the passed param is a sequential array, use the param key. 
                // Otherwise, use the keys in the associative array or object
                $kk = megacal_array_is_list( $v ) && !is_object( $v ) ? $k : '';
                array_push( $ret, $this->build_query( $v, $kk ) );
            } elseif( is_bool( $v ) ) {
                $v = true === $v ? 'true' : 'false';
                array_push( $ret, $final_k . '=' . $v );
            } else {
                array_push( $ret, $final_k . '=' . $v );
            }

        }
    
        return implode( '&', $ret );

    }

    /** Return the PROD API Base URL or an overridden URL from .env */
    private function get_api_base() {
        return !empty( $_ENV['MEGACAL_API_BASE'] ) ? $_ENV['MEGACAL_API_BASE'] : self::PROD_API_BASE;
    }

    /** Return the PROD API Key or an overridden key from .env */
    private function get_api_key() {
        return !empty( $_ENV['MEGACAL_API_KEY'] ) ? $_ENV['MEGACAL_API_KEY'] : self::PROD_API_KEY;
    }

}
