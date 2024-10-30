<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! defined( 'MEGACAL_PLUGIN_DIR' ) ) exit; 
if ( ! defined( 'MEGACAL_API_DIR' ) ) exit; 

require_once( untrailingslashit( MEGACAL_PLUGIN_DIR ) . '/vendor/autoload.php' );

// General plugin files
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/class-api-exception.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/class-megacal-client.php' );

// Models 
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/common/class-megacal-model.php' );

require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/venue/class-venue.php' );

require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/user/class-user.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/user/class-tagged-user.php' );

require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/event/class-event-category.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/event/class-filter-category.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/event/class-event.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/event/class-event-recurrence-detail.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/event/recurrence/class-end-condition.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/event/recurrence/class-weekly-recurrence.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/event/recurrence/class-monthly-recurrence.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/event/recurrence/class-annually-recurrence.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/event/recurrence/class-custom-recurrence.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/event/recurrence/class-daily-custom-recurrence.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/event/recurrence/class-weekly-custom-recurrence.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/event/recurrence/class-monthly-custom-recurrence.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/event/recurrence/class-annually-custom-recurrence.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/event/processing/class-event-processing-stage.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/event/processing/class-event-processing-detail.php' );

// Response Models 
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/class-megacal-response.php' );

require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/auth/class-register-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/auth/class-check-handle-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/auth/class-ping-response.php' );

require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/event/class-event-detail-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/event/class-event-filter-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/event/class-event-delete-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/event/class-event-list-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/event/class-event-publish-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/event/class-event-upsert-body-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/event/class-event-upsert-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/user/class-get-user-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/user/class-get-approval-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/user/class-put-approval-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/event/class-event-recurrence-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/event/class-event-processing-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/venue/class-get-venues-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/venue/class-update-venue-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/category/class-get-categories-response.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/response_models/category/class-update-category-response.php' );

// Request Models
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/request_models/class-megacal-request.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/request_models/class-event-request.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/request_models/class-auth-request.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/request_models/class-user-request.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/request_models/class-ping-request.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/request_models/class-venue-request.php' );
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/models/request_models/class-category-request.php' );

// API Accessor
require_once( untrailingslashit( MEGACAL_API_DIR ) . '/class-megacal-api.php' );