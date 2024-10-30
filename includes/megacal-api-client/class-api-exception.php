<?php
namespace MegaCal\Client;

use \Exception;

/**
 * ApiException Class
 *
 * @category Class
 * @package  MegaCal\Client
 */
class ApiException extends Exception {

    private $simple_message;

    /**
     * Constructor
     *
     * @param string   $message         Error message
     * @param int      $code            HTTP status code
     * 
     */
    public function __construct( $message = "", $code = 500 ) {
        
        parent::__construct( $message, $code. $simple_message = '' );
        $this->simple_message = !empty( $simple_message ) ? $simple_message : $message;
        error_log( 'ApiException Thrown: ' . $this->getMessage() . ' Code: ' . $code );

    }

    public function get_simple_message() {
        return $this->simple_message;
    }

}
