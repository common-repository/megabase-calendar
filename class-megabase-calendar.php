<?php
/*
Plugin Name: MegaCalendar
Plugin URI: https://wordpress.org/plugins/megabase-calendar/
Description: A flexible calendar and event list for communities, businesses and organizations.
Author: Megabase
Version: 1.3.7
Author URI: https://megabase.co/

------------------------------------------------------------------------
Copyright 2023 Megabase, Inc.

This plugin is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this plugin.  If not, see http://www.gnu.org/licenses.
*/

/** Define path identifiers **/
if (!defined('MEGACAL_PLUGIN'))
    define('MEGACAL_PLUGIN', __FILE__);

if (!defined('MEGACAL_PLUGIN_DIR'))
    define('MEGACAL_PLUGIN_DIR', untrailingslashit( dirname( MEGACAL_PLUGIN ) ) );

if( !defined('MEGACAL_API_DIR') )
    define( 'MEGACAL_API_DIR', untrailingslashit( MEGACAL_PLUGIN_DIR . '/includes/megacal-api-client' ) );

if( !defined( 'MEGACAL_SETTINGS_SLUG' ) )
    define( 'MEGACAL_SETTINGS_SLUG', 'megacal-integration' );

if( !defined( 'MEGACAL_UPGRADE_SLUG' ) )
    define( 'MEGACAL_UPGRADE_SLUG', 'megacal-upgrade' );

if( !defined( 'MEGACAL_MANAGE_SLUG' ) )
    define( 'MEGACAL_MANAGE_SLUG', 'megacal-manage' );

if( !defined( 'MEGACAL_SHORTCODES_SLUG' ) )
    define( 'MEGACAL_SHORTCODES_SLUG', 'megacal-shortcodes' );

if( !defined( 'MEGACAL_MANAGE_CATS_SLUG' ) )
    define( 'MEGACAL_MANAGE_CATS_SLUG', 'megacal-manage-event-categories' );

if( !defined( 'MEGACAL_MANAGE_VENUES_SLUG' ) )
    define( 'MEGACAL_MANAGE_VENUES_SLUG', 'megacal-manage-venues' );

if( !defined( 'MEGACAL_EVENT_DETAIL_URL' ) )
    define( 'MEGACAL_EVENT_DETAIL_URL', 'events/' );

if( !defined( 'MEGACAL_SETTINGS_URL' ) ) 
    define( 'MEGACAL_SETTINGS_URL', admin_url( 'admin.php?page=' . MEGACAL_SETTINGS_SLUG ) );

if( !defined( 'MEGACAL_UPGRADE_URL' ) ) 
    define( 'MEGACAL_UPGRADE_URL', admin_url( 'admin.php?page=' . MEGACAL_UPGRADE_SLUG ) );

if( !defined( 'MEGACAL_ADMIN_CALENDAR_CACHE_KEY' ) )
    define( 'MEGACAL_ADMIN_CALENDAR_CACHE_KEY', 'megacal_admin_calendar_events' );

if( !defined( 'MEGACAL_PAST_LIST_CACHE_KEY' ) )
    define( 'MEGACAL_PAST_LIST_CACHE_KEY', 'megacal_past_list_events' );

if( !defined( 'MEGACAL_PUBLIC_CALENDAR_CACHE_KEY' ) )
    define( 'MEGACAL_PUBLIC_CALENDAR_CACHE_KEY', 'megacal_public_calendar_events' );

if( !defined( 'MEGACAL_UPCOMING_LIST_CACHE_KEY' ) ) 
    define( 'MEGACAL_UPCOMING_LIST_CACHE_KEY', 'megacal_upcoming_list_events' );

if( !defined( 'MEGACAL_CACHED_VENUES_CACHE_KEY' ) )
    define( 'MEGACAL_CACHED_VENUES_CACHE_KEY', 'megacal_cached_venues' );

if( !defined( 'MEGACAL_CACHED_CATEGORIES_CACHE_KEY' ) )
    define( 'MEGACAL_CACHED_CATEGORIES_CACHE_KEY', 'megacal_cached_categories' );

if( !defined( 'MEGACAL_CACHED_MY_CATEGORIES_CACHE_KEY' ) )
    define( 'MEGACAL_CACHED_MY_CATEGORIES_CACHE_KEY', 'megacal_cached_my_categories' );

if( !defined( 'MEGACAL_PING_RESPONSE_CACHE_KEY' ) )
    define( 'MEGACAL_PING_RESPONSE_CACHE_KEY', 'megacal_ping_response' );

if( !defined( 'MEGACAL_CACHED_EVENT_OWNERS_CACHE_KEY' ) )
    define( 'MEGACAL_CACHED_EVENT_OWNERS_CACHE_KEY', 'megacal_cached_event_owners' );

if( !defined( 'MEGACAL_EVENT_DETAIL_CACHE_KEY' ) )
    define( 'MEGACAL_EVENT_DETAIL_CACHE_KEY', 'megacal_cached_event_details' );

if( !defined( 'MEGACAL_CACHED_HOVER_CARD_CACHE_KEY' ) )
    define( 'MEGACAL_CACHED_HOVER_CARD_CACHE_KEY', 'megacal_cached_hover_cards' );

if( !defined( 'MEGACAL_NOTICE_COUNT_CACHE_KEY' ) )
    define( 'MEGACAL_NOTICE_COUNT_CACHE_KEY', 'megacal_cached_notice_count' );

if( !defined( 'MEGACAL_GET_EVENTS_CACHE_KEY' ) )
    define( 'MEGACAL_GET_EVENTS_CACHE_KEY', 'megacal_get_events_cache' );

if( !defined( 'MEGACAL_NOTICE_COUNT_EXPIRE_TIME' ) )
    define( 'MEGACAL_NOTICE_COUNT_EXPIRE_TIME', 30 * MINUTE_IN_SECONDS );

if( !defined( 'MEGACAL_EVENT_CACHE_EXPIRE_TIME' ) )
    define( 'MEGACAL_EVENT_CACHE_EXPIRE_TIME', HOUR_IN_SECONDS );
    
if( !defined( 'MEGACAL_LEGACY_ICS_PATH' ) )
    define( 'MEGACAL_LEGACY_ICS_PATH', 'plugin/megabase-calendar/generate-ics/' );

if( !defined( 'MEGACAL_ICS_PATH' ) )
    define( 'MEGACAL_ICS_PATH', 'plugin/megabase-calendar/public/' );

if( !defined( 'MEGACAL_IMG_SIZE_SQUARE' ) )
    define( 'MEGACAL_IMG_SIZE_SQUARE', 'mega-square' );

if( !defined( 'MEGACAL_IMG_SIZE_DETAIL' ) )
    define( 'MEGACAL_IMG_SIZE_DETAIL', 'mega-detail' );

if( !defined( 'MEGACAL_IMG_SIZE_BANNER' ) )
    define( 'MEGACAL_IMG_SIZE_BANNER', 'mega-banner' );

// Expose the plugin to specific users
// publish_posts = Authors and above
if( !defined( 'MEGACAL_PLUGIN_VISIBILITY_CAP' ) )
    define( 'MEGACAL_PLUGIN_VISIBILITY_CAP', 'publish_posts' );

// Expose the authentication tokens to specific users
if( !defined( 'MEGACAL_TOKEN_VISIBILITY_CAP' ) )
    define( 'MEGACAL_TOKEN_VISIBILITY_CAP', 'manage_options' );

if( !defined( 'MEGACAL_RECURRENCE_TYPE_FREQ_FMT' ) )
    define( 'MEGACAL_RECURRENCE_TYPE_FREQ_FMT', 'frequency' );

if( !defined( 'MEGACAL_RECURRENCE_TYPE_SINGULAR_FMT' ) )
    define( 'MEGACAL_RECURRENCE_TYPE_SINGULAR_FMT', 'singular' );

if( !defined( 'MEGACAL_RECURRENCE_TYPE_PLURAL_FMT' ) )
    define( 'MEGACAL_RECURRENCE_TYPE_PLURAL_FMT', 'plural' );

if( !defined( 'MEGACAL_DEFAULT_CATEGORY_NAME' ) )
    define( 'MEGACAL_DEFAULT_CATEGORY_NAME', 'Default' );

if( !defined( 'MEGACAL_EVENT_LIST_RESULTS_PER_PAGE' ) )
    define( 'MEGACAL_EVENT_LIST_RESULTS_PER_PAGE', 15 );

if( !defined( 'MEGACAL_DEFAULT_NULL_VENUE_NAME' ) )
    define( 'MEGACAL_DEFAULT_NULL_VENUE_NAME', '' );

if( !defined( 'MEGACAL_STRIPE_PORTAL_URL' ) )
    define( 'MEGACAL_STRIPE_PORTAL_URL', 'https://billing.stripe.com/login/5kAeVG5M43gsf6g9AA' );

if( !defined( 'MEGACAL_EXCERPT_LENGTH' ) )
    define( 'MEGACAL_EXCERPT_LENGTH', 25 );

if( !defined( 'MEGACAL_EXCERPT_MORE' ) )
    define( 'MEGACAL_EXCERPT_MORE', '&hellip;' );

require_once( MEGACAL_PLUGIN_DIR . '/bootstrap.php' );

use Kigkonsult\Icalcreator\Vcalendar;
use Spatie\SchemaOrg\Schema;
use MegaCal\Client\MegaCalAPI;
use MegaCal\Client\ApiException;
use MegaCal\Client\CheckHandleResponse;
use MegaCal\Client\Event;
use MegaCal\Client\EventDeleteResponse;
use MegaCal\Client\EventDetailResponse;
use MegaCal\Client\EventFilterResponse;
use MegaCal\Client\EventListResponse;
use MegaCal\Client\EventProcessingDetail;
use MegaCal\Client\EventProcessingResponse;
use MegaCal\Client\EventProcessingStage;
use MegaCal\Client\EventRecurrenceDetail;
use MegaCal\Client\EventRecurrenceResponse;
use MegaCal\Client\EventUpsertBodyResponse;
use MegaCal\Client\EventUpsertResponse;
use MegaCal\Client\MegaCalModel;
use MegaCal\Client\PingResponse;
use MegaCal\Client\PutApprovalResponse;
use MegaCal\Client\RegisterResponse;
use MegaCal\Client\UpdateCategoryResponse;
use MegaCal\Client\UpdateVenueResponse;
use MegaCal\Client\UserRequest;

if (!class_exists('MegabaseCalendar')):

class MegabaseCalendar {

    const TYPE_EVENT = 'event';
    const TYPE_EVENT_PLURAL = 'events';

    const TYPE_VENUE = 'venue';
    const TYPE_VENUE_PLURAL = 'venues';

    const TYPE_CATEGORY = 'category';
    const TYPE_CATEGORY_PLURAL = 'event-categories';

    private static $instance;
    private static $shortcode_instances = 0;

    private static $access_token;
    private static $refresh_token;
    private $api;

    /** The Constructor **/
    function __construct() {

        if( null !== self::$instance ) {
            return self::$instance;
        } else {
            self::$instance = $this;
        }

        $this->api = MegaCalAPI::get_instance();

        $dotenv = Dotenv\Dotenv::createImmutable( MEGACAL_PLUGIN_DIR );
        $dotenv->safeLoad();

        register_activation_hook( MEGACAL_PLUGIN, array( $this, 'megacal_activation' ) );
        register_deactivation_hook( MEGACAL_PLUGIN, array( $this, 'megacal_deactivation' ) );

        register_setting(
            MEGACAL_SETTINGS_SLUG,
            'megacal_options',
            array($this, 'megacal_validate_input')
        );

        register_setting(
            MEGACAL_SETTINGS_SLUG,
            'megacal_hidden_options'
        );

        register_setting(
            'megacal_execution_id_store',
            'megacal_execution_id_store'
        );

        register_setting(
            'megacal_processing_errors',
            'megacal_processing_errors'
        );

        $settings = ( !empty( self::megacal_get_settings() ) ) ? self::megacal_get_settings() : array();
        $hidden_settings = self::megacal_get_settings( 'megacal_hidden_options' );
        $processing_errors = self::megacal_get_settings( 'megacal_processing_errors' );

        // Action hooks
        add_action( 'admin_menu', array($this, 'admin_menu') );
        add_action( 'admin_init', array($this, 'megacal_admin_init') );
        add_action( 'admin_bar_menu', array( $this, 'megacal_register_admin_bar_menu' ), 99 );
        add_action( 'admin_post_megacal_flush_event_cache', array( $this, 'megacal_admin_post_flush_event_cache' ) );
        add_action( 'admin_enqueue_scripts', array($this, 'megacal_enqueue_admin_scripts') );
        add_action( 'update_option_megacal_options', array( $this, 'megacal_update_settings' ), 10, 0 );
        add_action( 'wp_enqueue_scripts', array($this, 'megacal_enqueue_scripts') );
        add_action( 'after_setup_theme', array( $this, 'megacal_register_custom_schedules' ), 10, 0 );
        add_action( 'wp', array( $this, 'megacal_register_cron_events' ), 10, 0 );
        add_action( 'megacal_check_event_processing_cron', array( $this, 'megacal_check_event_processing' ), 10, 0 );
        add_action( 'megacal_clear_debug_log_cron', array( $this, 'megacal_clear_debug_log' ), 10, 0 );
        add_action( 'wp_head', array( $this, 'megacal_generate_seo_output' ), 10, 0 );
        add_filter( 'the_content', array( $this, 'megacal_load_event_detail' ), 999 );
        add_filter( 'display_post_states', array( $this, 'megacal_event_detail_page_state' ), 10, 2 );
        add_filter( 'document_title_parts', array( $this, 'megacal_event_detail_page_title' ), 10, 1 );
        
        // Register AJAX actions
        add_action( 'wp_ajax_megacal_check_handle', array( $this, 'megacal_ajax_check_handle' ) );
        add_action( 'wp_ajax_megacal_register', array( $this, 'megacal_ajax_register' ) );
        add_action( 'wp_ajax_megacal_save_event', array( $this, 'megacal_ajax_save_event' ) );
        add_action( 'wp_ajax_megacal_get_event_upsert', array( $this, 'megacal_ajax_get_event_upsert' ) );
        add_action( 'wp_ajax_megacal_get_event_recurrence', array( $this, 'megacal_ajax_get_event_recurrence' ) );
        add_action( 'wp_ajax_megacal_set_event_approval', array( $this, 'megacal_ajax_set_event_approval' ) );
        add_action( 'wp_ajax_megacal_delete_event', array( $this, 'megacal_ajax_delete_event' ) );
        add_action( 'wp_ajax_megacal_fetch_calendar_events', array( $this, 'megacal_ajax_fetch_admin_calendar_events' ) ) ; 
        add_action( 'wp_ajax_megacal_fetch_public_calendar_events', array( $this, 'megacal_ajax_fetch_public_calendar_events' ) );
        add_action( 'wp_ajax_nopriv_megacal_fetch_public_calendar_events', array( $this, 'megacal_ajax_fetch_public_calendar_events' ) );
        add_action( 'wp_ajax_megacal_load_events_list', array( $this, 'megacal_ajax_fetch_list_events' ) );
        add_action( 'wp_ajax_nopriv_megacal_load_events_list', array( $this, 'megacal_ajax_fetch_list_events' ) );
        add_action( 'wp_ajax_megacal_load_event_popup', array( $this, 'megacal_ajax_load_event_popup' ) ); 
        add_action( 'wp_ajax_nopriv_megacal_load_event_popup', array( $this, 'megacal_ajax_load_event_popup' ) ) ; 
        add_action( 'wp_ajax_load_shortcode_options', array( $this, 'megacal_load_shortcode_options' ) );
        add_action( 'wp_ajax_megacal_get_approval_list', array( $this, 'megacal_get_approval_list' ) );
        add_action( 'wp_ajax_megacal_update_venue_details', array( $this, 'megacal_update_venue_details' ) );
        add_action( 'wp_ajax_megacal_update_category_details', array( $this, 'megacal_update_category_details' ) );

        // Filter hooks
        add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'megacal_action_links' ) );
        
        // bootstrapping logic
        if ( !empty( $settings['megacal_access_token'] ) ) {
            self::$access_token = !empty($settings['megacal_access_token']) ? $settings['megacal_access_token'] : '';
            self::$refresh_token = !empty($settings['megacal_refresh_token']) ? $settings['megacal_refresh_token'] : '';
            
            $ping = $this->megacal_ping_user_account();
            
            // Update handle if empty
            if( empty( $hidden_settings['handle'] ) || empty( $hidden_settings['user_id'] ) ) {
                
                if( false !== $ping ) {

                    $hidden_settings['handle'] = $ping->get_handle();
                    $hidden_settings['user_id'] = $ping->get_user_id();
                    update_option( 'megacal_hidden_options', $hidden_settings );

                }

            }

        }

        if( empty( $settings['megacal_event_url_label'] ) ) {
            
            $settings['megacal_event_url_label'] = 'Tickets';
            update_option( 'megacal_options', $settings );

        }

        $this->megacal_register_ics_generator();
        $this->megacal_register_detail_page();
        $this->register_custom_image_sizes();

    }

    public function megacal_activation() {
        
        register_setting(
            MEGACAL_SETTINGS_SLUG,
            'megacal_options',
            array( $this, 'megacal_validate_input' )
        );

        $settings = self::megacal_get_settings();

        if( empty( $settings['megacal_default_style'] ) ) {
            $settings['megacal_default_style'] = 'full';
        }

        if( !isset( $settings['megacal_null_venue_label'] ) ) {
            $settings['megacal_null_venue_label'] = MEGACAL_DEFAULT_NULL_VENUE_NAME;
        }

        if( !isset( $settings['megacal_no_event_msg'] ) ) {
            $settings['megacal_no_event_msg'] = 'No events listed at the moment&hellip;';
        }

        if( empty( $settings['megacal_eod_cutoff'] ) ) {
            $settings['megacal_eod_cutoff'] = '12:00 AM';
        }

        if( empty( $settings['megacal_event_url_label'] ) ) {
            $settings['megacal_event_url_label'] = 'Tickets';
        }

        update_option( 'megacal_options', $settings );

        $this->megacal_register_ics_generator();
        $this->megacal_register_detail_page();
        flush_rewrite_rules();

    }

    public function megacal_deactivation() {

        // delete hidden settings
        delete_option( 'megacal_hidden_options' );

        // flush transients
        delete_transient( MEGACAL_PING_RESPONSE_CACHE_KEY );
        delete_transient( MEGACAL_CACHED_VENUES_CACHE_KEY );
        delete_transient( MEGACAL_CACHED_CATEGORIES_CACHE_KEY );
        delete_transient( MEGACAL_CACHED_MY_CATEGORIES_CACHE_KEY );
        delete_transient( MEGACAL_CACHED_EVENT_OWNERS_CACHE_KEY );
        $this->megacal_flush_upsert_cache();
        $this->megacal_flush_event_cache();

        flush_rewrite_rules();

    }

    private function megacal_register_ics_generator() {

        add_filter( 'generate_rewrite_rules', function ( $wp_rewrite ){
        
            $wp_rewrite->rules = array_merge(
                [
                    trailingslashit( MEGACAL_ICS_PATH ) . '?$' => 'index.php?generate_ics=1',
                    trailingslashit( MEGACAL_LEGACY_ICS_PATH ) . '?$' => 'index.php?generate_ics=1',
                ],
                $wp_rewrite->rules
            );
        
        } );
        
        add_filter( 'query_vars', function( $query_vars ){
        
            $query_vars[] = 'generate_ics';
            return $query_vars;
        
        } );
        
        add_action( 'template_redirect', function(){
        
            $generate_ics = intval( get_query_var( 'generate_ics' ) );

            if ( $generate_ics ) {
                $this->megacal_generate_ics();
                die;
            }
        
        } );

    }

    private function megacal_register_detail_page() {

        add_filter( 'wp_trash_post', function( $trashed_id ) {

            $settings = self::megacal_get_settings();
            $event_detail_id = intval( $settings['megacal_events_page'] );
            
            if( $event_detail_id === $trashed_id ) {
                $this->create_default_event_detail();
            }

        }, 0, 1);

        add_filter( 'generate_rewrite_rules', function ( $wp_rewrite ){

            $settings = self::megacal_get_settings();
            $event_detail_page = !empty( $settings['megacal_events_page'] ) ? get_post( $settings['megacal_events_page'] ) : '';
            
            if( empty( $event_detail_page ) || 'trash' === $event_detail_page->post_status ) {
                $this->create_default_event_detail();
            }

            // xxx: Handle subdirectory installs
            $site_path = esc_url( get_site_url() );
            $event_url = str_replace( $site_path, '', wp_make_link_relative( get_permalink( $event_detail_page ) ) ); 

            $wp_rewrite->rules = array_merge(
                [trailingslashit( ltrim( $event_url, '/' ) ) . '([0-9]+)/?$' => 'index.php?pagename=' . $event_detail_page->post_name . '&event_id=$matches[1]'],
                $wp_rewrite->rules
            );

        } );
        
        add_filter( 'query_vars', function( $query_vars ) {
           
            $query_vars[] = 'event_id';
            return $query_vars;
        
        } );

        add_action( 'template_redirect', function() {
            
            if( !megacal_is_event_detail() )
               return;

            $event_id = intval( get_query_var( 'event_id' ) );

            if( empty( $event_id ) ) {
                global $wp_query;
                $wp_query->set_404();
                status_header( 404 );
                get_template_part( 404 );
                exit;
            }

            $event_detail_response = $this->megacal_get_event_details( $event_id );

            if( $event_detail_response instanceof WP_Error ) {
                global $wp_query;
                $wp_query->set_404();
                status_header( 404 );
                get_template_part( 404 );
                exit;
            }
    
        } );

    }

    private function create_default_event_detail() {

        $settings = $this->megacal_get_settings();

        /**
         * Filter Hook: megacal_event_detail_page_default_title
         * Filters the default page title when an Event Detail page is auto-generated
         * 
         * @param string $page_title The page title - Default: 'Event'
         */
        $pid = wp_insert_post( array(
            'post_title' => apply_filters( 'megacal_event_detail_page_default_title', 'Event' ),
            'post_type' => 'page',
            'post_status' => 'publish',
            'menu_order' => 99,
        ) );

        if( $pid instanceof WP_Error ) {
            error_log( $pid->get_error_message() );
        } else {
            $settings['megacal_events_page'] = $pid;
            update_option( 'megacal_options', $settings );
        }

    }

    private function register_custom_image_sizes() {
        
        /**
         * Filter Hook: megacal_image_size_X_width
         * Filters the image size width, where X is one of mega-square, mega-detail, or mega-banner
         * 
         * @param int $width The width
         */

        /**
         * Filter Hook: megacal_image_size_X_height
         * Filters the image size height, where X is one of mega-square, mega-detail, or mega-banner
         * 
         * @param int $height The height
         */
         add_image_size( MEGACAL_IMG_SIZE_SQUARE, 
            apply_filters( 'megacal_image_size_' . MEGACAL_IMG_SIZE_SQUARE . '_width', 275 ), 
            apply_filters( 'megacal_image_size_' . MEGACAL_IMG_SIZE_SQUARE . '_height', 275 ),
            true 
        );

        add_image_size( MEGACAL_IMG_SIZE_DETAIL, 
            apply_filters( 'megacal_image_size_' . MEGACAL_IMG_SIZE_DETAIL . '_width', 1200 ),
            apply_filters( 'megacal_image_size_' . MEGACAL_IMG_SIZE_DETAIL . '_height', 9999 ),
            false 
        );

        add_image_size( MEGACAL_IMG_SIZE_BANNER, 
            apply_filters( 'megacal_image_size_' . MEGACAL_IMG_SIZE_BANNER . '_width', 1600 ),
            apply_filters( 'megacal_image_size_' . MEGACAL_IMG_SIZE_BANNER . '_height', 500 ),
            true 
        );

    }

    /**
     * Generates an ics file
     * 
     * @param $args The args for megacal_get_events - If empty, start_date = -2 Years & end_date = +2 Years.
     */
    private function megacal_generate_ics( $args = array() ) {

        if( empty( $args ) ) {

            $start_date = $this->megacal_get_wp_datetime( '-2 Years' );
            $end_date = $this->megacal_get_wp_datetime( '+2 Years' );

            $args = array( 
                'start_date' => $start_date->format( 'Y-m-d' ),
                'end_date' => $end_date->format( 'Y-m-d' ),
            );

        }

        /**
         * Filter Hook: megacal_generate_ics_request_args
         * Filters the args before the API request is sent, when generating an ics export for Google Cal, iCal, or other calendars
         * 
         * @param array $args The request args
         */
        $args = apply_filters( 'megacal_generate_ics_request_args', $args );
        $events = $this->megacal_get_public_events( $args );

        if( $events instanceof WP_Error ) {

            wp_die( $events->get_error_message() );

        }

        $timezone = wp_timezone();

        $cal = Vcalendar::factory( [ Vcalendar::UNIQUE_ID => site_url() ] )
                ->setCalscale( Vcalendar::GREGORIAN )
                ->setMethod( Vcalendar::PUBLISH )
                ->setXprop(
                    Vcalendar::X_WR_CALNAME,
                    html_entity_decode( get_bloginfo( 'site_name' ) . ' Calendar' )
                )
                ->setXprop(
                    Vcalendar::X_WR_TIMEZONE,
                    $timezone->getName()
                );

        
        foreach( $events as $event ) {

            if( !$event->get_published() ) {
                continue;
            }

            $start_date = $this->megacal_fmt_date_time_for_ics( $event->get_event_date(), $event->get_start_time() );
            $end_date = $this->megacal_fmt_date_time_for_ics( $event->get_event_date(), $event->get_end_time() );
            $venue_name = $this->megacal_get_venue_name( $event );

            // Handle any cases where end time is before start time, or where 
            // there is no end time by setting end time to 11:59PM on start date
            if( $start_date['val'] > $end_date['val'] || ( !empty( $start_date ) && empty( $end_date ) ) ) {
                $end_date = $this->megacal_fmt_date_time_for_ics( $event->get_event_date(), '11:59 PM' );
            }

            try {

                $calEvent = $cal->newVevent()
                    ->setTransp( Vcalendar::OPAQUE )
                    ->setClass( Vcalendar::P_BLIC )
                    ->setSummary( $event->get_title() )
                    ->setDescription( $event->get_description() )
                    ->setLocation( $venue_name )
                    ->setDtstart( $start_date['val'], $start_date['type'] )
                    ->setDtend( $end_date['val'], $end_date['type'] );
                  
            } catch( Exception $e ) {

                // xxx: Yes, this obscures errors, but it's better than breaking the entire ics output for one bad event
                // skip the event and log an error, if an exception is thrown by vkalednar
                error_log( $e->getMessage() );
                continue;

            }

        }

        /**
         * Filter Hook: megacal_ics_calendar_output
         * Filters the final ics output before it is served to the page
         * 
         * @param string The ics output
         */
        $calString = apply_filters( 'megacal_ics_calendar_output', $cal->vtimezonePopulate()->createCalendar() );

        // Set the headers
        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="event-export.ics"');
        
        echo wp_kses_post( $calString );

    }

    public function megacal_event_detail_page_state( $post_states, $post ) {
        
        $settings = $this->megacal_get_settings();
        $event_detail_page = intval( $settings['megacal_events_page'] );

        if( $post->ID == $event_detail_page ) {
            /**
             * Filter Hook: megacal_event_detail_page_state
             * Filters the page state text
             * 
             * @param string $state The page state 
             */
            $post_states[] = apply_filters( 'megacal_event_detail_page_state', 'Event Detail Page' );
        }

        return $post_states;

    }

    public function megacal_load_event_detail( $content ) {

        $event_id = intval( get_query_var( 'event_id' ) );

        if( !megacal_is_event_detail() || empty( $event_id ) || !in_the_loop() )
            return $content;

        $settings = $this->megacal_get_settings();
        $event_detail_page = !empty( $settings['megacal_events_page'] ) ? get_post( $settings['megacal_events_page'] ) : '';

        // Should never happen, but if we somehow lose the event detail page just throw a 404
        if( empty( $event_detail_page ) ) {
            global $wp_query;
            $wp_query->set_404();
            status_header( 404 );
            wp_die( 'Event Detail page was lost' );
        }

        $event_detail_url = get_permalink( $event_detail_page );

        $event_detail_response = $this->megacal_get_event_details( $event_id );
        
        if( $event_detail_response instanceof WP_Error ) {
            wp_die( $event_detail_response->get_error_message() );
        }

        $event = $event_detail_response->get_event();

        ob_start();
            require_once megacal_get_template_part( 'views/megacal', 'event-detail', false );
            $content = $content . ob_get_contents();
        ob_end_clean();

        /**
         * Filter Hook: megacal_event_detail_content
         * Filters the Event Detail page content after it has been built, before it's displayed
         * 
         * @param string $content The page content
         */
        return apply_filters( 'megacal_event_detail_content', $content );
        
    }

    public function megacal_get_event_details( $event_id ) {
        
        $cache = get_transient( MEGACAL_EVENT_DETAIL_CACHE_KEY ) ?: array();

        if( !empty( $cache[$event_id] ) )
            return $cache[$event_id];

        try {
            
            $event_detail_response = MegaCalAPI::request( MegaCalAPI::EVENT_REQUEST, 'get_event', array(
                'event_id' => $event_id,
            ) );

            if( !( $event_detail_response instanceof EventDetailResponse ) ) {
                throw new ApiException( 'Unexpected response object' );
            }

            $cache[$event_id] = $event_detail_response;
            set_transient( MEGACAL_EVENT_DETAIL_CACHE_KEY, $cache, MEGACAL_EVENT_CACHE_EXPIRE_TIME );

            return $event_detail_response;

        } catch( Exception $e ) {

            error_log( $e->getMessage() );
            return new WP_Error( $e->getCode(), $e->getMessage() );

        }

    }
    
    /**
     * Gets the date & time formatted for ics specifications
     * 
     * @param $date The date
     * @param $time The time
     * 
     * return array The expected format for use with a VCalendar object
     */
    private function megacal_fmt_date_time_for_ics( $date, $time ) {

        $dt = $this->megacal_get_wp_datetime( $date . ' ' . $time );

        return array( 
            'val' => !empty( $time ) ? $dt->format( 'Ymd\THis' ) : $dt->format( 'Ymd' ), 
            'type' => !empty( $time ) ? [Vcalendar::VALUE => Vcalendar::DATE_TIME] : [Vcalendar::VALUE => Vcalendar::DATE],
        );

    }

    /** 
     * Utility to get current date/time as a PHP DateTime object using wp timezone 
     *
     *  @return DateTimeImmutable The DateTimeImmutable object for "today" based on wp timezone 
     **/
    private function megacal_get_wp_datetime( $dt_string = 'now' ) {

        /**
         * Filter Hook: megacal_get_wp_datetime_timezone
         * Filters the timezone on our internal function to convert dates to DateTime objects
         * You should use this if you want event timezones to be different than your WP timezone
         * 
         * @param $timezone The timezone - Default: wp_timezone()
         */
        $timezone = apply_filters( 'megacal_get_wp_datetime_timezone', wp_timezone() );
        $dt = new DateTimeImmutable( $dt_string, $timezone );

        return $dt;

    }

    /** Fires on admin_init **/
    public function megacal_admin_init() {

        $settings = $this->megacal_get_settings();

        // Check for unlink
        if( $this->do_unlink_account() ) {

            if( false === wp_verify_nonce( $_GET['nonce'], '_megacal_unlink_account_nonce' ) ) {
                wp_redirect( MEGACAL_SETTINGS_URL . '&unlinked=false' );
            } else {
                
                $settings['megacal_access_token'] = '';
                $settings['megacal_refresh_token'] = '';
        
                $updated = update_option( 'megacal_options', $settings );
                $deleted = delete_option( 'megacal_hidden_options' );

                // Flush event cache
                $this->megacal_flush_event_cache();
                $this->megacal_flush_upsert_cache();
        
                if( false === $updated || false === $deleted ) {
                    wp_redirect( MEGACAL_SETTINGS_URL . '&unlinked=false' );
                    exit;
                } else {
                    wp_redirect( MEGACAL_SETTINGS_URL . '&unlinked=true' );
                    exit;
                }
        
            }
        
        }

        if( !empty( $_GET['unlinked'] ) ) {

            if( $_GET['unlinked'] === 'true' ) {
                add_settings_error( 'megacal_options', 'megacal_success_unlinking_account', 'Successfully unlinked account details', 'success' );
            } else {
                add_settings_error( 'megacal_options', 'megacal_error_unlinking_account', 'Could not successfully unlink your account details, please try again. Reach out to support if you continue to experience issues.', 'error' );
            }

        }
        
        $this->megacal_register_settings();
        $this->megacal_register_custom_buttons();

        if( empty( $settings['megacal_events_page'] ) && !wp_doing_ajax() && !wp_doing_cron() ) {
            $this->create_default_event_detail();
        }

        if( get_transient( 'megacal_do_rewrite_flush' ) ) {
            flush_rewrite_rules();
            delete_transient( 'megacal_do_rewrite_flush' );
        }

    }

    private function do_unlink_account() {
        
        return !empty( $_GET['page'] ) && $_GET['page'] === 'megacal-integration' 
            && !empty( $_GET['unlink'] ) && $_GET['unlink'] === 'true' 
            && !empty( $_GET['nonce'] );

    }

    function megacal_register_settings() {

        $settings = self::megacal_get_settings();
        
        //Register a new section on the settings page
        add_settings_section(
            'megacal_settings_section',
            'General Settings',
            array($this, 'megacal_settings_section'),
            MEGACAL_SETTINGS_SLUG,
            [
                'before_section' => '<div id="megacal-events-settings-general-tab" class="admin-tab">',
                'after_section' => '</div>',
            ],
        );

        add_settings_section(
            'megacal_appearance_settings_section',
            'Theme Colors',
            array($this, 'megacal_appearance_settings_section'),
            MEGACAL_SETTINGS_SLUG,
            [
                'before_section' => '<div id="megacal-events-settings-colors-tab" class="admin-tab">',
                'after_section' => '</div>',
            ],
        );

        //Register the API Key field
        add_settings_field(
            'megacal_access_token',
            'Access Token',
            array($this, 'megacal_token_field'),
            MEGACAL_SETTINGS_SLUG,
            'megacal_settings_section',
            [
                'label_for' => 'megacal_access_token',
                'class' => !empty( $settings['megacal_access_token'] ) ? 'wideTextInput hidden' : 'megacal_row wideTextInput'
            ]
        );

        // refresh token field
        add_settings_field(
            'megacal_refresh_token',
            'Refresh Token',
            array($this, 'megacal_token_field'),
            MEGACAL_SETTINGS_SLUG,
            'megacal_settings_section',
            [
                'label_for' => 'megacal_refresh_token',
                'class' => !empty( $settings['megacal_refresh_token'] ) ? 'wideTextInput hidden' : 'megacal_row wideTextInput'
            ]
        );

        // EOD Cutoff
        /*
        TODO: Implement this functionality when we have better ways to query upcoming
        add_settings_field(
            'megacal_eod_cutoff',
            'End of Day Cutoff Time',
            array( $this, 'megacal_eod_cutoff_field' ),
            MEGACAL_SETTINGS_SLUG,
            'megacal_settings_section',
            [
                'label_for' => 'megacal_eod_cutoff',
                'class' => 'megacal_row'
            ]
        );
        */

        

        // Ticket URL Label Override
        add_settings_field(
            'megacal_event_url_label',
            'Event or Ticket Link: Button Label',
            array($this, 'megacal_event_url_label_field'),
            MEGACAL_SETTINGS_SLUG,
            'megacal_settings_section',
            [
                'label_for' => 'megacal_event_url_label',
                'class' => 'megacal_row'
            ]
        );

        
        add_settings_field(
            'megacal_frequent_handles',
            'Saved Calendars',
            array($this, 'megacal_frequent_handles_field'),
            MEGACAL_SETTINGS_SLUG,
            'megacal_settings_section',
            [
                'label_for' => 'megacal_frequent_handles',
                'class' => 'megacal_row wideTextInput'
            ]
        );

        add_settings_field(
            'megacal_default_handles',
            'Send to these Saved Calendars by Default',
            array($this, 'megacal_default_handles_field'),
            MEGACAL_SETTINGS_SLUG,
            'megacal_settings_section',
            [
                'label_for' => 'megacal_default_handles',
                'class' => 'megacal_row'
            ]
        );

        add_settings_field(
            'megacal_default_category',
            'Default Event Category',
            array( $this, 'megacal_default_category_field' ),
            MEGACAL_SETTINGS_SLUG,
            'megacal_settings_section',
            [
                'label_for' => 'megacal_default_category',
                'class' => 'megacal_row'
            ]
        );

        add_settings_field(
            'megacal_default_style',
            'Default List Style',
            array( $this, 'megacal_default_style_field' ),
            MEGACAL_SETTINGS_SLUG,
            'megacal_settings_section',
            [
                'label_for' => 'megacal_default_style',
                'class' => 'megacal_row'
            ]
        );

        //Register no events message
        add_settings_field(
            'megacal_no_event_msg',
            'Message shown when no events found',
            array($this, 'megacal_no_event_msg_field'),
            MEGACAL_SETTINGS_SLUG,
            'megacal_settings_section',
            [
                'label_for' => 'megacal_no_event_msg',
                'class' => 'megacal_row wideTextInput'
            ]
        );

        // Null Venue Label
        add_settings_field(
            'megacal_null_venue_label',
            'No tagged venue label (Leave blank to display nothing)',
            array( $this, 'megacal_null_venue_label_field' ),
            MEGACAL_SETTINGS_SLUG,
            'megacal_settings_section',
            [
                'label_for' => 'megacal_null_venue_label',
                'class' => 'megacal_row'
            ]
        );

        add_settings_field(
            'megacal_events_list_page',
            'Event Listing Page',
            array( $this, 'megacal_events_page_field' ),
            MEGACAL_SETTINGS_SLUG,
            'megacal_settings_section',
            [
                'label_for' => 'megacal_events_list_page',
                'class' => 'megacal_row',
                'help_text' => "Select the page that you use as your Primary Events Listing - NOTE: This setting does not insert a calendar on the selected page.",
            ]
        );

        add_settings_field(
            'megacal_events_page',
            'Event Detail Page',
            array( $this, 'megacal_events_page_field' ),
            MEGACAL_SETTINGS_SLUG,
            'megacal_settings_section',
            [
                'label_for' => 'megacal_events_page',
                'class' => 'megacal_row',
                'help_text' => "Select the page you'd like to use to display Event Details (Page template must call the_content)",
            ]
        );

        add_settings_field(
            'megacal_time_fmt',
            'Event Time Format',
            array( $this, 'megacal_time_fmt_field' ),
            MEGACAL_SETTINGS_SLUG,
            'megacal_settings_section',
            [
                'label_for' => 'megacal_time_fmt',
                'class' => 'megacal_row'
            ]
        );

        // Hidden Account Settings
            add_settings_field(
                'megacal_hidden_handle',
                '',
                array( $this, 'megacal_hidden_field' ),
                MEGACAL_SETTINGS_SLUG,
                'megacal_settings_section',
                [
                    'label_for' => 'handle',
                    'class' => 'hidden'
                ]
            );

            add_settings_field(
                'megacal_hidden_user_id',
                '',
                array( $this, 'megacal_hidden_field' ),
                MEGACAL_SETTINGS_SLUG,
                'megacal_settings_section',
                [
                    'label_for' => 'user_id',
                    'class' => 'hidden'
                ]
            );

        // Event Colors

            //Default Colors: 
            //Primary Button color: #32aeff


            add_settings_field(
                'megacal_custom_event_bg_color',
                'Calendar: Event BG Color',
                array( $this, 'megacal_color_field' ),
                MEGACAL_SETTINGS_SLUG,
                'megacal_appearance_settings_section',
                [
                    'label_for' => 'megacal_custom_event_bg_color',
                    'label_for_opacity' => 'megacal_custom_event_bg_color_opacity',
                    'default' => '#32aeff',
                    'class' => 'megacal_custom_event_bg_color',
                    'show_opacity' => true,
                ]
            );

            add_settings_field(
                'megacal_custom_event_border_color',
                'Calendar: Event Accent Color',
                array( $this, 'megacal_color_field' ),
                MEGACAL_SETTINGS_SLUG,
                'megacal_appearance_settings_section',
                [
                    'label_for' => 'megacal_custom_event_border_color',
                    'default' => '#1f8ad1',
                    'class' => 'megacal_custom_event_border_color'
                ]
            );
            
            add_settings_field(
                'megacal_custom_event_text_color',
                'Calendar: Event Text Color',
                array( $this, 'megacal_color_field' ),
                MEGACAL_SETTINGS_SLUG,
                'megacal_appearance_settings_section',
                [
                    'label_for' => 'megacal_custom_event_text_color',
                    'default' => '#ffffff',
                    'class' => 'megacal_custom_event_border_color borderBottomGray'
                ]
            );

            //////////////////////////////////////////////////////////////            

            add_settings_field(
                'megacal_btn_bg_hovercolor',
                'Navigation/Filter Button Hover BG Color',
                array( $this, 'megacal_color_field' ),
                MEGACAL_SETTINGS_SLUG,
                'megacal_appearance_settings_section',
                [
                    'label_for' => 'megacal_btn_bg_hovercolor',
                    'default' => '#32aeff',
                    'class' => 'megacal_btn_bg_hovercolor'
                ]
            );

            add_settings_field(
                'megacal_btn_text_hovercolor',
                'Navigation/Filter Button Hover Text Color',
                array( $this, 'megacal_color_field' ),
                MEGACAL_SETTINGS_SLUG,
                'megacal_appearance_settings_section',
                [
                    'label_for' => 'megacal_btn_text_hovercolor',
                    'default' => '#ffffff',
                    'class' => 'megacal_btn_text_hovercolor borderBottomGray'
                ]
            );

            //////////////////////////////////////////////////////////////

            add_settings_field(
                'megacal_tickets_btn_color',
                'Tickets Button BG Color',
                array( $this, 'megacal_color_field' ),
                MEGACAL_SETTINGS_SLUG,
                'megacal_appearance_settings_section',
                [
                    'label_for' => 'megacal_tickets_btn_color',
                    'default' => '#0e699c',
                    'class' => 'megacal_tickets_btn_color'
                ]
            );

            add_settings_field(
                'megacal_tickets_btn_hovercolor',
                'Tickets Button BG Hover Color',
                array( $this, 'megacal_color_field' ),
                MEGACAL_SETTINGS_SLUG,
                'megacal_appearance_settings_section',
                [
                    'label_for' => 'megacal_tickets_btn_hovercolor',
                    'default' => '#32aeff',
                    'class' => 'megacal_tickets_btn_hovercolor'
                ]
            );

            add_settings_field(
                'megacal_tickets_btn_textcolor',
                'Tickets Button Text Color',
                array( $this, 'megacal_color_field' ),
                MEGACAL_SETTINGS_SLUG,
                'megacal_appearance_settings_section',
                [
                    'label_for' => 'megacal_tickets_btn_textcolor',
                    'default' => '#ffffff',
                    'class' => 'megacal_tickets_btn_textcolor borderBottomGray'
                ]
            );

            //////////////////////////////////////////////////////////////


        // Simple List View Colors
            add_settings_field(
                'megacal_custom_simple_details_btn_color',
                'Simple/Details Button BG Color',
                array( $this, 'megacal_color_field' ),
                MEGACAL_SETTINGS_SLUG,
                'megacal_appearance_settings_section',
                [
                    'label_for' => 'megacal_custom_simple_details_btn_color',
                    'default' => '#4a4a4a',
                     'class' => 'megacal_custom_simple_details_btn_color'
                ]
            );

            add_settings_field(
                'megacal_custom_simple_details_btn_text_color',
                'Simple/Details Button Text Color',
                array( $this, 'megacal_color_field' ),
                MEGACAL_SETTINGS_SLUG,
                'megacal_appearance_settings_section',
                [
                    'label_for' => 'megacal_custom_simple_details_btn_text_color',
                    'default' => '#ffffff',
                    'class' => 'megacal_custom_simple_details_btn_text_color borderBottomGray'
                ]
            );            

            //////////////////////////////////////////////////////////////
        
        // Full List View Colors                

        // General
            
            add_settings_field(
                'megacal_invert_colors_dark_mode',
                'Invert Button Colors in Dark Theme?',
                array( $this, 'megacal_checkbox_field' ),
                MEGACAL_SETTINGS_SLUG,
                'megacal_appearance_settings_section',
                [
                    'label_for' => 'megacal_invert_colors_dark_mode',
                    'default' => false,
                ]
            );

    }

    function megacal_register_custom_buttons() {

        // Priority 20 here is to ensure that
        // our media button appears after the 
        // default one 
        add_action( 'media_buttons', array( $this, 'megacal_show_shortcode_button'), 20 );

    }

    function megacal_show_shortcode_button() {

        echo '
            <a href="#" id="megacal-insert-shortcode" class="button">
                <i class="fui-calendar"></i>                
                Add Calendar
            </a>
        ';            
    }

    function megacal_register_admin_bar_menu( $admin_bar ) {

        /**
         * Filter Hook: megacal_admin_bar_visibility_capability
         * Filters the capability required to view the admin bar menu
         * 
         * @param string $cap The capability required to see the admin bar menu - Default: 'publish_posts'
         */
        if( !current_user_can( apply_filters( 'megacal_admin_bar_visibility_capability', MEGACAL_PLUGIN_VISIBILITY_CAP ) ) ) 
            return;

        $notice_count = $this->megacal_get_notice_count();
        $settings = self::megacal_get_settings();

        $admin_bar->add_menu( array(
            'id'    => 'megacal-admin-menu',
            'title' => $notice_count > 0 ? sprintf( 'MegaCal <span class="awaiting-mod mega-awaiting-mod">%d</span>', $notice_count ) : 'MegaCal', 
            'href'  => admin_url( 'admin.php?page=' . MEGACAL_MANAGE_SLUG ),
            'meta'  => array(
                'title' => __( 'MegaCal' ),
            ),
        ));

        if( !empty( $settings['megacal_events_list_page'] ) ) {

            $admin_bar->add_menu( array(
                'id'    => 'megacal-event-listing-link',
                'parent' => 'megacal-admin-menu',
                'title' => 'View Calendar',
                'href'  => get_permalink( $settings['megacal_events_list_page'] ),
                'meta'  => array(
                    'title' => __( 'View Calendar' ),
                    'target' => '_blank',
                ),
            ));

        }

        $admin_bar->add_menu( array(
            'id'    => 'megacal-shortcode-generator-link',
            'parent' => 'megacal-admin-menu',
            'title' => 'Shortcode Generator',
            'href'  => admin_url( 'admin.php?page=' . MEGACAL_SHORTCODES_SLUG ),
            'meta'  => array(
                'title' => __( 'Shortcode Generator' ),
            ),
        ));

        $admin_bar->add_menu( array(
            'id'    => 'megacal-flush-event-cache',
            'parent' => 'megacal-admin-menu',
            'title' => 'Flush Event Cache',
            'href'  => wp_nonce_url( admin_url( 'admin-post.php?action=megacal_flush_event_cache' ), '_megacal_flush_event_cache_nonce' ),
            'meta'  => array(
                'title' => __( 'Flush Event Cache' ),
            ),
        ));

    }

    function megacal_admin_post_flush_event_cache() {
        
        if( !wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ), '_megacal_flush_event_cache_nonce' ) )
            wp_die( 'Not Allowed' );

        if( empty( $_SERVER['HTTP_REFERER'] ) )
            wp_die( 'Not Allowed' );

        $this->megacal_flush_event_cache();

        wp_redirect( $_SERVER['HTTP_REFERER'] );
        exit;

    }

    /** Enqueues plugin admin scripts **/
    public function megacal_enqueue_admin_scripts() {

        $hidden_settings = self::megacal_get_settings( 'megacal_hidden_options' );

        wp_enqueue_style(
            'megacal-admin-styles', 
            plugins_url( '/assets/build/css/admin.css', MEGACAL_PLUGIN ), 
            array(), 
            filemtime( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/assets/build/css/admin.css' )
        );

        wp_enqueue_script(
            'megacal-admin-scripts', 
            plugins_url( '/assets/build/js/admin.min.js', MEGACAL_PLUGIN ), 
            array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget', 'megacal-admin-stripe-js', 'moment' ),
            filemtime( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/assets/build/js/admin.min.js' )
        );
        wp_localize_script('megacal-admin-scripts', 'megacal_admin_script_opts', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'base_url' => plugins_url( '', MEGACAL_PLUGIN ),
            'default_image_path' => megacal_get_default_event_image_path(),
            'settings_url' => MEGACAL_SETTINGS_URL,
            'upgrade_url' => MEGACAL_UPGRADE_URL,
            'user_handle' => ( !empty( $hidden_settings['handle'] ) ) ? $hidden_settings['handle'] : '',
            'time_fmt_setting' => $this->megacal_get_time_fmt( 'js' ),
        ));

        wp_enqueue_script(
            'megacal-admin-stripe-js', 
            'https://js.stripe.com/v3/', 
            array(),
            null
        );

        $ajax_shortcode_options_url = add_query_arg( array(
            'action' => 'load_shortcode_options',
            '_nonce' => wp_create_nonce( 'load-shortcode-modal-nonce' )
        ), admin_url( 'admin-ajax.php' ) );

        wp_localize_script( 'megacal-admin-scripts', 'ajax_shortcode_options', array( 
                'url' => $ajax_shortcode_options_url,
            ) 
        );

    }

    /** Enqueues plugin front-end scripts **/
    public function megacal_enqueue_scripts() {

        $settings = self::megacal_get_settings();
        
        wp_enqueue_style(
            'megacal-styles', 
            plugins_url( '/assets/build/css/styles.css', MEGACAL_PLUGIN ),
            array(), 
            filemtime( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/assets/build/css/styles.css' )
        );

        //Scripts
        wp_enqueue_script(
            'megacal-scripts', 
            plugins_url( '/assets/build/js/main.min.js', MEGACAL_PLUGIN ), 
            array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget', 'moment' ),
            filemtime( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/assets/build/js/main.min.js' )
        );

        wp_localize_script('megacal-scripts', 'megacal_script_opts', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'base_url' => plugins_url( '', MEGACAL_PLUGIN ),
            'default_image_path' => megacal_get_default_event_image_path(),
            'permalink_structure' => get_option( 'permalink_structure' ),
            'event_url' => $this->get_event_detail_url(),
            'time_fmt_setting' => $this->megacal_get_time_fmt( 'js' ),
            'calendar_color_overrides' => array(
                'eventBGColor' => !empty( $settings['megacal_custom_event_bg_color'] ) ? $settings['megacal_custom_event_bg_color'] : '',
                'eventBGOpacity' => !empty( $settings['megacal_custom_event_bg_color_opacity'] ) ? floatval( $settings['megacal_custom_event_bg_color_opacity'] ) / 100 : '',
                'eventBorderColor' => !empty( $settings['megacal_custom_event_border_color'] ) ? $settings['megacal_custom_event_border_color'] : '',
                'eventTextColor' => !empty( $settings['megacal_custom_event_text_color'] ) ? $settings['megacal_custom_event_text_color'] : '',
                'navigationBtnColor' => !empty( $settings['megacal_btn_bg_hovercolor'] ) ? $settings['megacal_btn_bg_hovercolor'] : '',
                'navigationBtnTextColor' => !empty( $settings['megacal_btn_text_hovercolor'] ) ? $settings['megacal_btn_text_hovercolor'] : '',
            ),
        ));

    }

    /** Validate Input **/
    public function megacal_validate_input( $input ) {
        $output = array();

        foreach ($input as $key => $value) {

            if (isset($input[$key])) {

                // General Sanitization
                if( is_numeric( $input[$key] ) ) {
                
                    $output[$key] = intval( sanitize_text_field( stripslashes( $input[$key] ) ) );
                    
                } else if( is_string( $input[$key] ) ) {
                
                    $output[$key] = sanitize_text_field( stripslashes( $input[$key] ) );
                
                } elseif( is_array( $input[$key] ) ) {
                  
                    foreach( $input[$key] as $v ) {
                        $output[$key][] = sanitize_text_field( stripslashes( $v ) );
                    }

                }

                // Specific Validation Rules
                if ($key == 'megacal_access_token' && !is_string( $input[$key] ) ) {
                    $output[$key] = '';
                }

                if ($key == 'megacal_no_event_msg' && !is_string($input[$key])) {
                    $output[$key] = '';
                }

                if( $key == 'megacal_default_category' && !is_numeric( $input[$key] ) ) {
                    $output[$key] = '';
                }

            }
        }

        /**
         * Filter Hook: megacal_validate_input
         * Filters sanitized/validated input from settings
         * 
         * @param array $output The sanitized input
         * @param array $input The raw input
         */
        return apply_filters( 'megacal_validate_input', $output, $input );
    }

    /**
     * Fires when settings are updated - Forces a permalink flush, and deletes in-memory settings cache
     */
    public function megacal_update_settings() {

        // Flush cache
        set_transient( 'megacal_do_rewrite_flush', true, 30 * MINUTE_IN_SECONDS );
        wp_cache_delete( 'megacal_options', 'megabase-calendar' );

    }

    /** 
     * Adds options to the admin menu 
     */
    public function admin_menu() {

        $settings = self::megacal_get_settings();

        //Main Tab
        $default_page_render = !empty( $settings['megacal_access_token'] ) ? 'megacal_render_manage_page' : 'megacal_render_settings_page';
        $default_page_slug = !empty( $settings['megacal_access_token'] ) ? MEGACAL_MANAGE_SLUG : MEGACAL_SETTINGS_SLUG;

        $notice_count = $this->megacal_get_notice_count();

        add_menu_page(
            'MegaCalendar', 
            $notice_count > 0 ? sprintf( 'MegaCalendar <span class="awaiting-mod mega-awaiting-mod">%d</span>', $notice_count ) : 'MegaCalendar', 
            MEGACAL_PLUGIN_VISIBILITY_CAP, 
            $default_page_slug, 
            array($this, $default_page_render), 
            'dashicons-calendar'
        );

        if( !empty( $settings['megacal_access_token'] ) ) { 
            
            add_submenu_page( 
                $default_page_slug, 
                'Add/Manage Events', 
                'Add/Manage Events', 
                MEGACAL_PLUGIN_VISIBILITY_CAP, 
                MEGACAL_MANAGE_SLUG,
                ''
            );

            add_submenu_page( 
                $default_page_slug, 
                'Manage Categories', 
                'Manage Categories', 
                MEGACAL_PLUGIN_VISIBILITY_CAP, 
                MEGACAL_MANAGE_CATS_SLUG,
                array( $this, 'megacal_render_manage_categories_page' )
            );

            add_submenu_page( 
                $default_page_slug, 
                'Manage Venues', 
                'Manage Venues', 
                MEGACAL_PLUGIN_VISIBILITY_CAP, 
                MEGACAL_MANAGE_VENUES_SLUG,
                array( $this, 'megacal_render_manage_venues_page' ) 
            );

            // Shortcode Generator
            add_submenu_page( 
                $default_page_slug, 
                'Shortcode Generator', 
                'Shortcodes', 
                MEGACAL_PLUGIN_VISIBILITY_CAP, 
                MEGACAL_SHORTCODES_SLUG,
                array( $this, 'megacal_render_shortcodes_page' ) 
            );

            //Settings Link
            add_submenu_page( 
                $default_page_slug, 
                'MegaCal Settings', 
                'Settings', 
                MEGACAL_PLUGIN_VISIBILITY_CAP, 
                MEGACAL_SETTINGS_SLUG,
                array( $this, 'megacal_render_settings_page' ) 
            );
        
        } else {

            //Settings Link
            add_submenu_page( 
                $default_page_slug, 
                'MegaCal Settings', 
                'Settings', 
                MEGACAL_PLUGIN_VISIBILITY_CAP, 
                MEGACAL_SETTINGS_SLUG
            );

            //Add Events Link
            add_submenu_page( 
                $default_page_slug, 
                'Add/Manage Events', 
                'Add/Manage Events', 
                MEGACAL_PLUGIN_VISIBILITY_CAP, 
                MEGACAL_MANAGE_SLUG, 
                array( $this, 'megacal_render_manage_page' ) 
            );      
        
        }

        //Upgrade Link
        if( !empty( $settings['megacal_access_token'] ) ) { 

            if( !$this->megacal_is_pro_account() ) {
                add_submenu_page( 
                    $default_page_slug, 
                    'Upgrade to Pro', 
                    'Upgrade to Pro', 
                    MEGACAL_PLUGIN_VISIBILITY_CAP, 
                    MEGACAL_UPGRADE_SLUG, 
                    array( $this, 'megacal_render_upgrade_page' ) 
                );
            }       
        }
    
    }

    /** Get the notice count from transient or API */
    private function megacal_get_notice_count() {

        if( !$this->megacal_is_pro_account() ) {
            return 0;
        }
        
        $notice_count = 0;

        if( false !== $count = get_transient( MEGACAL_NOTICE_COUNT_CACHE_KEY ) ) {
            $notice_count = $count; 
        } else {

            try {
                $approval_response = MegaCalAPI::request( MegaCalAPI::USER_REQUEST, 'get_approval' );
                $notice_count = $approval_response->get_count();
                set_transient( MEGACAL_NOTICE_COUNT_CACHE_KEY, $notice_count, MEGACAL_NOTICE_COUNT_EXPIRE_TIME );   
            } catch( ApiException $e ) {
                error_log( $e->getMessage() );
            }

        }

        return $notice_count;
    
    }

    public function megacal_render_manage_page() {

        /**
         * Filter Hook: megacal_render_manage_page_visibility_capability
         * Filters the capability required to view the manage page
         * 
         * @param string $cap The capability - Default: 'publish_posts'
         */
        // check user capabilities
        if( !current_user_can( apply_filters( 'megacal_render_manage_page_visibility_capability', MEGACAL_PLUGIN_VISIBILITY_CAP ) ) ) {
            return;
        }

        require_once( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/megacal-manage-page.php' );

    }

    public function megacal_render_upgrade_page() {

        /**
         * Filter Hook: megacal_render_upgrade_page_visibility_capability
         * Filters the capability required to view the upgrade page
         * 
         * @param string $cap The capability - Default: 'publish_posts'
         */
        // check user capabilities
        if( !current_user_can( apply_filters( 'megacal_render_upgrade_page_visibility_capability', MEGACAL_PLUGIN_VISIBILITY_CAP ) ) ) {
            return;
        }

        $cancelled = !empty( $_GET['cancel'] ) && boolval( $_GET['cancel'] ) ? true : false;
        if( $cancelled ) {
            add_settings_error( 'megacal_options', 'megacal_payment_cancel', 'Not Upgraded: No payment has been made', 'warning' );
        }

        // show error/update messages
        settings_errors( 'megacal_options' );

        require_once( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/megacal-upgrade-page.php' );

    }

    /** The plugin settings page **/
    public function megacal_render_settings_page() {
        require_once( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/megacal-settings-page.php' );
    }

    /** The shortcode generator page */
    public function megacal_render_shortcodes_page() {
        require_once( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/megacal-shortcodes-page.php' );
    }

    public function megacal_render_manage_venues_page() {

        $published = !empty( $_GET['published'] ) ? filter_var( $_GET['published'], FILTER_VALIDATE_BOOLEAN ) : true;

        /**
         * Filter Hooks: megacal_manage_venues_page_venues
         * Filters the list of Venues on the Manage Venues page
         * 
         * @param array<Venue> $venues The list of Venues
         * @param bool $published Listing published or unpublished Venues - True: Published/False: Unpublished
         */
        $relationships = apply_filters( 
            'megacal_manage_venues_page_venues', 
            $this->megacal_get_venue_list( array( 'published' => $published ) ),
            $published,
        );
        $type = MegabaseCalendar::TYPE_VENUE;
        $type_plural = MegabaseCalendar::TYPE_VENUE_PLURAL;

        require_once( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/megacal-manage-relationships-page.php' );

    }

    public function megacal_render_manage_categories_page() {

        $published = !empty( $_GET['published'] ) ? filter_var( $_GET['published'], FILTER_VALIDATE_BOOLEAN ) : true;
        /**
         * Filter Hooks: megacal_manage_categories_page_categories
         * Filters the list of Categories on the Manage Categories page
         * 
         * @param array<EventCategory> $categories The list of Categories
         * @param bool $published Listing published or unpublished Categories - True: Published/False: Unpublished
         */
        $relationships = apply_filters( 
            'megacal_manage_categories_page_categories', 
            $this->megacal_get_my_category_list( array( 'published' => $published ) ),
            $published,
        ); 
        $type = MegabaseCalendar::TYPE_CATEGORY;
        $type_plural = MegabaseCalendar::TYPE_CATEGORY_PLURAL;

        require_once( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/megacal-manage-relationships-page.php' );

    }

    /** Used for customizing the general settings section **/
    public function megacal_settings_section( $args ) {}
    public function megacal_appearance_settings_section( $args ) {}

    /** The Token Fields
     **
     **    @param $args The arguments passed to the register function
     **/
    public function megacal_token_field( $args ) {
        //Get the existing options
        $settings = self::megacal_get_settings();
        $error = "";

        $field_type = empty( $settings[$args['label_for']] ) ? 'password' : 'hidden';
        ?>

            <input type="<?php esc_attr_e( $field_type ); ?>" id="<?php echo esc_attr( $args['label_for'] ); ?>"
                name="megacal_options[<?php echo esc_attr( $args['label_for'] ); ?>]" 
                value="<?php echo !empty( $settings[$args['label_for']] ) ? esc_attr( $settings[$args['label_for']] ) : ''; ?>" />
        
            <?php if( !empty( $error ) ): ?>
                <p>Error: <?php echo esc_html( $error ); ?></p>
            <?php endif; ?>

        <?php
    }

    public function megacal_event_url_label_field( $args ) {
        
        $default = 'Tickets';
        include trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/admin/settings/field-text.php';

        echo '<p class="small">Common uses: Buy Tickets | RSVP | Learn More &rarr;</p><p  class="small">Will apply to all events using this field.</p>';
    }

    public function megacal_time_fmt_field( $args ) {

        //Get the existing options
        $settings = self::megacal_get_settings();
        $error = "";
        $val = !empty( $settings[$args['label_for']] ) ? $settings[$args['label_for']] : '';
        ?>
        <select id="<?php echo esc_attr($args['label_for']); ?>" name="megacal_options[<?php echo esc_attr($args['label_for']); ?>]">
            <option value="12-hour" <?php echo '12-hour' === $val ? 'selected' : ''; ?>>12 Hour (h:mm am/pm)</option>
            <option value="24-hour" <?php echo '24-hour' === $val ? 'selected' : ''; ?>>24 Hour (hh:mm)</option>
        </select>
        <?php

    }

    public function megacal_no_event_msg_field( $args ) {
     
        include trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/admin/settings/field-text.php';

    }

    public function megacal_eod_cutoff_field( $args ) {

        //Get the existing options
        $settings = self::megacal_get_settings();
        $error = "";
        ?>
        <select id="<?php echo esc_attr( $args['label_for'] ); ?>" name="megacal_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
        <?php for( $i = 1; $i < 12; $i++ ): ?>
                <?php 
                    $formatted_val = $i . ':00 AM';
                    $selected = $formatted_val == $settings['megacal_eod_cutoff'] ? 'selected' : '';
                ?>
                <option value="<?php esc_attr_e( $formatted_val ); ?>" <?php esc_attr_e( $selected ); ?>><?php esc_html_e( $formatted_val ); ?></option>
            <?php endfor; ?>
            
            <?php 
                $formatted_val = '12:00 PM';
                $selected = $formatted_val == $settings['megacal_eod_cutoff'] ? 'selected' : '';
            ?>
            <option value="<?php esc_attr_e( $formatted_val ); ?>" <?php esc_attr_e( $selected ); ?>><?php esc_html_e( $formatted_val ); ?></option>
            
            <?php for( $i = 1; $i < 12; $i++ ): ?>
                <?php 
                    $formatted_val = $i . ':00 PM';
                    $selected = $formatted_val == $settings['megacal_eod_cutoff'] ? 'selected' : '';
                ?>
                <option value="<?php esc_attr_e( $formatted_val ); ?>" <?php esc_attr_e( $selected ); ?>><?php esc_html_e( $formatted_val ); ?></option>
            <?php endfor; ?>
            
            <?php 
                $formatted_val = '12:00 AM';
                $selected = $formatted_val == $settings['megacal_eod_cutoff'] ? 'selected' : '';
            ?>
            <option value="<?php esc_attr_e( $formatted_val ); ?>" <?php esc_attr_e( $selected ); ?>><?php esc_html_e( $formatted_val ); ?></option>

        </select>
        <?php

    }

    public function megacal_default_style_field( $args ) {
        //Get the existing options
        $settings = self::megacal_get_settings();
        $error = "";
        ?>
        <select id="<?php echo esc_attr($args['label_for']); ?>" name="megacal_options[<?php echo esc_attr($args['label_for']); ?>]">
            <option value="full" 
            <?php echo ( $settings[$args['label_for']] == 'full' ) ? 'selected' : ''; ?>>Standard</option>
            
            <option value="simple"  
            <?php echo ( $settings[$args['label_for']] == 'simple' ) ? 'selected' : ''; ?>>Tight</option>
            
            <option value="compact"  
            <?php echo ( $settings[$args['label_for']] == 'compact' ) ? 'selected' : ''; ?>>Text Only</option>
            
        </select>
        <?php
    }

    public function megacal_null_venue_label_field( $args ) {

        include trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/admin/settings/field-text.php';

    }

    public function megacal_frequent_handles_field( $args ) {
    
        $hidden_settings = self::megacal_get_settings( 'megacal_hidden_options' );

        $placeholder = '';
        include trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/admin/settings/field-text.php';

        ?>
        <?php if( !empty( $hidden_settings['handle'] ) ): ?>
            <p class="small">Enter user handle(s), comma separated. Creates option to send to these calendars when saving events. <br><a href="https://megabase.co/help_docs/sending-receiving/" target="_blank">Learn More about sending/receiving events &#8599;</a> between two websites.
                <!--Your handle is: <?php esc_html_e( $hidden_settings['handle'] ); ?>-->
            </p>
        <?php endif; ?>

        <?php if( !empty( $hidden_settings['handle'] ) ): ?>
            <p style="font-weight:bold;margin-top:7px;">Your handle: <?php esc_html_e( $hidden_settings['handle'] ); ?></p>
        <?php endif; ?>

        <?php
    }

    public function megacal_default_handles_field( $args ) {
        //Get the existing options
        $settings = self::megacal_get_settings();
        $error = "";
        
        if( empty( $settings['megacal_frequent_handles'] ) ) {
            echo '<p>First add some handles to the field above</p>';
            return;
        }

        $settings[$args['label_for']] = empty( $settings[$args['label_for']] ) ? array() : $settings[$args['label_for']];
        $handles = array_map( 'trim', explode( ',', $settings['megacal_frequent_handles'] ) );
        foreach( $handles as $handle ) {

            printf( 
                '<label for="megacal-default-handle-%s"><input type="checkbox" %s id="megacal-default-handle-%s" name="megacal_options[%s][]" value="%s" />%s</label><br />', 
                $handle,
                checked( in_array( $handle, $settings[$args['label_for']] ), true, false ),
                $handle,
                esc_attr( $args['label_for'] ),
                $handle,
                $handle
            );

        } ?>
        <p class="small">
            (You can uncheck these before saving each event)        
        </p>

    <?php 
    }

    public function megacal_default_category_field( $args ) {
        //Get the existing options
        $settings = self::megacal_get_settings();

        $my_categories = $this->megacal_get_my_category_list();

       ?>
            <select <?php echo ( empty( $my_categories ) ) ? 'disabled' : ''; ?> name="megacal_options[<?php esc_attr_e( $args['label_for'] ); ?>]">
                <?php foreach( $my_categories as $cat ): ?>
                    <?php $selected = !empty( $settings[$args['label_for']] ) && $settings[$args['label_for']] == $cat->get_id() ? 'selected' : ''; ?>
                    <option value="<?php esc_attr_e( $cat->get_id() ); ?>" <?php esc_attr_e( $selected ); ?>>
                        <?php esc_html_e( $cat->get_name() ); ?>
                    </option>
                <?php endforeach; ?>

            </select>

            <?php if( empty( $my_categories ) ): ?>
                <p>Modify this setting after you have created some event categories</p>
            <?php endif; ?>

        <?php
    }

    public function megacal_events_page_field( $args ) {
        //Get the existing options
        $settings = self::megacal_get_settings();
        $current_page = !empty( $settings[$args['label_for']] ) ? $settings[$args['label_for']] : '';

        // Get all pages
        $pages = wp_cache_get( 'megacal_settings_page_list', 'megacal_settings_cache', false, $found );
        if( false === $found ) {

            $pages = get_posts( array(
                'post_type' => 'page',
                'post_status' => array( 'publish', 'draft' ),
                'posts_per_page' => -1,
                'orderby' => 'post_title',
                'order' => 'ASC',
            ) );

            wp_cache_set( 'megacal_settings_page_list', $pages, 'megacal_settings_cache' );

        }

        ?>

        <select <?php echo ( empty( $pages ) ) ? 'disabled' : ''; ?> name="megacal_options[<?php esc_attr_e( $args['label_for'] ); ?>]">
            <?php if( empty( $current_page ) ): ?>
                <option value="">Select a Page</option>
            <?php endif; ?>

            <?php foreach( $pages as $p ): ?>
                <option value="<?php esc_attr_e( $p->ID ); ?>" <?php echo $current_page == $p->ID ? 'selected' : ''; ?>>
                    <?php esc_html_e( $p->post_title ); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <p class="small"><?php esc_html_e( $args['help_text'] ); ?></p>
        <?php
    }

    public function megacal_hidden_field( $args ) {
        //Get the existing options
        $hidden_settings = self::megacal_get_settings( 'megacal_hidden_options' );
        ?>
        <input type="hidden" id="<?php echo esc_attr($args['label_for']); ?>"
                name="megacal_hidden_options[<?php echo esc_attr($args['label_for']); ?>]"
                value="<?php echo !empty( $hidden_settings[$args['label_for']] ) ? esc_attr( $hidden_settings[$args['label_for']] ) : ''; ?>"/>
        <?php
    }

    public function megacal_color_field( $args ) {
        //Get the existing options
        $settings = self::megacal_get_settings();
        $default = !empty( $args['default'] ) ? $args['default'] : ''; 
        ?>
        <input type="color" id="<?php echo esc_attr($args['label_for']); ?>"
                name="megacal_options[<?php echo esc_attr($args['label_for']); ?>]"
                class="megacal-color-input megacal-color-colorpicker-input"
                value="<?php echo !empty( $settings[$args['label_for']] ) ? esc_attr( $settings[$args['label_for']] ) : esc_attr_e( $default ); ?>" />
        <input type="text" 
                id="<?php echo esc_attr( $args['label_for']); ?>_text" 
                class="megacal-color-input megacal-color-text-input"
                value="<?php echo !empty( $settings[$args['label_for']] ) ? esc_attr( $settings[$args['label_for']] ) : esc_attr_e( $default ); ?>" />
        <?php if( !empty( $args['show_opacity'] ) ): ?>
            <?php $opacity = !empty( $settings[$args['label_for_opacity']] ) ? esc_attr( $settings[$args['label_for_opacity']] ) : '85'; ?>
            <div class="megacal-opacity-slider-container">
                <label for="<?php esc_attr_e( $args['label_for_opacity'] ); ?>">Opacity: <span class="megacal-opacity-slider-val"><?php esc_html_e( $opacity ); ?></span>%</label>
                <input type="range"
                    id="<?php esc_attr_e( $args['label_for_opacity'] ); ?>"
                    class="megacal-opacity-slider"
                    min="0" max="100" step="5"
                    name="megacal_options[<?php esc_attr_e( $args['label_for_opacity'] ); ?>]"
                    value="<?php esc_attr_e( $opacity ); ?>" />
            </div>
        <?php endif; ?>

        <?php if( !empty( $default ) && !empty( $settings[$args['label_for']] ) && $settings[$args['label_for']] != $default ): ?>
            <button 
                class="megacal-color-input-reset button button-secondary" 
                title="Reset this color to its default value"
                data-color="<?php esc_attr_e( $default ); ?>"
            >
                Reset
            </button>
        <?php endif; ?>
        <?php
    }

    public function megacal_checkbox_field( $args ) {
        //Get the existing options
        $settings = self::megacal_get_settings();
        $checked = !empty( $args['default'] ) && is_bool( $args['default'] )? $args['default'] : false;

        // If value is NULL, we use default
        if( isset( $settings[$args['label_for']] ) ) {
            $checked = $settings[$args['label_for']] === 'true' ? true : false;
        }
        ?>
        <input type="checkbox" 
                id="<?php echo esc_attr( $args['label_for']); ?>" 
                name="megacal_options[<?php echo esc_attr($args['label_for']); ?>]"
                value="true"
                <?php echo $checked ? 'checked' : ''; ?>
                />
        <?php
    }

    //WP AJAX hook functions
    public function megacal_ajax_check_handle() {
        
        check_ajax_referer( '_megacal_check_handle_nonce', '_nonce' );

        $handle = sanitize_text_field( $_POST['handle'] );

        if( empty( $handle ) ) {
            wp_send_json_error( array( 'message' => 'Handle cannot be empty' ) );
        }

        try {

            $response = MegaCalAPI::request( 
                MegaCalAPI::AUTH_REQUEST, 
                'check_handle', 
                array( 'handle' => $handle ) 
            );

        } catch( ApiException $e ) {

            wp_send_json_error( array( 'message' => $e->get_simple_message() ) );

        }

        if( !( $response instanceof CheckHandleResponse ) ) {
            wp_send_json_error( array( 'message' => 'Something went wrong' ) );
        }

        wp_send_json_success( array( 'unique' => $response->get_unique() ) );

    } 

    public function megacal_ajax_register() {

        check_ajax_referer( '_megacal_register_nonce', '_nonce' );

        $firstname = sanitize_text_field( stripslashes( $_POST['firstname'] ) );
        if( empty( $firstname ) ) {
            wp_send_json_error( array( 'message' => 'First Name cannot be empty' ) );
        }

        $lastname = sanitize_text_field( stripslashes( $_POST['lastname'] ) );
        if( empty( $lastname ) ) {
            wp_send_json_error( array( 'message' => 'Last Name cannot be empty' ) );
        }

        $handle = sanitize_text_field( stripslashes( $_POST['handle'] ) );
        if( empty( $handle ) ) {
            wp_send_json_error( array( 'message' => 'Handle cannot be empty' ) );
        }

        $email = sanitize_email( stripslashes( $_POST['email'] ) );
        if( empty( $email ) ) {
            wp_send_json_error( array( 'message' => 'Email cannot be empty' ) );
        }

        $phone = sanitize_text_field( stripslashes( $_POST['phone'] ) );

        $calendarName = sanitize_text_field( stripslashes( $_POST['calendarName'] ) );
        if( empty( $calendarName ) ) {
            wp_send_json_error( array( 'message' => 'Calendar name cannot be empty' ) );
        }

        try {

            $response = MegaCalAPI::request(
                MegaCalAPI::AUTH_REQUEST,
                'register',
                array(
                    'first_name' => $firstname,
                    'last_name' => $lastname,
                    'handle' => $handle,
                    'email' => $email,
                    'phone' => $phone,
                    'calendar_name' => $calendarName,
                )
            );
        
        } catch( ApiException $e ) {

            wp_send_json_error( array( 'message' => $e->get_simple_message() ) );

        }

        if( !( $response instanceof RegisterResponse ) ) {
            wp_send_json_error( array( 'message' => 'Something went wrong' ) );
        }

        $settings = self::megacal_get_settings();
        $settings['megacal_access_token'] = $response->get_access_token();
        $settings['megacal_refresh_token'] = $response->get_refresh_token();

        $updated = update_option( 'megacal_options', $settings );

        if( false === $updated ) {

            wp_send_json_error( array( 'message' => 'Unable to save Access & Refresh Tokens' ) );
            
        }

        $hidden_settings = self::megacal_get_settings( 'megacal_hidden_options' );
        $hidden_settings['handle'] = $handle;

        $updated = update_option( 'megacal_hidden_options', $hidden_settings );

        if( false === $updated ) {
            wp_send_json_error( array( 'message' => 'Unable to save handle' ) );
        }

        wp_send_json_success( array(
            'access_token' => $response->get_access_token(),
            'refresh_token' => $response->get_refresh_token(),
        ) );

    }

    public function megacal_ajax_save_event() {

        check_ajax_referer( '_megacal_event_upsert_nonce', '_nonce' );
        
        $field_names = array(
            'eventId', 'eventTitle', 'eventDate', 'eventAllDay', 'eventStartTime', 'eventEndTime', 'eventImg', 'eventVenueId', 
            'eventVenueName', 'eventCatId', 'eventCatName', 'eventVenueLocation', 'eventOrganizer', 'eventFacebookUrl', 
            'eventTicketUrl', 'eventPrice', 'eventTaggedUsersExtra', 'megacalEventDescription', 'megacalEventPrivateNotes', 
            'published', 'eventChangeType',
        );

        foreach( $field_names as $key ) {
            if( !isset( $_POST[$key] ) ) {
                wp_send_json_error( array( 'message' => 'Something isn\'t right: Missing parameter ' . $key ) );
            }

            /**
             * Filter Hook: megacal_preprocess_save_event_data
             * 
             * Applies some preprocessing to the POSTed event data 
             * This deals with extra escaping causing issues with special characters, actual sanitization happens later
             * 
             * @param string $preprocessed_data The value after it's been run through stripslashes
             * @param string $key The key for the field being processed
             * @param string $raw The raw POSTed data, before it's been sanitized or processed
             * 
            */
            $_POST[$key] = apply_filters( 'megacal_preprocess_save_event_data', stripslashes( $_POST[$key] ), $key, $_POST[$key] );
        }

        $settings = $this->megacal_get_settings();
        $updating = ( !empty( $_POST['eventId'] ) && is_numeric( $_POST['eventId'] ) );

        if( empty( $_POST['eventTitle'] ) ) {
            wp_send_json_error( array( 'message' => 'Event Title is required' ) );
        } 

        if( empty( $_POST['eventDate'] ) ) {
            wp_send_json_error( array( 'message' => 'Event Date is required' ) );
        }

        if( !$this->megacal_is_valid_date( $_POST['eventDate'], 'm/d/Y' ) ) {
            wp_send_json_error( array( 'message' => 'Invalid Event Date' ) );
        }

        if( !empty( $_POST['eventStartTime'] ) || !empty( $_POST['eventEndTime'] ) ) {

            if( !empty( $_POST['eventStartTime'] ) && !$this->megacal_is_valid_time( $_POST['eventStartTime'] ) ) {
                wp_send_json_error( array( 'message' => 'Invalid start time' ) );
            } 
            
            if( !empty( $_POST['eventEndTime'] ) && !$this->megacal_is_valid_time( $_POST['eventEndTime'] ) ) {
                wp_send_json_error( array( 'message' => 'Invalid end time' ) );
            }

            if( empty( $_POST['eventStartTime'] ) && !empty( $_POST['eventEndTime'] ) ) {
                wp_send_json_error( array( 'message' => 'Cannot have end time without start time' ) );
            }

            $event_start_time = !empty( $_POST['eventStartTime'] ) ? $this->megacal_fmt_time( $_POST['eventStartTime'] ) : '';
            $event_end_time = !empty( $_POST['eventEndTime'] ) ? $this->megacal_fmt_time( $_POST['eventEndTime'] ) : '';

            if( !empty( $event_start_time ) && !empty( $event_end_time ) ) {
                
                if( strtotime( $event_start_time ) >= strtotime( $event_end_time ) ) {
                    wp_send_json_error( array( 'message' => 'End time must be later than start time' ) );
                }

            }

        } else {
            
            $event_start_time = '';
            $event_end_time = '';

        }

        if( !empty( $_POST['eventTaggedUsers'] ) && !is_array( $_POST['eventTaggedUsers'] ) ) {
            wp_send_json_error( array( 'message' => 'Unexpected value for tagged users' ) );
        }


        if( !empty( $_POST['eventRecurrence'] ) ) {

            if( intval( $_POST['eventRecurrenceRepetition'] ) != $_POST['eventRecurrenceRepetition'] || intval( $_POST['eventRecurrenceRepetition'] ) < 1 ) {
                wp_send_json_error( array( 'message' => 'Event recurrence repetition must be 1 or greater' ) );
            }
    
            if( intval( $_POST['eventRecurrenceEndOccurrence'] ) != $_POST['eventRecurrenceEndOccurrence'] || intval( $_POST['eventRecurrenceEndOccurrence'] ) < 1 ) {
                wp_send_json_error( array( 'message' => 'Event recurrence repetition must be 1 or greater' ) );
            }
    
            if( !$this->megacal_is_valid_date( $_POST['eventRecurrenceEndDate'], 'm/d/Y' ) ) {
                wp_send_json_error( array( 'message' => 'Invalid Event Recurrence End Date' ) );
            }
    
            $event_recurrence = sanitize_text_field( $_POST['eventRecurrence'] );
            $event_recurrence_day_of_week = sanitize_text_field( $_POST['eventRecurrenceDayOfWeek'] );
            $event_recurrence_week_of_month = intval( $_POST['eventRecurrenceWeekOfMonth'] );
            $event_recurrence_last_day_of_week = $_POST['eventRecurrenceLastDayOfWeek'] === 'true' ? true : false;
            $event_recurrence_day_of_month = intval( $_POST['eventRecurrenceDayOfMonth'] );
            $event_recurrence_month = sanitize_text_field( $_POST['eventRecurrenceMonth'] );
            $event_recurrence_repetition = intval( $_POST['eventRecurrenceRepetition'] );
            $event_recurrence_custom_type = sanitize_text_field( $_POST['eventRecurrenceCustomType'] );
            $event_recurrence_custom_monthly_freq = sanitize_text_field( $_POST['eventRecurrenceCustomMonthlyFreq'] );
            $event_recurrence_end = sanitize_text_field( $_POST['eventRecurrenceEnd'] );
            $event_recurrence_end_date = date( 'Y-m-d', strtotime( $_POST['eventRecurrenceEndDate'] ) );
            $event_recurrence_end_occurrence = intval( $_POST['eventRecurrenceEndOccurrence'] );
            $event_recurrence_weekly_days = empty( $_POST['eventRecurrenceWeeklyDays'] ) 
            ? array() 
            : $this->megacal_sanitize_and_filter_array( $_POST['eventRecurrenceWeeklyDays'] );
        
        }
        
        $event_id = intval( $_POST['eventId'] );
        $event_title = sanitize_text_field( $_POST['eventTitle'] );
        $event_date = date( 'Y-m-d', strtotime( $_POST['eventDate'] ) );

        $event_img = sanitize_url( $_POST['eventImg'] );
        $event_venue_id = ( !empty( $_POST['eventVenueId'] ) ) ? intval( $_POST['eventVenueId'] ) : false;
        $event_venue_name = sanitize_text_field( $_POST['eventVenueName'] );
        $event_cat_id = ( !empty( $_POST['eventCatId'] ) ) ? intval( $_POST['eventCatId'] ) : false;
        $event_cat_name = sanitize_text_field( $_POST['eventCatName'] );
        $event_venue_location = sanitize_text_field( $_POST['eventVenueLocation'] );
        $event_organizer = wp_kses_post( $_POST['eventOrganizer'] );
        $event_facebook_url = sanitize_url( $_POST['eventFacebookUrl'] );
        $event_ticket_url = sanitize_url( $_POST['eventTicketUrl'] );
        $event_price = sanitize_text_field( $_POST['eventPrice'] );
        $megacal_event_description = wp_kses_post( $_POST['megacalEventDescription'] );
        $megacal_event_private_notes = wp_kses_post( $_POST['megacalEventPrivateNotes'] );
        $published = boolval( $_POST['published'] );
        $event_change_type = sanitize_text_field( $_POST['eventChangeType'] );

        // Sanitize & Merge tagged user fields
        $event_tagged_users =  empty( $_POST['eventTaggedUsers'] ) 
            ? array() 
            : $this->megacal_sanitize_and_filter_array( $_POST['eventTaggedUsers'] );

        $event_tagged_users_extra = $this->megacal_sanitize_and_filter_array( explode( ',', $_POST['eventTaggedUsersExtra'] ) );

        $event_tagged_users = array_merge( $event_tagged_users, $event_tagged_users_extra );

        $venue = array();
        if( $event_venue_id ) {
            
            $all_venues = $this->megacal_get_venue_list();
            $venue['id'] = $event_venue_id;

            foreach( $all_venues as $v ) {

                if( $v->get_id() !== $venue['id'] )
                    continue;

                $venue['name'] = $v->get_name();
                break;

            }

        } elseif( !empty( $event_venue_name ) ) {

            $venue = array(
                'name' => $event_venue_name,
                'location' => $event_venue_location,
            );

        }

        $cat = array();
        if( $event_cat_id ) {
            
            $all_cats = $this->megacal_get_my_category_list();
            $cat['id'] = $event_cat_id;

            foreach( $all_cats as $ec ) {
            
                if( $ec->get_id() !== $cat['id'] )
                    continue;

                $cat['name'] = $ec->get_name();
                break;

            }

        } else if( !empty( $event_cat_name ) ) {

            $cat = array(
                'name' => $event_cat_name,
            );

        } else if( !empty( $settings['megacal_default_category'] ) ) {

            $cat = array(
                'id' => intval( $settings['megacal_default_category'] ),
            );

        } else {

            $my_categories = !empty( $this->megacal_get_my_category_list( array( 'published' => true ) ) ) ? $this->megacal_get_my_category_list( array( 'published' => true ) ) : array();
            $default_id = false;
            
            /**
             * Filter Hook: megacal_save_event_default_category_name
             * Filters the default category name when saving an event - Must be an existing Event Category
             * Only runs when Default category hasn't been set in your settings
             * 
             * @param string $category The category name - Default: 'Default'
             * 
             */
            $default_category = apply_filters( 'megacal_save_event_default_category_name', MEGACAL_DEFAULT_CATEGORY_NAME );

            foreach( $my_categories as $c ) {
                
                if( strtolower( $c->get_name() ) == strtolower( $default_category ) ) {
                    $default_id = $c->get_id();
                    $settings['megacal_default_category'] = $default_id;
                    update_option( 'megacal_options', $settings );
                    break;
                }

            }

            if( !empty( $default_id ) && is_int( $default_id ) ) {

                $cat = array(
                    'id' => $default_id,
                );

            }

        }

        $img_id = attachment_url_to_postid( $event_img );
        $image_url_square = !empty( $img_id ) ? wp_get_attachment_image_url( $img_id, MEGACAL_IMG_SIZE_SQUARE ) : '';
        $image_url_detail = !empty( $img_id ) ? wp_get_attachment_image_url( $img_id, MEGACAL_IMG_SIZE_DETAIL ) : '';
        $image_url_banner = !empty( $img_id ) ? wp_get_attachment_image_url( $img_id, MEGACAL_IMG_SIZE_BANNER ) : '';

        $params = array(

            'title' => $event_title,
            'event_date' => $event_date,
            'start_time' => $event_start_time,
            'end_time' => $event_end_time,
            'image_url' => $event_img,
            'image_url_square' => $image_url_square,
            'image_url_detail' => $image_url_detail,
            'image_url_banner' => $image_url_banner,
            'event_category' => array( 'name' => apply_filters( 'megacal_default_category_name', MEGACAL_DEFAULT_CATEGORY_NAME ) ),
            'organizer' => $event_organizer,
            'facebook_url' => $event_facebook_url,
            'ticket_url' => $event_ticket_url,
            'price_details' => $event_price,
            'description' => $megacal_event_description,
            'private_note' => $megacal_event_private_notes,
            'tagged_users' => $event_tagged_users,
            'published' => $published,
            
        );

        if( !empty( $venue ) ) {
            $params['venue'] = $venue;
        }

        if( !empty( $cat ) ) {
            $params['event_category'] = $cat;
        }
        
        if( $updating ) {
            $params['event_id'] = $event_id;
            $params['change_type'] = $event_change_type;
        }

        if( !empty( $_POST['eventRecurrence'] ) ) {

            // Handle event recurrence
            if( in_array( $event_recurrence, EventRecurrenceDetail::RECURRENCE_TYPES ) ) {
    
                $recurrence_data = $this->megacal_setup_recurrence_details( array(
                    'event_recurrence' => $event_recurrence,
                    'day_of_week' => $event_recurrence_day_of_week,
                    'week_of_month' => $event_recurrence_week_of_month,
                    'last_day_of_week' => $event_recurrence_last_day_of_week,
                    'day_of_month' => $event_recurrence_day_of_month,
                    'month' => $event_recurrence_month,
                    'repetition' => $event_recurrence_repetition,
                    'custom_type' => $event_recurrence_custom_type,
                    'custom_monthly_freq' => $event_recurrence_custom_monthly_freq,
                    'weekly_days' => $event_recurrence_weekly_days,
                    'end' => $event_recurrence_end,
                    'end_date' => $event_recurrence_end_date,
                    'end_occurrence' => $event_recurrence_end_occurrence,
                ) );
    
                if( !empty( $recurrence_data ) ) {
                    $recurrence = new EventRecurrenceDetail( $recurrence_data );
                    $params['recurrence'] = $recurrence;
                }
    
            }
 
        }

        $action = $updating ? 'update_event' : 'create_event';

        try {

            /**
             * Filter Hook: megacal_save_event_args
             * Filters the arguments before sending a create or update Event request
             * 
             * @param array $args The request arguments 
             * @param string $action The action being performed - 'update_event', 'create_event'
             */
            $params = apply_filters( 'megacal_save_event_args', $params, $action );

            /**
             * Action Hook: megacal_before_save_event
             * Runs just before an Event is saved
             * 
             * @param array $args The request arguments 
             * @param string $action The action being performed - 'update_event', 'create_event'
             */
            do_action( 'megacal_before_save_event', $params, $action );

            $response = MegaCalAPI::request( MegaCalAPI::EVENT_REQUEST, $action, $params );

            /**
             * Action Hook: megacal_after_save_event 
             * Runs just after an Event is successfully saved
             * 
             * @param array $args The request arguments 
             * @param string $action The action being performed - 'update_event', 'create_event'
             * @param MegaCalResponse $response The API response - Should be type EventUpsertResponse
             */
            do_action( 'megacal_after_save_event', $params, $action, $response );

        } catch( ApiException $e ) {

            $request = array( 
                'action' => $action, 
                'params' => $params 
            );

            /**
             * Action Hook: megacal_after_save_event 
             * Runs after an Event is saved, if an error occurred
             * 
             * @param array $args The request arguments 
             * @param string $action The action being performed - 'update_event', 'create_event'
             * @param ApiException $e The exception thrown during saving
             */
            do_action( 'megacal_after_save_event_error', $params, $action, $e );

            wp_send_json_error( array( 'message' => $e->get_simple_message(), 'request' => $request ) );

        }

        if( !( $response instanceof EventUpsertResponse ) ) {
            
            wp_send_json_error( array( 'message' => 'Something went wrong' ) );

        }

        $event_id = $response->get_event_id();

        $this->megacal_flush_upsert_cache();
        $this->megacal_flush_event_cache();

        $message = "Successfully saved event";

        if( !empty( $event_change_type ) && $event_change_type !== MegaCalAPI::UPDATE_THIS ) {
            $message = "Successfully saved event - It may be a couple of minutes before you see your updates reflected on your recurring events";
        }

        wp_send_json_success( array( 'eventId' => $event_id, 'message' => $message ) );

    }

    private function megacal_setup_recurrence_details( $recurrence_details = array() ) {

        if( empty( $recurrence_details ) ) {
            return array();
        }

        if( empty( $recurrence_details['event_recurrence'] ) ) {
            return array();
        }

        $type = $recurrence_details['event_recurrence'];
        $type_label = strtolower( $type );
        $data = array(
            'type' => $type,
        );

        switch( $type ) {

            case EventRecurrenceDetail::TYPE_WEEKLY:
                $data[$type_label] = array(
                    'dayOfWeek' => $recurrence_details['day_of_week'],
                );
                break;

            case EventRecurrenceDetail::TYPE_MONTHLY:
                $data[$type_label] = array(
                    'dayOfWeek' => $recurrence_details['day_of_week'],
                );

                if( $recurrence_details['last_day_of_week'] ) {
                    $data[$type_label]['lastDayOfWeek'] = true;
                } else {
                    $data[$type_label]['weekOfMonth'] = $recurrence_details['week_of_month'];
                }

                break;

            case EventRecurrenceDetail::TYPE_ANNUALLY:
                $data[$type_label] = array(
                    'dayOfMonth' => $recurrence_details['day_of_month'],
                    'month' => $recurrence_details['month']
                );
                break;

            case EventRecurrenceDetail::TYPE_WEEKDAY:
            case EventRecurrenceDetail::TYPE_DAILY:
                // no addtl details needed
                break;

            case EventRecurrenceDetail::TYPE_CUSTOM:
                $data[$type_label] = $this->megacal_build_custom_recurrence( $recurrence_details );
                break;

            default:
                error_log( sprintf( 'Unimplemented recurrence type: %s', $type ) );
                return array();
                break;

        }
        
        return $data;

    }

    private function megacal_build_custom_recurrence( $recurrence_details = array() ) {

        if( empty( $recurrence_details ) )
            return array();

        $data = array();
        $type = $recurrence_details['custom_type'];
        $type_label = strtolower( $type ) . 'Custom';
        $data = array(
            'type' => $type,
            'repetition' => $recurrence_details['repetition'],
        );

        $data[$type_label] = array();
        $end_condition = array();
        if( in_array( $recurrence_details['end'], array( 'date', 'occurrence' ) ) ) {

            if( 'date' == $recurrence_details['end'] ) {
                $end_condition['on'] = $recurrence_details['end_date'];
            } else if( 'occurrence' == $recurrence_details['end'] ) {
                $end_condition['afterOccurrence'] = $recurrence_details['end_occurrence'];
            }

            $data['endCondition'] = $end_condition;

        }

        switch( $type ) {
            case EventRecurrenceDetail::TYPE_DAILY:
            case EventRecurrenceDetail::TYPE_ANNUALLY:
                unset($data[$type_label]); // No special details for Daily/Yearly
                break;
            case EventRecurrenceDetail::TYPE_WEEKLY:
                $data[$type_label]['repeatOn'] = $recurrence_details['weekly_days'];
                break;
            case EventRecurrenceDetail::TYPE_MONTHLY:
            
                if( 'day_of_month' == $recurrence_details['custom_monthly_freq'] ) {
                    $data[$type_label]['dayOfMonth'] = $recurrence_details['day_of_month'];
                } else {

                    $data[$type_label]['dayOfWeek'] = $recurrence_details['day_of_week'];
                    if( $recurrence_details['last_day_of_week'] ) {
                        $data[$type_label]['lastDayOfWeek'] = true;
                    } else {
                        $data[$type_label]['weekOfMonth'] = $recurrence_details['week_of_month'];
                    }
                
                }
                
                break;
            default:
                error_log( sprintf( 'Unimplemented recurrence type: %s', $type ) );
                return array();
                break;
        }

        return $data;

    }

    public function megacal_ajax_get_event_recurrence() {

        check_ajax_referer( '_megacal_event_recurrence_nonce', '_nonce' );
        
        $recurrence_details = null;

        if( $this->megacal_is_pro_account() ) {

            $date = $this->megacal_get_wp_datetime()->format( 'Y-m-d' );
            if( !empty( $_POST['date'] ) ) {

                if( !$this->megacal_is_valid_date( $_POST['date'], 'm/d/Y' ) ) {
                    wp_send_json_error( array( 'message' => sprintf( 'Invalid date value for recurrence: %s', esc_html( $_POST['date'] ) ) ) );
                }

                $date = $this->megacal_get_wp_datetime( $_POST['date'] )->format( 'Y-m-d' );

            }

            $show_recurrence = !empty( $_POST['showRecurrence'] ) && $_POST['showRecurrence'] === 'false' ? false : true;

            try {
        
                $response = MegaCalAPI::request( 
                    MegaCalAPI::EVENT_REQUEST, 
                    'get_event_recurrence', 
                    array( 'event_date' => $date ) 
                );

            } catch( ApiException $e ) {

                wp_send_json_error( array( 'message' => $e->get_simple_message() ) );

            }

            if( !( $response instanceof EventRecurrenceResponse ) ) {
                wp_send_json_error( array( 'message' => 'Something went wrong' ) );
            }

            $recurrence_details = $response->get_event_recurrence_details();

        }

        ob_start();

            require( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-event-recurrence-select.php' );
            $content = ob_get_contents();
        
        ob_end_clean();

        wp_send_json_success( array( 'content' => $content, 'recurrence_details' => $recurrence_details ) );

    }

    private function megacal_is_valid_time( $time ) {
        return $this->megacal_is_valid_date( $time, 'g : i A' ) || $this->megacal_is_valid_date( $time, 'g:i A' );
    }

    private function megacal_is_valid_date( $date, $fmt = 'Y-m-d' ) {

        if( empty( $date ) )
            return false;

        $dateObj = DateTime::createFromFormat( $fmt, $date );
        return $dateObj && $dateObj->format( $fmt ) == strtoupper( $date );

    }

    private function megacal_fmt_time( $time, $inFmt = 'g : i A', $outFmt = 'H:i' ) {

        $dateObj = DateTime::createFromFormat( $inFmt, strtoupper( $time ) );
        return $dateObj->format( $outFmt );

    }

    /**
     * Sanitizes an array of values - Strips elements that don't pass sanitization
     * by sanitize_text_field
     * 
     * @param array $arr The array to sanitize
     * @return array The sanitized array
     */
    private function megacal_sanitize_and_filter_array( $arr ) {

        $new_arr = array();

        foreach( $arr as $el ) {

            if( empty( sanitize_text_field( $el ) ) )
                continue;

            $new_arr[] = sanitize_text_field( $el );
        }

        /**
         * Filter Hook: megacal_sanitize_and_filter_array
         * Filters our internal function used to sanitize array values
         * 
         * @param array $sanitized The sanitized array
         * @param array $arr The original array
         */
        return apply_filters( 'megacal_sanitize_and_filter_array', $new_arr, $arr );

    }

    public function megacal_ajax_get_event_upsert() {

        if( !DOING_AJAX ) die(); // only allow AJAX

        check_ajax_referer( '_megacal_get_event_upsert_nonce', '_nonce' );

        if( !empty( $_POST['eventId'] ) ) {

            if( !is_numeric( $_POST['eventId'] ) ) {
                wp_send_json_error( array( 'message' => 'Invalid event ID' ) );
            }
    
            $event_id = intval( $_POST['eventId'] );
    
            try {
    
                $response = MegaCalAPI::request( 
                    MegaCalAPI::EVENT_REQUEST, 
                    'get_event_upsert', 
                    array( 'event_id' => $event_id ) 
                );
    
            } catch( ApiException $e ) {
    
                wp_send_json_error( array( 'message' => $e->get_simple_message() ) );
    
            }
    
            if( !( $response instanceof EventUpsertBodyResponse ) ) {
                wp_send_json_error( array( 'message' => 'Something went wrong' ) );
            }
    
            $event = $response->get_event();

        } 
        
        ob_start();

            require( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-event-form.php' );
            $content = ob_get_contents();
        
        ob_end_clean();

        wp_send_json_success( array( 'content' => $content ) );

    }

    public function megacal_ajax_set_event_approval() {

        if( !DOING_AJAX ) die(); // only allow AJAX

        check_ajax_referer( '_megacal_set_event_approval_nonce', '_nonce' );

        $args = array();

        if( empty( $_POST['userId'] ) || !is_numeric( $_POST['userId'] ) ) {
            wp_send_json_error( array( 'message' => 'Invalid user ID' ) );
        }

        $args['user_id'] = intval( $_POST['userId'] );

        if( !empty( $_POST['eventId'] ) ) {
            if( !is_numeric( $_POST['eventId'] ) ) {
                wp_send_json_error( array( 'message' => 'Invalid event ID' ) );
            }

            $args['event_id'] = intval( $_POST['eventId'] );
        }

        $action_map = array( 
            'approve' => UserRequest::STATUS_YES, 
            'deny' => UserRequest::STATUS_NO, 
            'always' => UserRequest::STATUS_ALL, 
            'approve_pending' => UserRequest::STATUS_APPROVE_PENDING, 
            'deny_pending' => UserRequest::STATUS_DENY_PENDING, 
        );

        if( !key_exists( $_POST['approvalAction'], $action_map ) ) {
            wp_send_json_error( array( 'message' => 'Invalid approval status' ) );
        }

        $approval_action = $action_map[$_POST['approvalAction']];
        $args['approbation'] = $approval_action;
        
        try {

            $response = MegaCalAPI::request( MegaCalAPI::USER_REQUEST, 'put_approval', $args );

        } catch( ApiException $e ) {

            wp_send_json_error( array( 'message' => $e->get_simple_message() ) );

        }

        if( !( $response instanceof PutApprovalResponse ) ) {

            wp_send_json_error( array( 'message' => 'Something went wrong' ) );
        
        }

        $this->megacal_flush_event_cache();
        
        wp_send_json_success( array( 'response' => $response ) );

    }

    public function megacal_ajax_delete_event() {

        if( !DOING_AJAX ) die(); // only allow AJAX

        check_ajax_referer( '_megacal_delete_event_nonce', '_nonce' );

        if( empty( $_POST['eventId'] ) || !is_numeric( $_POST['eventId'] ) ) {
            wp_send_json_error( array( 'message' => 'Invalid event ID' ) );
        }

        $event_id = intval( $_POST['eventId'] );
        $event_change_type = sanitize_text_field( $_POST['eventChangeType'] );
        
        try {

            /**
             * Action Hook: megacal_before_delete_event
             * Runs just before an Event is deleted
             * 
             * @param int $event_id The Event ID
             * @param string $change_type The Event change type
             */
            do_action( 'megacal_before_delete_event', $event_id, $event_change_type );

            $response = MegaCalAPI::request( MegaCalAPI::EVENT_REQUEST, 'delete_event', array(
               'event_id' => $event_id,
               'change_type' => $event_change_type,
            ) );

            /**
             * Action Hook: megacal_after_delete_event
             * Runs just after an Event is deleted
             * 
             * @param int $event_id The Event ID
             * @param string $change_type The Event change type
             * @param MegaCalResponse $response The API response - Should be EventDeleteResponse
             */
            do_action( 'megacal_after_delete_event', $event_id, $event_change_type, $response );
            
        } catch( ApiException $e ) {

            /**
             * Action Hook: megacal_after_delete_event_error
             * Runs after an Event is deleted, if an error occurred
             * 
             * @param int $event_id The Event ID
             * @param string $change_type The Event change type
             * @param ApiException $e The exception thrown
             */
            do_action( 'megacal_after_delete_event_error', $event_id, $event_change_type, $e );
            wp_send_json_error( array( 'message' => $e->get_simple_message() ) );

        }

        if( !( $response instanceof EventDeleteResponse ) ) {

            wp_send_json_error( array( 'message' => 'Something went wrong' ) );
        
        }

        $message = 'Successfully Deleted Event';
        if( !empty( $event_change_type ) && $event_change_type !== MegaCalAPI::DELETE_THIS ) {
            $message = 'Successfully deleted events - It may be a couple of minutes before your recurring events are removed';
        }
        
        $this->megacal_flush_event_cache();
        
        wp_send_json_success( array( 
            'response' => $response, 
            'message' => $message, 
        ) );

    }

    public function megacal_ajax_fetch_admin_calendar_events() {

        if( !DOING_AJAX ) die(); // only allow AJAX

        check_ajax_referer( '_megacal_fetch_events_nonce', '_nonce' );

        if( !$this->megacal_is_valid_date( $_POST['startDate'] ) || !$this->megacal_is_valid_date( $_POST['endDate'] ) ) {
            wp_send_json_error( array( 'message' => 'Invalid start/end date format' ) );
        }

        $event_cat_ids = array();
        if( !empty( $_POST['eventCategories'] ) ) {

            // validate
            if( !is_array( $_POST['eventCategories'] ) ) {
                wp_send_json_error( array( 'message' => 'Invalid value for eventCategories' ) );
            }

            $event_categories = $_POST['eventCategories'];
            $cat_ids = array_map( function( $e ) { return $e->get_id(); }, $this->megacal_get_category_list() );
            foreach( $event_categories as $cat ) {

                if( intval( $cat ) != $cat ) {
                    wp_send_json_error( array( 'message' => 'Invalid event category' ) );
                }

                if( !in_array( $cat, $cat_ids ) ) {
                    wp_send_json_error( array( 'message' => 'Invalid event category' ) );

                }

                $event_cat_ids[] = intval( $cat );

            }

        }

        $start_date = date( 'Y-m-d', strtotime( $_POST['startDate'] ) );
        $end_date = date( 'Y-m-d', strtotime( $_POST['endDate'] ) );

        $args = array();

        if( !empty( $event_cat_ids ) ) {
            $args['category'] = $event_cat_ids;
        }

        $events = $this->megacal_maybe_fetch_event_range( $start_date, $end_date, MEGACAL_ADMIN_CALENDAR_CACHE_KEY, $args );

        if( $events instanceof WP_Error ) {
            wp_send_json_error( array( 'message' => $events->get_error_message() ) );
        }

        wp_send_json_success( array( 'events' => $events ) );

    }

    public function megacal_ajax_fetch_public_calendar_events() {

        if( !DOING_AJAX ) die(); // only allow AJAX

        check_ajax_referer( '_megacal_fetch_public_events_nonce', '_nonce' );

        if( !$this->megacal_is_valid_date( $_POST['startDate'] ) || !$this->megacal_is_valid_date( $_POST['endDate'] ) ) {
            wp_send_json_error( array( 'message' => 'Invalid start/end date format' ) );
        }

        $event_cat_ids = array();
        if( !empty( $_POST['eventCategories'] ) && is_array( $_POST['eventCategories'] ) ) {

            // validate
            if( !is_array( $_POST['eventCategories'] ) ) {
                wp_send_json_error( array( 'message' => 'Invalid value for eventCategories' ) );
            }

            $event_categories = $_POST['eventCategories'];
            $cat_ids = array_map( function( $e ) { return $e->get_id(); }, $this->megacal_get_category_list() );
            foreach( $event_categories as $cat ) {

                if( intval( $cat ) != $cat ) {
                    wp_send_json_error( array( 'message' => sprintf( 'Invalid event category: %s', $cat ) ) );
                }

                if( !in_array( $cat, $cat_ids ) ) {
                    wp_send_json_error( array( 'message' => sprintf( 'Invalid event category: %s', $cat ) ) );

                }

                $event_cat_ids[] = intval( $cat );

            }

        }

        $start_date = date( 'Y-m-d', strtotime( $_POST['startDate'] ) );
        $end_date = date( 'Y-m-d', strtotime( $_POST['endDate'] ) );
        $args = array();
        $event_owner = ( !empty( $_POST['eventOwner'] ) ) && intval( $_POST['eventOwner'] == $_POST['eventOwner']) ? intval( $_POST['eventOwner'] ) : '';

        if( !empty( $event_owner ) ) {
            $args['event_owner'] = $event_owner;
        }

        if( !empty( $event_cat_ids ) ) {
            $args['category'] = $event_cat_ids;
        }
 
        $events = $this->megacal_maybe_fetch_event_range( $start_date, $end_date, MEGACAL_PUBLIC_CALENDAR_CACHE_KEY, $args );

        if( $events instanceof WP_Error ) {
            wp_send_json_error( array( 'message' => $events->get_error_message() ) );
        }

        wp_send_json_success( array( 'events' => $events ) );

    }

    public function megacal_ajax_fetch_list_events() {

        if( !DOING_AJAX ) die(); // only allow AJAX

        check_ajax_referer( '_megacal_fetch_public_events_nonce', '_nonce' );

        $settings = self::megacal_get_settings();

        //Set and validate post vars
        $listType = (isset($_POST['listType']) && $_POST['listType'] && is_string($_POST['listType'])) ? sanitize_text_field( $_POST['listType'] ) : 'upcoming';
        $descrip = (isset($_POST['descrip']) && "true" == $_POST['descrip'] ) ? TRUE : FALSE;
        $buttons = (isset($_POST['buttons']) && $_POST['buttons'] && is_string($_POST['buttons'])) ? sanitize_text_field($_POST['buttons']) : 'left';
        $listStyle = ( !empty( $_POST['list_style'] ) && is_string( $_POST['list_style'] ) ) ? sanitize_text_field( $_POST['list_style'] ) : $settings['megacal_default_style'];
        $listDate = ( !empty( $_POST['list_date'] ) ) && $this->megacal_is_valid_date( $_POST['list_date'] ) ? date( 'Y-m-d', strtotime( $_POST['list_date'] ) ) : 'now';
        $event_owner = ( !empty( $_POST['eventOwner'] ) ) && intval( $_POST['eventOwner'] ) == $_POST['eventOwner'] ? intval( $_POST['eventOwner'] ) : '';
        $current_page = ( !empty( $_POST['currentPage'] ) && intval( $_POST['currentPage'] ) == $_POST['currentPage'] ) ? intval( $_POST['currentPage'] ) : 0;
        $month = !empty( $_POST['prevMonth'] ) ? sanitize_text_field( $_POST['prevMonth'] ) : '';

        // strip out any unicode chars that made it this far
        $listType = $this->megacal_strip_unicode( $listType );
        $descrip = $this->megacal_strip_unicode( $descrip );
        $buttons = $this->megacal_strip_unicode( $buttons );
        $listStyle = $this->megacal_strip_unicode( $listStyle );
        $event_owner = $this->megacal_strip_unicode( $event_owner );

        if( 'full' !== $listStyle && 'compact' !== $listStyle && 'simple' !== $listStyle ) {
            $listStyle = 'full';
        }

        $event_cat_ids = array();
        if( !empty( $_POST['eventCategories'] ) ) {

            // validate
            if( !is_array( $_POST['eventCategories'] ) ) {
                wp_send_json_error( array( 'message' => 'Invalid value for eventCategories' ) );
            }

            $event_categories = $_POST['eventCategories'];
            $cat_ids = array_map( function( $e ) { return $e->get_id(); }, $this->megacal_get_category_list() );
            foreach( $event_categories as $cat ) {

                if( intval( $cat ) != $cat ) {
                    wp_send_json_error( array( 'message' => 'Invalid event category' ) );
                }

                if( !in_array( $cat, $cat_ids ) ) {
                    wp_send_json_error( array( 'message' => 'Invalid event category' ) );

                }

                $event_cat_ids[] = intval( $cat );

            }

        }
	
        $events = array();
        $args = array();

        if( !empty( $event_cat_ids ) ) {
            $args['category'] = $event_cat_ids;
        }

        if( !empty( $event_owner ) ) {
            $args['event_owner'] = $event_owner;
        }

        /**
         * Filter Hook: megacal_fetch_list_events_results_per_page
         * Filters the total number of events per page
         * 
         * @param int $results_per_page The total number of results per page - Default: 15
         */
        $results_per_page = apply_filters( 'megacal_fetch_list_events_results_per_page', MEGACAL_EVENT_LIST_RESULTS_PER_PAGE );

        $args['max_result'] = $results_per_page;
        $args['start_row'] = $results_per_page * $current_page;

        if( 'past' === $listType ):
            $response = $this->megacal_get_past_events( $args );
        else: // assume upcoming if the value is wrong
            $response = $this->megacal_get_upcoming_events( $args );
        endif;
    
        if( $response instanceof WP_Error ) {
            wp_send_json_error( array( 'message' => $response->get_error_message() ) );
        }

        ob_start();

            require megacal_get_template_part( 'views/megacal', $listStyle . '-events-list', false );
            $content = ob_get_contents();

        ob_end_clean();

        wp_send_json_success( array( 
            'content' => $content,
        ) );

        wp_die();
    }

    /**
     * Gets upcoming events either from cache or from the API
     */
    private function megacal_get_upcoming_events( $args = array() ) {

        $cache = get_transient( MEGACAL_UPCOMING_LIST_CACHE_KEY );

        $args = wp_parse_args( $args, array(
            'upcoming' => true,
            'published' => true,
        ));

        /**
         * Filter Hook: megacal_get_upcoming_events_args
         * Filters the Upcoming Events request args before the request is sent and before it's cached
         * 
         * @param array $args The request args
         */
        $args = apply_filters( 'megacal_get_upcoming_events_args', $args );

        $cache_sub_key = md5( serialize( $args ) );

        if( false === $cache || !array_key_exists( $cache_sub_key, $cache ) ) {

            $response = $this->megacal_get_event_request( $args );

            $cache = empty( $cache ) ? array() : $cache;
            $cache[$cache_sub_key] = $response;

            set_transient( 
                MEGACAL_UPCOMING_LIST_CACHE_KEY, 
                $cache, 
                MEGACAL_EVENT_CACHE_EXPIRE_TIME
            );

        } else {

            $response = $cache[$cache_sub_key];

        }

        return $response;

    }
    
    /**
     * Gets past events either from cache or from the API
     */
    private function megacal_get_past_events( $args = array() ) {

        $cache = get_transient( MEGACAL_PAST_LIST_CACHE_KEY );

        $args = wp_parse_args( $args, array(
            'upcoming' => false,
            'published' => true,
        ));

        /**
         * Filter Hook: megacal_get_past_events_args
         * Filters the Past Events request args before the request is sent and before it's cached
         * 
         * @param array $args The request args
         */
        $args = apply_filters( 'megacal_get_past_events_args', $args );

        $cache_sub_key = md5( serialize( $args ) );

        if( false === $cache || !array_key_exists( $cache_sub_key, $cache ) ) {

            $response = $this->megacal_get_event_request( $args );

            $cache = empty( $cache ) ? array() : $cache;
            $cache[$cache_sub_key] = $response;

            set_transient( 
                MEGACAL_PAST_LIST_CACHE_KEY, 
                $cache, 
                MEGACAL_EVENT_CACHE_EXPIRE_TIME
            );

        } else {

            $response = $cache[$cache_sub_key];

        }

        return $response;

    }

    /**
     * Gets events between $start_date and $end_date
     * 
     * @param string $start_date The starting date in Y-m-d format
     * @param string $start_date The ending date in Y-m-d format
     * @param string $cache_key The cache key to check/store results
     * @param array $args The query args
     * 
     * @return array<Event>|string An array of Events, or raw json response if the cache key is one of the calendar keys 
     */
    private function megacal_maybe_fetch_event_range( $start_date, $end_date, $cache_key, $args = array() ) {

        $cache_sub_key = empty( $args ) ? $start_date . '_' . $end_date : $start_date . '_' . $end_date . '_' . md5( serialize( $args ) );

        // xxx: Check in-memory cache to reduce DB calls & improve load speeds
        //
        // Unfortunately, because each AJAX request is handled separately, 
        // this doesn't provide benefit unless you are running Memcache or Redis.
        $cache = wp_cache_get( $cache_key, 'megacal_event_cache' );

        if( false === $cache ) {
            $cache = get_transient( $cache_key );
        }

        if( false === $cache || !array_key_exists( $cache_sub_key, $cache ) ) {

            $cache = empty( $cache ) ? array() : $cache;
            $calendar_keys = array( MEGACAL_ADMIN_CALENDAR_CACHE_KEY, MEGACAL_PUBLIC_CALENDAR_CACHE_KEY );
            $manage_keys = array( MEGACAL_ADMIN_CALENDAR_CACHE_KEY );

            $default_args = array(
                'start_date' => $start_date,
                'end_date' => $end_date,
                'cache_bypass' => true, // bypass underlying cache since we have a cache layer on top of this one
            );

            if( in_array( $cache_key, $calendar_keys ) ) {
                $default_args['return'] = 'response';
            }

            $args = wp_parse_args( $default_args, $args );
            
            if( in_array( $cache_key, $manage_keys ) ) {

                $events = $this->megacal_get_events( $args );

            } else {

                $events = $this->megacal_get_public_events( $args );

            }
    
            if( $events instanceof WP_Error ) {
                return $events;
            }
    
            $cache[$cache_sub_key] = $events;

            set_transient( 
                $cache_key, 
                $cache,
                MEGACAL_EVENT_CACHE_EXPIRE_TIME
            );

        } else {

            $events = $cache[$cache_sub_key];
        
        }

        $cache_set = wp_cache_set( $cache_key, $cache, 'megacal_event_cache', MEGACAL_EVENT_CACHE_EXPIRE_TIME );
        if( false === $cache_set ) {
            error_log( 'In-memory cache could not be set' );
        }

        return $events;

    }

    /**
     * Formats an event's time for display to the front-end
     * 
     * @param Event $event The Event object
     * 
     * @return string A formatted string 
     */
    private function megacal_get_event_time_string( $event ) {

        // All Day Event
        if( empty( $event->get_start_time() ) && empty( $event->get_end_time() ) )
            return '';

        $fmt = $this->megacal_get_time_fmt();
        $time = date( $fmt, strtotime( $event->get_start_time() ) ); 
        
        if( !empty( $event->get_end_time() ) ) {
            $time .= ' - ' . date( $fmt, strtotime( $event->get_end_time() ) );
        }

        return $time;

    }

    public function megacal_ajax_load_event_popup() {

        if( !DOING_AJAX ) die();

        check_ajax_referer( '_megacal_get_event_popup_nonce', '_nonce' );

        if( empty( $_POST['eventId'] ) || !is_numeric( $_POST['eventId'] ) ) {
            wp_send_json_error( array( 'message' => 'Invalid event ID' ) );
        }

        $event_id = intval( $_POST['eventId'] );
        $hover_cards = get_transient( MEGACAL_CACHED_HOVER_CARD_CACHE_KEY ) ?: array();

        if( empty( $hover_cards[$event_id] ) ) {

            try {

                $event_detail_response = MegaCalAPI::request( MegaCalAPI::EVENT_REQUEST, 'get_event', array(
                    'event_id' => $event_id,
                ));
    
                if( !( $event_detail_response instanceof EventDetailResponse ) ) {
                    wp_send_json_error( array( 'message' => 'Unexpected API response' ) );
                }
    
                $event = $event_detail_response->get_event();
                $hover_cards[$event_id] = $event;
    
                set_transient(
                    MEGACAL_CACHED_HOVER_CARD_CACHE_KEY,
                    $hover_cards,
                    3 * HOUR_IN_SECONDS
                );
    
            } catch( ApiException $e ) {
    
                wp_send_json_error( array( 'message' => $e->get_simple_message() ) );
    
            }

        } else {
            
            $event = $hover_cards[$event_id];

        }

        ob_start();

            require_once megacal_get_template_part( 'includes/partials/part', 'popup-content', false );
            $content = ob_get_contents();
        
        ob_end_clean();

        wp_send_json_success( array( 'content' => $content ) );

    }

    public function megacal_load_shortcode_options() {

        check_ajax_referer( 'load-shortcode-modal-nonce', '_nonce' );

        set_query_var( 'is_modal', true );

        echo '<div id="megacal-events-settings" class="wrap">';
            $this->megacal_display_shortcode_options();
        echo '</div>';

        wp_die();

    }

    public function megacal_get_approval_list() {

        check_ajax_referer( 'megacal_get_approval_list_nonce', '_nonce' );

        ob_start();
            require( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-approval-list.php' );
            $content = ob_get_contents();
        ob_end_clean();

        wp_send_json_success( array( 'content' => $content ) );

    }

    public function megacal_update_venue_details() {

        check_ajax_referer( 'megacal_update_relationships_nonce', '_nonce' );

        if( empty( $_POST['venue_id'] ) || $_POST['venue_id'] != $_POST['venue_id'] ) {
            wp_send_json_error( array( 'message' => 'Venue ID is required' ) );
        }

        $venue_id = intval( $_POST['venue_id'] );
        $name = sanitize_text_field( $_POST['name'] );
        $location = sanitize_text_field( $_POST['location'] );
        $published = boolval( $_POST['published'] ) ? true : false;

        try {

            $update_venue_response = MegaCalAPI::request( MegaCalAPI::VENUE_REQUEST, 'update_venue', array(
                'venue_id' => $venue_id,
                'name' => $name,
                'location' => $location,
                'published' => $published,
            ));

            if( !( $update_venue_response instanceof UpdateVenueResponse ) ) {
                wp_send_json_error( array( 'message' => 'Unexpected API response' ) );
            }

            $this->megacal_update_cached_upsert_vals();
            wp_send_json_success( array() );

        } catch( ApiException $e ) {

            wp_send_json_error( array( 'message' => $e->get_simple_message() ) );

        }

    }

    public function megacal_update_category_details() {

        check_ajax_referer( 'megacal_update_relationships_nonce', '_nonce' );

        if( empty( $_POST['category_id'] ) || $_POST['category_id'] != $_POST['category_id'] ) {
            wp_send_json_error( array( 'message' => 'Category ID is required' ) );
        }

        $category_id = intval( $_POST['category_id'] );
        $name = sanitize_text_field( $_POST['name'] );
        $published = boolval( $_POST['published'] ) ? true : false;

        try {

            $update_category_resopnse = MegaCalAPI::request( MegaCalAPI::CATEGORY_REQUEST, 'update_category', array(
                'category_id' => $category_id,
                'name' => $name,
                'published' => $published,
            ));

            if( !( $update_category_resopnse instanceof UpdateCategoryResponse ) ) {
                wp_send_json_error( array( 'message' => 'Unexpected API response' ) );
            }

            $this->megacal_update_cached_upsert_vals();
            wp_send_json_success( array() );

        } catch( ApiException $e ) {

            wp_send_json_error( array( 'message' => $e->get_simple_message() ) );

        }

    }

    private function megacal_display_shortcode_options() {

        $settings = self::megacal_get_settings();
        $connected = !empty( $settings['megacal_access_token'] );

        include( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/admin/admin-page-sc.php' );

    }

    private function megacal_display_admin_links() {

        include( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-admin-links.php' );

    }

    private function megacal_get_event_owner_filters() {

        $event_owners = get_transient( MEGACAL_CACHED_EVENT_OWNERS_CACHE_KEY );

        if( false === $event_owners ) {

            $event_owners = $this->megacal_update_cached_event_owners();

        }

        return $event_owners;

    }

    private function megacal_update_cached_event_owners() {

        try {

            $response = MegaCalAPI::request( 
                MegaCalAPI::EVENT_REQUEST, 
                'get_event_filters', 
                array() 
            );

            if( !( $response instanceof EventFilterResponse ) ) {
            
                error_log( 'Response was not EventFilterResponse' );
                return array();
    
            }
    
            $event_owners = $response->get_event_owners();
    
            set_transient( MEGACAL_CACHED_EVENT_OWNERS_CACHE_KEY, $event_owners, MEGACAL_EVENT_CACHE_EXPIRE_TIME );
    
            return $event_owners;

        } catch( ApiException $e ) {

            error_log( $e->getMessage() );
            return array();

        }

    }

    /** Flush all event caches */
    private function megacal_flush_event_cache() {

        /**
         * Filter Hook: megacal_flush_event_cache_keys
         * Use this hook to modify the list of cache keys that are flushed when event updates occur
         * 
         * @param array $cache_keys A list of cache keys associated with different event lists
         */
        $event_cache_keys = apply_filters( 'megacal_flush_event_cache_keys', array( 
            MEGACAL_ADMIN_CALENDAR_CACHE_KEY,
            MEGACAL_PUBLIC_CALENDAR_CACHE_KEY,
            MEGACAL_PAST_LIST_CACHE_KEY,
            MEGACAL_UPCOMING_LIST_CACHE_KEY,
            MEGACAL_CACHED_EVENT_OWNERS_CACHE_KEY,
            MEGACAL_CACHED_HOVER_CARD_CACHE_KEY,
            MEGACAL_NOTICE_COUNT_CACHE_KEY,
            MEGACAL_EVENT_DETAIL_CACHE_KEY,
            MEGACAL_GET_EVENTS_CACHE_KEY,
        ) );

        foreach( $event_cache_keys as $cache_key ) {

            /**
             * Action Hook: megacal_before_flush_event_cache_{cache_key}
             * Runs before the specified transient is deleted
             * 
             * @param string $cache_key The cache key
             */
            do_action( 'megacal_before_flush_event_cache_' . $cache_key, $cache_key );

            delete_transient( $cache_key );
        
            /**
             * Action Hook: megacal_after_flush_event_cache_{cache_key}
             * Runs after the specified transient is deleted
             * 
             * @param string $cache_key The cache key
             */
            do_action( 'megacal_after_flush_event_cache_' . $cache_key, $cache_key );

        }

        // Flush in-memory cache
        wp_cache_flush_group( 'megacal_event_cache' );

    }

    /** Flush cached upsert vals */
    private function megacal_flush_upsert_cache() {

        /**
         * Filter Hook: megacal_flush_upsert_cache_keys
         * Use this hook to modify the list of cache keys that are flushed when event updates occur
         * 
         * @param array $cache_keys A list of cache keys associated with different event lists
         * 
         */
        $upsert_cache_keys = apply_filters( 'megacal_flush_upsert_cache_keys', array( 
            MEGACAL_CACHED_MY_CATEGORIES_CACHE_KEY,
            MEGACAL_CACHED_VENUES_CACHE_KEY,
            MEGACAL_CACHED_CATEGORIES_CACHE_KEY,
        ) );

        foreach( $upsert_cache_keys as $cache_key ) {

            /**
             * Action Hook: megacal_before_flush_upsert_cache_{cache_key}
             * Runs before the specified transient is deleted
             * 
             * @param string $cache_key The cache key
             */
            do_action( 'megacal_before_flush_upsert_cache_' . $cache_key, $cache_key );

            delete_transient( $cache_key );

            /**
             * Action Hook: megacal_after_flush_upsert_cache_{cache_key}
             * Runs after the specified transient is deleted
             * 
             * @param string $cache_key The cache key
             */
            do_action( 'megacal_after_flush_upsert_cache_' . $cache_key, $cache_key );

        }

    }

    public static function megacal_get_settings( $option = 'megacal_options' ) {

        $settings = wp_cache_get( $option, 'megabase-calendar', false, $found );

		if( false === $found ) {
			
            $settings = get_option( $option );
            
            if( false == $settings ) {
                $settings = array();
            }
            
			wp_cache_set( $option, $settings, 'megabase-calendar' );
        }
        
        return $settings;

    }

    /** 
     * Gets a list of Venues, either from cache or the API
     * 
     * @param array $args Arguments to apply to the result
     * @return array<Venue> The list of Venues 
    */
    public function megacal_get_venue_list( $args = array() ) {

        $venues = get_transient( MEGACAL_CACHED_VENUES_CACHE_KEY );

        if( false === $venues ) {

            $vals = $this->megacal_update_cached_upsert_vals();
            $venues = !empty( $vals['venues'] ) ? $vals['venues'] : array();

        }

        if( !empty( $args ) ) {
            if( isset( $args['published'] ) ) {
                $venues = array_filter( $venues, function( $e ) use ( $args ) {
                    return $e->get_published() === $args['published'];
                } );
            }
        }

        return array_values( $venues );
        
    }

    /** 
     * Gets a list of Categories, either from cache or the API
     * 
     * @param array $args Arguments to apply to the result
     * @return array<EventCategory> The list of Categories 
    */
    public function megacal_get_category_list( $args = array() ) {

        $categories = get_transient( MEGACAL_CACHED_CATEGORIES_CACHE_KEY );

        if( false === $categories ) {

            $vals = $this->megacal_update_cached_upsert_vals();
            $categories = !empty( $vals['categories'] ) ? $vals['categories'] : array();

        }

        if( !empty( $args ) ) {
            if( isset( $args['published'] ) ) {
                $categories = array_filter( $categories, function( $e ) use ( $args ) {
                    return $e->get_published() === $args['published'];
                } );
            }
        }

        return array_values( $categories );
        
    }

    /** 
     * Gets a list of User's Categories, either from cache or the API
     * 
     * @param array $args Arguments to apply to the result
     * @return array<EventCategory> The list of User's Categories
    */
    public function megacal_get_my_category_list( $args = array() ) {

        $my_categories = get_transient( MEGACAL_CACHED_MY_CATEGORIES_CACHE_KEY );

        if( false === $my_categories ) {

            $vals = $this->megacal_update_cached_upsert_vals();
            $my_categories = !empty( $vals['my_categories'] ) ? $vals['my_categories'] : array();

        }

        if( !empty( $args ) ) {
            if( isset( $args['published'] ) ) {
                $my_categories = array_filter( $my_categories, function( $e ) use ( $args ) {
                    return $e->get_published() === $args['published'];
                } );
            }
        }

        return array_values( $my_categories );
        
    }

    /**
     * Updates the cached upsert data with fresh data from the API 
     */
    private function megacal_update_cached_upsert_vals() {

        try {

            $response = MegaCalAPI::request( 
                MegaCalAPI::EVENT_REQUEST, 
                'get_new_upsert', 
            );

            if( !( $response instanceof EventUpsertBodyResponse ) ) {
            
                error_log( 'Response was not EventUpsertBodyResponse' );
                return array();
    
            }

            $filter_response = MegaCalAPI::request(
                MegaCalAPI::EVENT_REQUEST,
                'get_event_filters',
                array()
            );

            if( !( $filter_response instanceof EventFilterResponse ) ) {

                error_log( 'Response was not EventFilterResponse' );
                return array();

            }
    
            $filter_cat_ids = array();
            foreach( $filter_response->get_event_categories() as $filter_cat ) {

                $all_cats[] = $filter_cat;

                if( false === $filter_cat->get_owner() ) {
                    continue;
                }

                $filter_cat_ids[] = $filter_cat->get_id();

            }
            
            $my_categories = array_filter( $filter_response->get_event_categories(), function( $e ) use ( $filter_cat_ids ) {
                return in_array( $e->get_id(), $filter_cat_ids );
            });

            $vals = array();
            $vals['venues'] = $response->get_venues();
            $vals['categories'] = $all_cats;
            $vals['my_categories'] = $my_categories;

            set_transient( MEGACAL_CACHED_VENUES_CACHE_KEY, $vals['venues'], 12 * HOUR_IN_SECONDS );
            set_transient( MEGACAL_CACHED_CATEGORIES_CACHE_KEY, $vals['categories'], 12 * HOUR_IN_SECONDS );
            set_transient( MEGACAL_CACHED_MY_CATEGORIES_CACHE_KEY, $vals['my_categories'], 12 * HOUR_IN_SECONDS );
    
            return $vals;

        } catch( ApiException $e ) {

            error_log( $e->getMessage() );
            return array();

        }

    }

    /**
     * Checks if the current account is a pro account
     */
    private function megacal_is_pro_account() {

        if( empty( self::$access_token ) ) {
            return false;
        } 

        $ping = $this->megacal_ping_user_account();
        
        if( false === $ping ){
            return false;
        }

        return true === $ping->get_pro_account();

    }

    /**
     * Pings the API for user details
     * 
     * @return PingResponse|bool The ping response or false on failure
     */
    private function megacal_ping_user_account() {

        $response = get_transient( MEGACAL_PING_RESPONSE_CACHE_KEY );

        if( false !== $response ) {
            return $response;
        }

        try {
        
            $response = MegaCalAPI::request( MegaCalAPI::PING_REQUEST, 'ping' );

            if( $response instanceof PingResponse ) {

                set_transient( MEGACAL_PING_RESPONSE_CACHE_KEY, $response, MEGACAL_EVENT_CACHE_EXPIRE_TIME );

                return $response;

            }
        
        } catch( ApiException $e ) {
            
            error_log( $e->getMessage() );

        }

        return false;

    }

    /**
     * Gets the time format based on settings
     * 
     * @param string $type Get the time format for php or js? - 'php' or 'js' - Default: 'php'
     */
    public function megacal_get_time_fmt( $type = 'php' ) {

        $settings = self::megacal_get_settings();

        if( $type === 'js' ) {
            
            $fmt = 'h:mma';

            if( !empty( $settings['megacal_time_fmt'] ) ) {
                $fmt = '24-hour' == $settings['megacal_time_fmt'] ? 'HH:mm' : $fmt; 
            }

        } else {

            $fmt = 'g:ia';

            if( !empty( $settings['megacal_time_fmt'] ) ) {
                $fmt = '24-hour' == $settings['megacal_time_fmt'] ? 'H:i' : $fmt; 
            }

        }

        return $fmt;

    }

    /**
     * Converts a string of comma-separated ids into an array of ints
     * 
     * @param string $csv The comma-separated list of ids
     * @return array<int> The array of IDs
     */
    private function megacal_get_ids_from_string( $csv ) {

        if( empty( $csv ) )
            return array();

        $ids = array();
        $raw_ids = explode( ',', $csv );

        foreach( $raw_ids as $id ) {
            
            if( $id != intval( $id ) )
                continue;

            if( empty( trim( $id ) ) )
                continue;

            $ids[] = trim( intval( $id ) );

        }

        return $ids;

    }

    /**
     * Maps recurrence types to custom names - if no mapping falls back to capitalized 
     * 
     * @param string $type The type name 
     * @param string $fmt The desired format - frequency, singular, plural
     * @return string The mapped type name
     * 
     */
    private function megacal_get_recurrence_type_mapping( $type, $fmt = MEGACAL_RECURRENCE_TYPE_FREQ_FMT ) {

        $map = array(

            MEGACAL_RECURRENCE_TYPE_FREQ_FMT => array(

                EventRecurrenceDetail::TYPE_DAILY => 'Daily',
                EventRecurrenceDetail::TYPE_WEEKLY => 'Weekly',
                EventRecurrenceDetail::TYPE_MONTHLY => 'Monthly',
                EventRecurrenceDetail::TYPE_ANNUALLY => 'Yearly',
                EventRecurrenceDetail::TYPE_WEEKDAY => 'Every Weekday (Mon - Fri)',
                EventRecurrenceDetail::TYPE_CUSTOM => 'Custom',
            
            ),

            MEGACAL_RECURRENCE_TYPE_SINGULAR_FMT => array(
                EventRecurrenceDetail::TYPE_DAILY => 'Day',
                EventRecurrenceDetail::TYPE_WEEKLY => 'Week',
                EventRecurrenceDetail::TYPE_MONTHLY => 'Month',
                EventRecurrenceDetail::TYPE_ANNUALLY => 'Year',
            ),

            MEGACAL_RECURRENCE_TYPE_PLURAL_FMT => array(
                EventRecurrenceDetail::TYPE_DAILY => 'Days',
                EventRecurrenceDetail::TYPE_WEEKLY => 'Weeks',
                EventRecurrenceDetail::TYPE_MONTHLY => 'Months',
                EventRecurrenceDetail::TYPE_ANNUALLY => 'Years',
            ),

        );

        if( empty( $map[$fmt] ) )
            return ucfirst( strtolower( $type ) );
        
        if( empty( $map[$fmt][$type] ) )
            ucfirst( strtolower( $type ) );

        return $map[$fmt][$type];
        
    }

    /**
     * Formats a number with its ordinal suffix
     *
     * @param int $number The number to format 
     */
    private function megacal_fmt_num_ordinal( $number ) {

        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        
        if( ( ( $number % 100 ) >= 11 ) && ( ( $number % 100 ) <= 13 ) )
            return $number. 'th';
        else
            return $number. $ends[$number % 10];

    }

    public function megacal_generate_seo_output() {

        if( !megacal_is_event_detail() || empty( get_query_var( 'event_id' ) ) ) {
            return;
        }

        $event_id = intval( get_query_var( 'event_id' ) );
        $event_detail_response = $this->megacal_get_event_details( $event_id );

        if( $event_detail_response instanceof WP_Error ) {
            wp_die( $event_detail_response->get_error_message() );
        }

        $event = $event_detail_response->get_event();

        // TODO: Check for Yoast & override their Schema Graph?

        /**
         * Filter Hook: megacal_seo_output_event_detail_schema
         * Allows you to intercept the output of the Event Detail schema
         * 
         * @param bool $output_schema True/False - Default: True
         */
        $output_schema = apply_filters( 'megacal_seo_output_event_detail_schema', true );

        if( $output_schema ) {
            $schema = $this->megacal_generate_schema_json_ld( $event );
            echo $schema->toScript();
        }

        /**
         * Filter Hook: megacal_seo_output_meta_title
         * Allows you to intercept the output of the Event Detail meta description
         * 
         * @param bool $output_meta_title True/False - Default: True
         */
        $output_meta_title = apply_filters( 'megacal_seo_output_meta_title', true );

        if( $output_meta_title ) {

            /**
             * Filter Hook: megacal_seo_meta_description_title
             * Allows you to filter the Event Title that is displayed in the page meta title
             * 
             * @param string $description_title The Event Title with date appended
             * @param string $title The Event Title without date appended
             */
            $event_name = apply_filters( 
                'megacal_seo_meta_title',
                sprintf( '%s - %s', esc_attr( strip_tags( $event->get_title() ) ), date( 'm/d/Y', strtotime( $event->get_event_date() ) ) ),
                $event->get_title(),
            );
    
            echo sprintf( '<meta name="title" content="%s">', $event_name );

        }

        /**
         * Filter Hook: megacal_seo_output_meta_description
         * Allows you to intercept the output of the Event Detail meta description
         * 
         * @param bool $output_meta_description True/False - Default: True
         */
        $output_meta_description = apply_filters( 'megacal_seo_output_meta_description', true );

        if( $output_meta_description ) {

            /**
             * Filter Hook: megacal_seo_meta_description_title
             * Allows you to filter the Event Title that is displayed in the page meta description
             * 
             * @param string $description_title The Event Title with date appended
             * @param string $title The Event Title without date appended
             */
            $event_name = apply_filters( 
                'megacal_seo_meta_description_title',
                sprintf( '%s - %s', esc_attr( strip_tags( $event->get_title() ) ), date( 'm/d/Y', strtotime( $event->get_event_date() ) ) ),
                $event->get_title(),
            );
    
            if( !empty( $event->get_description() ) ) {
                $event_description = esc_attr( strip_tags( $event->get_description() ) );
                echo sprintf( '<meta name="description" content="%s: %s">', $event_name, $event_description );
            } else {
                echo sprintf( '<meta name="description" content="%s">', $event_name );
            }

        }

    }

    /**
     * Generates an Event schema
     * 
     * @param MegaCal\Client\Event $event The Event Details
     * @return Spatie\SchemaOrg\Event The generated schema object
     */
    public function megacal_generate_schema_json_ld( $event ) {

        $event_id = $event->get_id();
        $event_name = sprintf( '%s - %s', $event->get_title(), date( 'm/d/Y', strtotime( $event->get_event_date() ) ) );
        $event_start = $event->get_start_time() 
            ? $event->get_event_date() . ' ' . $event->get_start_time() 
            : $event->get_event_date();

        $start_date = $this->megacal_get_wp_datetime( $event_start );
        
        $event_schema = Schema::event()
            ->identifier( $event_id )
            ->name( $event_name )
            ->url( $this->get_event_detail_url( $event_id ) )
            ->startDate( $start_date->format( 'Y-m-d\TH:i:s\ZP' ) );

        if( !empty( $event->get_end_time() ) ) {
            $end_date = $this->megacal_get_wp_datetime( $event->get_event_date() . ' ' . $event->get_end_time() );
            $event_schema->endDate( $end_date->format( 'Y-m-d\TH:i:s\ZP' ) );
        }

        if( !empty( $event->get_description() ) ) {
            $event_schema->description( $event->get_description() );
        }
        
        if( !empty( $event->get_venue() ) ) {
            
            $venue = $event->get_venue();
            $combined_location = $venue->get_name();

            if( !empty( $venue->get_location() ) ) {
                $combined_location .= ', ' . $venue->get_location();
            }

            $event_schema->location( $combined_location );

        }

        if( !empty( $event->get_image_url() ) ) {
            $event_schema->image( $event->get_image_url_square() );
        }

        /**
         * Filter Hook: megacal_schema_json_ld
         * Filters the Event schema markup that we are outputting on the Event Detail page
         * 
         * @param Spatie\SchemaOrg\Event $event_schema The Schema object before being converted to a script
         * @param MegaCal\Client\Event $event The Event Details
         */
        return apply_filters( 'megacal_schema_json_ld', $event_schema, $event );

    }

    /** Override Event Page Title - This may be overridden by SEO plugins */
    public function megacal_event_detail_page_title( $parts ) {

        if( !megacal_is_event_detail() || empty( get_query_var( 'event_id' ) ) ) {
            return $parts;
        }

        $event_id = intval( get_query_var( 'event_id' ) );
        $event_detail_response = $this->megacal_get_event_details( $event_id );
        
        if( $event_detail_response instanceof WP_Error ) {
            wp_die( $event_detail_response->get_error_message() );
        }

        $event = $event_detail_response->get_event();

        /**
         * Filter Hook: megacal_event_detail_page_title
         * Filters the page title override that we use on the Event Detail page
         * 
         * @param string $title The full page title override
         * @param string $event_title The Event's title, without date appended
         * @param string $event_date The Event's date, as a string
         * @param MegaCal\Client\Event $event The event details 
         */
        $parts['title'] = apply_filters( 
            'megacal_event_detail_page_title', 
            sprintf( '%s - %s', $event->get_title(), date( 'm/d/Y', strtotime( $event->get_event_date() ) ) ),
            $event->get_title(),
            $event->get_event_date(),
            $event, 
        );

        return $parts;

    }

    /** Register the Shortcode **/
    public static function sc_megacal_events( $atts ) {

        self::$shortcode_instances += 1;
        $shortcode_instance_id = self::$shortcode_instances;

        $settings = self::megacal_get_settings();
        $connected = !empty( $settings['megacal_access_token'] ); 

        ob_start();

        //Include the shortcode output
        include megacal_get_template_part( 'views/megacal', 'events-sc-output', false );

        $content = ob_get_clean();

        return $content;

    }

    /**
     * Creates the plugin action links on the Plugins screen
     */
    function megacal_action_links( $links ) {

        $settings = self::megacal_get_settings();

        $links[] = '<a href="'. esc_url( get_admin_url(null, 'admin.php?page=megacal-integration') ) .'">Settings</a>';

        if( !$this->megacal_is_pro_account() && !isset( $_GET['paid'] ) ) {
            $links[] = '<a href="'. esc_url( get_admin_url(null, 'admin.php?page=megacal-upgrade') ) .'">Upgrade to Pro</a>';
        }

       return $links;

    }

    /**
     * Strips unicode characters
     */
    function megacal_strip_unicode( $target_string ) {

        $chr_map_defaults = array(

            // Windows codepage 1252
            "\xC2\x82", // U+0082⇒U+201A single low-9 quotation mark
            "\xC2\x84", // U+0084⇒U+201E double low-9 quotation mark
            "\xC2\x8B", // U+008B⇒U+2039 single left-pointing angle quotation mark
            "\xC2\x91", // U+0091⇒U+2018 left single quotation mark
            "\xC2\x92", // U+0092⇒U+2019 right single quotation mark
            "\xC2\x93", // U+0093⇒U+201C left double quotation mark
            "\xC2\x94", // U+0094⇒U+201D right double quotation mark
            "\xC2\x9B", // U+009B⇒U+203A single right-pointing angle quotation mark
 
            // Regular Unicode 
            "\xC2\xAB"    , // U+00AB left-pointing double angle quotation mark
            "\xC2\xBB"    , // U+00BB right-pointing double angle quotation mark
            "\xE2\x80\x98", // U+2018 left single quotation mark
            "\xE2\x80\x99", // U+2019 right single quotation mark
            "\xE2\x80\x9A", // U+201A single low-9 quotation mark
            "\xE2\x80\x9B", // U+201B single high-reversed-9 quotation mark
            "\xE2\x80\x9C", // U+201C left double quotation mark
            "\xE2\x80\x9D", // U+201D right double quotation mark
            "\xE2\x80\x9E", // U+201E double low-9 quotation mark
            "\xE2\x80\x9F", // U+201F double high-reversed-9 quotation mark
            "\xE2\x80\xB9", // U+2039 single left-pointing angle quotation mark
            "\xE2\x80\xBA", // U+203A single right-pointing angle quotation mark
 
        );

        /**
         * Filter Hook: megacal_strip_unicode_char_map
         * Filters our internal map of unicode characters that are stripped from input - Use this if you have 
         * special characters that you want to strip from input. Note - You can't remove our defaults 
         * 
         * @param array $char_map The unicode characters to be stripped
         */
        $chr_map = apply_filters( 'megacal_strip_unicode_char_map', $chr_map_defaults );
        $chr_map = array_merge( $chr_map, $chr_map_defaults );

        return str_replace( $chr_map, '', $target_string );

    }

    /**
     * Returns an escaped version of $content passed through wp_kses_post and wpautop. Intentionally ignores shortcodes
     * 
     * @param string $content The content to escape
     * @return string The escaped content
     */
    function megacal_esc_wysiwyg( $content ) {

        /**
         * Filter Hook: megacal_esc_wysiwyg
         * Filters the output from megacal_esc_wysiwyg before it is rendered. We apply wp_kses_post and wpautop to wysiwyg output.
         * This filter allows you to change how the content is escaped and transformed, if you need to, before it's rendered.
         * 
         * @param string $content The content after we have transformed it
         * @param string $raw The raw, unescaped content as the function recieved it 
         */
        return apply_filters( 'megacal_esc_wysiwyg', wp_kses_post( wpautop( $content ) ), $content );

    }

    public static function get_access_token() {
        return self::$access_token;
    }

    public static function get_refresh_token() {
        return self::$refresh_token;
    }

    public static function maybe_update_access_token( $access_token ) {

        if( $access_token == self::$access_token || empty( $access_token ) ) {
            return;
        }

        $parts = explode( '.', $access_token );
        if( 3 !== count( $parts ) ) {
            error_log( 'maybe_update_access_token: invalid JWT' );
            return;
        }

        $settings = self::megacal_get_settings();

        self::$access_token = $access_token;
        $settings['megacal_access_token'] = $access_token;
        update_option( 'megacal_options', $settings );

    }

    /**
     * Gets a list of public Events
     * 
     * @param array $args The query args
     * 
     * @return Array<Event>|string|WP_Error An array of Events, the raw json response, or WP_Error on failure
     */
    public function megacal_get_public_events( $args ) {

        $args['published'] = true;
        $events = $this->megacal_get_events( $args );
        return $events;

    }

    public function megacal_register_cron_events() {

        if( !wp_next_scheduled( 'megacal_check_event_processing_cron' ) ) {
            wp_schedule_event( time(), 'every_two_minutes', 'megacal_check_event_processing_cron' );
        }

        if( !wp_next_scheduled( 'megacal_clear_debug_log_cron' ) ) {
            $now = new DateTime();
            $first_of_next_month = $now->modify('+1 month')->format( 'Y-m-01 H:i:s' );

            wp_schedule_event( strtotime( $first_of_next_month ), 'monthly', 'megacal_clear_debug_log_cron' );
        }

    }

    public function megacal_check_event_processing() {
        
        $execution_id_store_update = array();
        $errors = array();
        $execution_id_store = $this->megacal_get_settings( 'megacal_execution_id_store' );

        if( empty( $execution_id_store ) ) {
            return;
        }

        foreach( $execution_id_store as $execution_id => $details ) {

            try {

                $processing_response = MegaCalAPI::request( 
                    MegaCalAPI::EVENT_REQUEST, 
                    'get_event_processing', 
                    array( 'execution_id' => $execution_id ) 
                );

                if( !( $processing_response instanceof EventProcessingResponse ) ) {
                    throw new ApiException( sprintf( 'Unexpected response type: "%s"', get_class( $processing_response ) ) );
                }

                $event_processing_details = $processing_response->get_event_processing_details();
                $phase = $event_processing_details->get_phase();
                $stages = $event_processing_details->get_stages();

                if( EventProcessingDetail::PHASE_TYPE_COMPLETED === $phase ) {

                    $flushable_stages = array(
                        EventProcessingStage::STAGE_PROCESS_EVENT_RECURRENCE,
                        EventProcessingStage::STAGE_PROCESS_CHANGE_EVENT_RECURRENCE,
                    );
                    
                    foreach( $stages as $stage ) {
                        // Flush cache if recurrence
                        if( in_array( $stage->get_name(), $flushable_stages ) ) {
                            $this->megacal_flush_event_cache();
                            break;
                        }
                    }

                    continue;
                }

                // Give tasks a day grace period to complete
                if( $details['created'] <= ( time() - DAY_IN_SECONDS ) ) {

                    $failed_stage = false;
                    $message_id = '';
                    
                    foreach( $stages as $stage ) {
                        if( EventProcessingStage::PHASE_TYPE_FAILED === $stage->get_phase() ) {
                            $failed_stage = true;
                            $message_id = $stage->get_message_id();
                            break;
                        }
                    }
    
                    if( $failed_stage ) {
                        $err = sprintf( 
                            'An event processing error was encountered, please contact support and provide the following details. Message ID: %s Execution ID: %s',
                            $message_id,
                            $execution_id
                        );

                        $errors[] = $err;
                        error_log( $err );

                        continue;
                    }

                }

                // keep any who are not complete but not past the grace period
                $execution_id_store_update[$execution_id] = $details;

            } catch( ApiException $e ) {

                // We keep the execution ids and check later if there is an issue 
                error_log( $e->getMessage() );
                $execution_id_store_update[$execution_id] = $details;
                continue;

            }

        }

        // Check anything new that was not just processed
        $final_execution_id_store = array_diff_key( $this->megacal_get_settings( 'megacal_execution_id_store' ), $execution_id_store );
        $final_execution_id_store = array_merge( $final_execution_id_store, $execution_id_store_update );
        $processing_errors = array_merge( $this->megacal_get_settings( 'megacal_processing_errors' ), $errors );

        update_option( 'megacal_execution_id_store', $final_execution_id_store );
        update_option( 'megacal_processing_errors', $processing_errors );

    }

    public function megacal_clear_debug_log() {
        file_put_contents( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'debug.log', '' );
    }

    public function megacal_register_custom_schedules() {

        add_filter( 'cron_schedules', function( $schedules ) {

            $schedules['every_two_minutes'] = array(
                'interval' => 2 * MINUTE_IN_SECONDS,
                'display'  => 'Every Two Minutes',
            );
            
            $schedules['every_five_minutes'] = array(
                'interval' => 5 * MINUTE_IN_SECONDS,
                'display'  => 'Every Five Minutes',
            );
    
            $schedules['monthly'] = array(
                'interval' => MONTH_IN_SECONDS,
                'display'  => 'Monthly',
            );
    
            return $schedules;

        } );

    }

    /**
     * A simple wrapper to expose the get_events() method
     * 
     * @param array $args The array of arguments to pass to get_events() - see EventRequest for options 
     * 
     * $args['return'] = 'response' - returns the raw response associative array
     * 
     * @return array<Event>|string|WP_Error The array of events, the raw json response, or WP_Error on failure
     */
    public function megacal_get_events( $args = array() ) {

        $return = '';
        $cache_bypass = false;

        if( !empty( $args['cache_bypass'] ) ) {
            $cache_bypass = $args['cache_bypass'];
            unset( $args['cache_bypass'] );
        }

        $cache = $cache_bypass 
            ? false 
            : wp_cache_get( MEGACAL_GET_EVENTS_CACHE_KEY, 'megacal_event_cache' );

        $cache_sub_key = md5( serialize( $args ) );

        if( false === $cache ) {
            $cache = $cache_bypass 
                ? false 
                : get_transient( MEGACAL_GET_EVENTS_CACHE_KEY );
        }

        if( false === $cache || !array_key_exists( $cache_sub_key, $cache ) ) {

            if( !empty( $args['return'] ) ) {
                $return = $args['return'];
                unset( $args['return'] );
            }

            $response = $this->megacal_get_event_request( $args );

            if( $response instanceof WP_Error ) {
                return $response;
            }

            $body = $response->get_response_body();
            $results = $return == 'response' && !empty( $body['events'] ) ? $body['events'] : $response->get_events();

            $cache[$cache_sub_key] = $results;

            set_transient( MEGACAL_GET_EVENTS_CACHE_KEY, $cache, MEGACAL_EVENT_CACHE_EXPIRE_TIME );

        } else {
            $results = $cache[$cache_sub_key];
        }

        $cache_set = wp_cache_set( MEGACAL_GET_EVENTS_CACHE_KEY, $cache, 'megacal_event_cache', MEGACAL_EVENT_CACHE_EXPIRE_TIME );
        if( false === $cache_set ) {
            error_log( 'In-memory cache could not be set' );
        }

        /**
         * Filter Hook: megacal_get_events_result
         * Filters the resulting array from megacal_get_events
         * 
         * @param array<Event> $events
         */
        return apply_filters( 'megacal_get_events_result', $results ); 

    }

    /**
     * Fetches Events from the MegaCal API 
     * 
     * @param array $args The request args - see EventRequest for options
     * @return EventListResponse|WP_Error The EventListResponse object, or WP_Error on failure
     */
    public function megacal_get_event_request( $args = array() ) {
        
        try {

            $response = MegaCalAPI::request( MegaCalAPI::EVENT_REQUEST, 'get_events', $args );

            if( !( $response instanceof EventListResponse ) ) {
                throw new ApiException( 'Unexpected response object' );
            }

            return $response;

        } catch( Exception $e ) {

            error_log( $e->getMessage() );
            return new WP_Error( $e->getCode(), $e->getMessage() );

        }
    
    }

    /**
     * Gets and formats a Venue name from the given Event
     * 
     * @param Event $event The event object
     * @return string The Venue name, the null Venue name from settings, or empty
     */
    public function megacal_get_venue_name( $event ) {

        if( empty( $event ) || !( $event instanceof Event ) ) {
            return '';
        }

        if( empty( $event->get_venue() ) ) {
            $settings = self::megacal_get_settings();

            if( empty( $settings['megacal_null_venue_label'] ) ) {
                return '';
            }
                
            return $settings['megacal_null_venue_label'];
        }

        return $event->get_venue()->get_name();
    }

    /**
     * Return the Stripe customer portal url - Can be overridden in .env for dev purposes
     */
    private function get_stripe_portal_url() {
        return !empty( $_ENV['MEGACAL_STRIPE_PORTAL_URL'] ) ? $_ENV['MEGACAL_STRIPE_PORTAL_URL'] : MEGACAL_STRIPE_PORTAL_URL;
    }

    /**
     * Return the url to the event detail page
     * 
     * @param int The event ID to include in the url - Optional, if empty you will get the base URL without an event ID
     * 
     * @return string The URL to the event detail page
     */
    public function get_event_detail_url( $event_id = '' ) {

        $settings = $this->megacal_get_settings();

        if( empty( $settings['megacal_events_page'] ) ) {
            error_log( 'Event Detail Page setting is empty! Try saving settings.' );
            return '';
        }

        $event_detail_page = get_post( $settings['megacal_events_page'] );

        if( empty( $event_detail_page ) ) {
            error_log( 'Event Detail Page is empty!' );
            return '';
        }

        if( !empty( $event_id ) && intval( $event_id ) != $event_id ) {
            error_log( sprintf( '%s is not a valid event ID', $event_id ) );
            $event_id = '';
        }

        $detail_link_with_id = get_option( 'permalink_structure' ) === '/' || empty( get_option( 'permalink_structure' ) )  
            ? get_permalink( $event_detail_page ) . '&event_id='. intval( $event_id ) 
            : trailingslashit( get_permalink( $event_detail_page ) ) . intval( $event_id );

        return empty( $event_id ) ? get_permalink( $event_detail_page ) : $detail_link_with_id;

    }

    /** 
     * Return the trimmed content for display. Content is run through strip_shortcodes, strip_tags, then wp_trim_words
     * in that order. To override or intercept this function, use the megacal_trim_content filter hook.
     *
     * @param string The raw content
     *
     * @return string The trimmed content
    */  
    public function trim_content( $content ) {

        /**
         * Filter Hook: megacal_excerpt_length
         * Filters the default excerpt trim length when generating an excerpt
         * 
         * @param int $length - Default: 25
         */
        $excerpt_legnth = apply_filters( 'megacal_excerpt_length', MEGACAL_EXCERPT_LENGTH );

        /**
         * Filter Hook: megacal_excerpt_more
         * Filters the default excerpt more string when generating an excerpt
         * 
         * @param string $more - Default: '&hellip;'
         */
        $excerpt_more = apply_filters( 'megacal_excerpt_more', MEGACAL_EXCERPT_MORE );

        /**
         * Filter Hook: megacal_trim_content
         * Filters the trimmed excerpt string when generating an excerpt
         * 
         * @param string $trimmed_content The trimmed excerpt
         *
         * @param string $raw_content The original content before it was trimmed
         */
        return apply_filters( 'megacal_trim_content', wp_trim_words( strip_tags( strip_shortcodes( $content ) ), $excerpt_legnth, $excerpt_more ), $content );

    }

    public static function store_execution_id( $execution_id ) {

        $execution_id_store = self::megacal_get_settings( 'megacal_execution_id_store' );
        $execution_id_store[$execution_id] = array( 'created' => time() );
        update_option( 'megacal_execution_id_store', $execution_id_store );

    }

    public static function get_instance() {
        if(!empty(self::$instance)) {
            return self::$instance;
        } else {
            return new self();
        }
    }

}

// Instantiate the Plugin
$MegabaseCalendar = MegabaseCalendar::get_instance();

// Instantiate the API Accessor
$MegaCalAPI = MegaCalAPI::get_instance();

//Register the shortcode
add_shortcode( 'megacal', array( $MegabaseCalendar, 'sc_megacal_events' ) );

if (!function_exists('megacal_events')) {
    
    /**
     * Function for use in theme files
     * @param array args The arguments for the MegaCal Instance
     **/
    function megacal_events( $args = array() ) {

        $args = wp_parse_args( $args, get_default_megacal_args() );
        echo MegabaseCalendar::sc_megacal_events( $args );
    
    }

}

/**
 *  Gets default args for shortcode/template include
 **/
if( !function_exists( 'get_default_megacal_args' ) ) {

    function get_default_megacal_args() {

        $settings = MegabaseCalendar::megacal_get_settings();

        return array(
            'type' => '',
            'style' => $settings['megacal_default_style'],
            'display' => 'text',
            'theme' => 'light',
            'descrip' => FALSE,
            'view' => 'list',
            'buttons' => 'left',
            'showfilters' => FALSE,
            'hideview' => FALSE,
        );

    }

}

//Template loader functions - Allows overriding by theme
if (!function_exists('megacal_get_template_part')) {
    function megacal_get_template_part($slug, $name = null, $load = true) {

        // Setup possible parts
        $templates = array();

        if (isset($name))
            $templates[] = $slug . '-' . $name . '.php';
        else
            $templates[] = $slug . '.php';

        /**
         * Filter Hook: megacal_get_template_part
         * Filters calls to megacal_get_template_part, before the template parts are rendered
         * 
         * @param array $templates The filenames of the templates to be loaded
         * @param string $slug The first argument passed to megacal_get_template_part
         * @param string $name The second argument passed to megacal_get_template_part
         */
        $templates = apply_filters( 'megacal_get_template_part', $templates, $slug, $name );

        return megacal_locate_template( $templates, $load, false );

    }
}

if (!function_exists('megacal_locate_template')) {

    function megacal_locate_template($template_names, $load = false, $require_once = true) {

        // No file found yet
        $located = false;

        // Try to find a template file
        foreach ((array)$template_names as $template_name) {

            // Continue if template is empty
            if (empty($template_name))
                continue;

            // Trim off any slashes from the template name
            $template_name = ltrim($template_name, '/');

            /**
             * Filter Hook: megacal_locate_template_theme_dir
             * Filters the template override theme directory name
             * 
             * @param string $dir The theme override directory - Default: 'megabase-calendar/'  
             */
            $megacal_theme_dir = trailingslashit( ltrim( apply_filters( 'megacal_locate_template_theme_dir', 'megabase-calendar/' ), '/' ) );

            // Check child theme first
            if (file_exists(trailingslashit(get_stylesheet_directory()) . $megacal_theme_dir . $template_name)) {
                $located = trailingslashit(get_stylesheet_directory()) . $megacal_theme_dir . $template_name;
                break;

                // Check parent theme next
            } elseif (file_exists(trailingslashit(get_template_directory()) . $megacal_theme_dir . $template_name)) {
                $located = trailingslashit(get_template_directory()) . $megacal_theme_dir . $template_name;
                break;

                // Check plugin last
            } elseif (file_exists(trailingslashit(MEGACAL_PLUGIN_DIR) . $template_name)) {
                $located = trailingslashit(MEGACAL_PLUGIN_DIR) . $template_name;
                break;
            }
        }

        if ( true == $load && !empty( $located ) )
            load_template( $located, $require_once );

        return $located;
    }

}

if( !function_exists( 'megacal_get_default_event_image_path' ) ) {
    function megacal_get_default_event_image_path() {
        /**
         * Filter Hook: megacal_default_event_image_path
         * Filters the default event image url
         * 
         * @param string $path The url to the default image - Default: https://domain.com/wp-content/plugins/megabase-calendar/assets/img/default-event.png
         */
        return apply_filters( 'megacal_default_event_image_path', plugins_url( '/assets/img/default-event.png', MEGACAL_PLUGIN ) );
    }
}

if( !function_exists( 'megacal_is_event_detail' ) ) {
    function megacal_is_event_detail() {
        
        global $post;

        $settings = MegabaseCalendar::get_instance()->megacal_get_settings();
        $event_detail_page = !empty( $settings['megacal_events_page'] ) ? intval( $settings['megacal_events_page'] ) : '';

        return $post->ID === intval( $event_detail_page );

    }
}

if( !function_exists( 'megacal_array_is_list' ) ) {
    // xxx: Until it is reasonable to stop supporting versions < PHP 8.1 we'll
    // use this custom polyfill implementation of array_is_list
    function megacal_array_is_list( $arr ) {
        return $arr  === [] || ( array_keys( $arr ) === range( 0, count( $arr ) - 1 ) );
    }
}

endif; //if(!class_exists)
