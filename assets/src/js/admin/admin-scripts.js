 (function($) {
    
    const GENERIC_ERROR_MSG = 'Please <a href="#" class="page-refresh-btn">refresh</a> the page. If you see this message again, please contact support@megabase.co.';
    var $document = $(document);

    $document.ready(function() {

        var $registerForm = $( '#megacal-register-form' );
        var $registerHandleField = $( '#megacal-register-handle' );
        var $checkHandleBtn = $( '#megacal-check-handle-button' );
        var $registerBtn = $( '.megacal-register-button' );
        var $colorpickers = $( '.megacal-color-colorpicker-input' );
        var $opacitySliders = $( '.megacal-opacity-slider' );
        var $colorTextInputs = $( '.megacal-color-text-input' );
        var $colorResets = $( '.megacal-color-input-reset' );

        $document.on( 'click', '.page-refresh-btn', function( e ) {
            e.preventDefault();
            window.location.href = window.location.href;
        } );

        setupAdminTabs( document );

       //Copy to clipboard button
        $document.on('click', '#megacal-events-settings-sc .copyToClipboard', function(e) {

            e.preventDefault();

            var copyTextarea = $('.shortcode'); 
            copyTextarea.select();

            try {

                var successful = document.execCommand('copy');

                if( successful )
                    $('.copySuccess').fadeIn().delay(200).fadeOut();
                else
                    $('.copyFail').fadeIn().delay(200).fadeOut();

            } catch (err) {

                console.error( err );
                $('.copyFail').fadeIn().delay(200).fadeOut();
            
            }
        
        });

        $( '#megacal-show-tokens' ).on( 'click', function( e ) {

            e.preventDefault();

            $( '#megacal_access_token' ).attr( 'type', 'text' ).closest( 'tr.hidden' ).addClass( 'megacal-row' ).removeClass( 'hidden' );
            $( '#megacal_refresh_token' ).attr( 'type', 'text' ).closest( 'tr.hidden' ).addClass( 'megacal-row' ).removeClass( 'hidden' );

            $( 'body,html' ).animate({
                scrollTop: 0,
            });

            $( '.megacal-admin-tabs li > a' ).first().trigger( 'click' );

        });

        $( '#megacal-reset-account' ).on( 'click', function( e ) {

            e.preventDefault();
            var confirm = window.confirm( 'Do you really want to unlink your MegaCalendar account from this site? (You will lose your existing Events)' );

            if( !confirm ) {
                return false;
            }

            var nonce = $( '#_megacal_unlink_account_nonce' ).val();
            window.location = megacal_admin_script_opts.settings_url + "&unlink=true&nonce=" + nonce;

        } );

        // Color Customization fields
        $colorpickers.on( 'change', function( e ) {

            var $this = $( this ); 
            var $container = $this.parent();
            $container.find( '.megacal-color-text-input' ).val( $this.val() );

        } );

        var colorTextInputDebounce;
        $colorTextInputs.on( 'keyup', function( e ) {
            
            var $this = $( this );

            if( colorTextInputDebounce )
                clearTimeout( colorTextInputDebounce );

            colorTextInputDebounce = setTimeout( 
                colorTextInputHandler.bind( $this ), 
                1000 
            );

        } );

        $colorTextInputs.on( 'focus', function() {
            $( this ).select();
        } );

        $colorResets.on( 'click', function( e ) {

            e.preventDefault();
            let $this = $( this );
            let $container = $this.parent();
            let $colorpicker = $container.find( '.megacal-color-colorpicker-input' );
            let $opacitySlider = $container.find( '.megacal-opacity-slider' );
            let defaultColor = $this.data( 'color' );
            let defaultOpacity = 85;

            $colorpicker.val( defaultColor ).trigger( 'change' );

            if( $opacitySlider.length > 0 ) {
                var $labelVal = $container.find( '.megacal-opacity-slider-val' );
                $opacitySlider.val( defaultOpacity );
                $labelVal.text( defaultOpacity );
            }

            $this.hide();

        } );

        $opacitySliders.on( 'input', function( e ) {

            var $this = $( this );
            var $container = $this.closest( '.megacal-opacity-slider-container' );
            var $labelVal = $container.find( '.megacal-opacity-slider-val' );

            $labelVal.text( $this.val() );

        } );

        function colorTextInputHandler() {
           
            var $input = $( this );
            var $container = $input.parent();
            var $colorpicker = $container.find( '.megacal-color-colorpicker-input' );

            if( isValidHexCode( $input.val() ) ) {
                $colorpicker.val( $input.val() );
            } else {
                showAlertNotification( 'Invalid color code value', 'error' );
                $input.val( $colorpicker.val() );
            }

        }

        // Turn on/off check handle button
        $registerHandleField.on( 'keyup', function() {

            var $this = $( this );

            if( $this.val() ) {
                $checkHandleBtn.prop( 'disabled', false );
            } else {
                $checkHandleBtn.prop( 'disabled', true );
            }

        } );

        // Check Handles
        $checkHandleBtn.on( 'click', function( e ) {

            e.preventDefault(); 

            var handle = $registerHandleField.val();
            var _nonce = $( '#_megacal_check_handle_nonce' ).val();

            var check_handle_data = {
                action: 'megacal_check_handle',
                handle,
                _nonce,
            };
    
            $.post(

                megacal_admin_script_opts.ajax_url,
                check_handle_data,
                function( response ) {
                    
                    if( false == response.success ) {
                        
                        clearAlertNotification();
                        showAlertNotification( response.data.message, 'error' );

                        return;
                    }

                    var unique = response.data.unique;
                    
                    if( true == unique ) {
                        $registerHandleField.removeClass( 'invalid' );
                        $registerHandleField.addClass( 'valid' );
                    } else {
                        $registerHandleField.removeClass( 'valid' );
                        $registerHandleField.addClass( 'invalid' );
                    }

                }

            )
            .fail( function() {

                clearAlertNotification();
                showAlertNotification( 'Something isn\'t right...', 'error' );
            
            }); 

        });

        // Registration form validation
        $( '#megacal-register-form input' ).on( 'keyup', function() {

            checkRequiredFields( $registerForm, $registerBtn );

        });

        // Register
        $registerForm.on( 'submit', function( e ) {

            e.preventDefault();
            
            var form = $( this )[0];
            var formData = new FormData( form );
            
            if( !formData.get( 'firstname' ) ) {
                alert( 'firstname cannot be empty' );
                return;
            }

            if( !formData.get( 'lastname' ) ) {
                alert( 'lastname cannot be empty' );
                return;
            }

            if( !formData.get( 'handle' ) ) {
                alert( 'handle cannot be empty' );
                return;
            }

            if( !formData.get( 'email' ) ) {
                alert( 'email cannot be empty' );
                return;
            }

            if( !formData.get( 'calendarName' ) ) {
                alert( 'calendarName cannot be empty' );
                return;
            }

            var firstname = formData.get( 'firstname' );
            var lastname = formData.get( 'lastname' );
            var handle = formData.get( 'handle' );
            var email = formData.get( 'email' );
            var calendarName = formData.get( 'calendarName' );
            var phone = formData.get( 'phone' );
            var _nonce = formData.get( '_megacal_register_nonce' );

            var registerData = {
                action: 'megacal_register',
                _nonce,
                firstname,
                lastname,
                handle,
                email,
                calendarName,
                phone,
            }; 

            $.post(

                megacal_admin_script_opts.ajax_url,
                registerData,
                function( response ) {
                    
                    if( false == response.success ) {
                        clearAlertNotification();
                        showAlertNotification( response.data.message, 'error' );
                        return;
                    }
                    
                    window.location = megacal_admin_script_opts.upgrade_url;

                }

            )
            .fail( function() {

                clearAlertNotification();
                showAlertNotification( GENERIC_ERROR_MSG, 'error' );
            
            }); 

        });
        
        var $manageEvents = $( '#megacal-manage-events' );
        
        if( $manageEvents.length > 0 ) {

            var $saveEventWrap = $( '#save-event-wrap' );
            var $calendar = $( '#megacal-manage-calendar' );
            var currDate = new Date();
            var changeTypeSelected = false;
            var $approvalList = $( '#megacal-approval-list' );

            $( '.megacal-filter-cat-btn' ).on( 'change', function() {
                $calendar.eventCalendar( 'refresh' );
            } );

            $calendar.eventCalendar({

                showImage: false,
                showLegends: true,
                showOwners: true,
                timeFormat: megacal_admin_script_opts.time_fmt_setting,
                dateFormat: {
                    calendar: 'D',
                    calendarFirst: 'MMM D',
                },
                showSlider: false,
                loaderImageUrl: megacal_admin_script_opts.base_url + '/assets/img/loading.svg',
                defaultEventImageUrl: megacal_admin_script_opts.default_image_path,
                calendarCreate: (event, data) => {

                }

            }).on( 'eventcalendar.calendaraddevent', ( event, data ) => {
                
                var $eventManageMask = $manageEvents.find( '#eventManageMask' );
                var $eventForm = $saveEventWrap.find( '#megacal-event-form' );

                $calendar.eventCalendar( 'showLoader' );
                $eventManageMask.removeClass( 'hidden' );
                $eventForm.html( '' );

                loadEventForm( 
                    null, 
                    function( response ) {
                            
                        if( false == response.success ) {
                            clearAlertNotification();
                            showAlertNotification( response.data.message, 'error' );
                            return;
                        }
                            
                        $calendar.eventCalendar( 'hideLoader' );
                        $eventManageMask.addClass( 'hidden' );
                        $saveEventWrap.html( response.data.content );
                        
                        var $eventForm = $saveEventWrap.find( '#megacal-event-form' );
                        var $eventSubmitBtn = $saveEventWrap.find( '.megacal-button-save-event' );
                        
                        registerEventFormActions( data.date );
                        initWYSIWYGFields();
                        showAddEventForm();

                    }, 
                    function() {

                        clearAlertNotification();
                        showAlertNotification( GENERIC_ERROR_MSG, 'error' );

                    }
                );

            }).on('eventcalendar.calendarviewchange', ( event, data ) => {

                currDate = data.date;
                loadCalendarView( $calendar, data.date );

            }).on('eventcalendar.eventclick', ( event, data ) => {
                
                if( !data.createdByMe ) {
                    return;
                }

                var eventId = data.eventId;
                var $eventManageMask = $manageEvents.find( '#eventManageMask' );
                var $eventForm = $saveEventWrap.find( '#megacal-event-form' );

                $calendar.eventCalendar( 'showLoader' );
                $eventManageMask.removeClass( 'hidden' );
                $eventForm.html( '' );

                loadEventForm( 
                    eventId, 
                    function( response ) {
                        
                        var $eventManageMask = $manageEvents.find( '#eventManageMask' );

                        if( false == response.success ) {
                            clearAlertNotification();
                            showAlertNotification( response.data.message, 'error' );
                            return;
                        }
                        
                        $calendar.eventCalendar( 'hideLoader' );
                        $eventManageMask.addClass( 'hidden' );
                        $saveEventWrap.html( response.data.content );
                        
                        var $eventForm = $saveEventWrap.find( '#megacal-event-form' );
                        var $eventSubmitBtn = $saveEventWrap.find( '.megacal-button-save-event' );
                        
                        registerEventFormActions();
                        initWYSIWYGFields();
                        showAddEventForm();

                    }, 
                    function() {

                        clearAlertNotification();
                        showAlertNotification( GENERIC_ERROR_MSG, 'error' );

                    }
                );

            });

            loadCalendarView( $calendar, currDate );
            loadApprovalList();

            function setEventApproval( approvalAction, btn ) {

                var approvalNotice = btn.closest( '.approval-notice' );
                var eventId = approvalNotice.data( 'event-id' );
                var userId = approvalNotice.data( 'user-id' );
                var _nonce = $( '#_megacal_set_event_approval_nonce' ).val();

                var putApprovalData = {
                    action: 'megacal_set_event_approval',
                    _nonce,
                    approvalAction,
                };

                switch( approvalAction ) {
                    case 'approve':
                    case 'deny':
                        putApprovalData.userId = userId;
                        putApprovalData.eventId = eventId;
                        break;

                    case 'always':
                    case 'approve_pending':
                    case 'deny_pending': 
                        putApprovalData.userId = userId;
                        break;
                }

                $.post(

                    megacal_admin_script_opts.ajax_url,
                    putApprovalData,
                    function( response ) {
                        
                        if( false == response.success ) {
                            clearAlertNotification();
                            showAlertNotification( response.data.message, 'error' )
                            return;
                        }

                        approvalNotice.fadeOut( 200, function() {
                            $( this ).remove();
                            loadApprovalList();
                        });

                        $calendar.eventCalendar( 'refresh' );

                    }
    
                )
                .fail( function() {
    
                    clearAlertNotification();
                    showAlertNotification( GENERIC_ERROR_MSG, 'error' )
                    
                });

            }
            
            /**
             * Reload the event form via AJAX
             * 
             * @param {int|null} eventId The event Id to prepopulate the fields - null value will generate an empty form
             * @param {function} successCallback The callback to run on success
             * @param {function} failureCallback The callback to run on failure
             */
            function loadEventForm( eventId, successCallback, failureCallback ) {

                var _nonce = $( '#_megacal_get_event_upsert_nonce' ).val();
                var eventId = eventId || null;

                var eventUpsertData = {
                    action: 'megacal_get_event_upsert',
                    _nonce,
                };

                if( eventId !== null ) {
                    eventUpsertData.eventId = eventId;
                }

                $.post(

                    megacal_admin_script_opts.ajax_url,
                    eventUpsertData,
                    successCallback
    
                )
                .fail( failureCallback ); 

            }

            function registerEventFormActions( date ) {

                var $eventForm = $( '#megacal-event-form' );
                var $eventSubmitBtn = $( '.megacal-button-save-event' );
                var $eventDeleteBtn = $( '.megacal-button-delete-event' );
                var $allDayCheckbox = $( '#megacal-all-day' );
                var $startTimeField = $( '#megacal-event-start-time' );
                var $endTimeField = $( '#megacal-event-end-time' );
                var $dateField = $( '#megacal-event-date' );
                var $eventImgBtn = $( '#megacal-upload-event-img' );
                var $eventRemoveBtn = $( '#megacal-remove-event-img' );
                var $eventImgField = $( '#megacal-event-img' );
                var $imgPreview = $( '#megacal-img-preview' );
                var $venueField = $( '#megacal-event-venue-name' );
                var $venueIdField = $( '#megacal-event-venue-id' );
                var $categoryField = $( '#megacal-event-category-name' );
                var $categoryIdField = $( '#megacal-event-category-id' );
                var $venueLocationField = $( '#megacal-event-venue-location' ); 
                var $cancelBtn = $( '.megacal-button-cancel-edit-event' );
                var $modalCancelBtn = $( '.megacal-button-cancel-save-delete');
                var startDate = date ? new Date( date ) : false;
                var $timepicker = $( '.timepicker' );
                var recurrence = $( '#megacal-event-recurrence-details' ).val();
                var recurrenceDetails = null;

                if( '' !== recurrence.trim() ) {
                    recurrenceDetails = JSON.parse( recurrence );
                }

                if( startDate ) {
                    
                    fmtDate = new Intl.DateTimeFormat( 'en-US', { 
                        month: '2-digit', 
                        day: '2-digit', 
                        year: 'numeric' 
                    } ).format( startDate );

                    $dateField.val( fmtDate );

                }

                $cancelBtn.on( 'click', function( e ) {
                    $saveEventWrap.fadeOut( 500 );
                });

                $modalCancelBtn.on( 'click', function( e ) {
                    hideChangeTypeModal();
                });

                $eventDeleteBtn.on( 'click', function( e ) {

                    if( !changeTypeSelected ) {
                        var confirm = window.confirm( 'Are you sure you want to permanently delete this event?' );
                        if( !confirm ) {
                            return;
                        }
                    }

                    if( recurrenceDetails && !changeTypeSelected ) {
                        showChangeTypeModal( 'delete' );
                        return;
                    }

                    var publishOptions = $( '#submitdiv' );
                    var _nonce = publishOptions.find( '#_megacal_delete_event_nonce' ).val();
                    var eventId = $eventForm.find( '#megacal-event-id' ).val();
                    var formData = new FormData( $eventForm[0] );
                    var eventChangeType = formData.get( 'eventChangeType' );

                    var deleteEventData = {
                        action: 'megacal_delete_event',
                        _nonce,
                        eventId,
                        eventChangeType,
                    };

                    $.post(

                        megacal_admin_script_opts.ajax_url,
                        deleteEventData,
                        function( response ) {
                            
                            if( false == response.success ) {
                                clearAlertNotification();
                                showAlertNotification( response.data.message, 'error' );
                                return;
                            }

                            if( response.data.message ) {
                                clearAlertNotification();
                                showAlertNotification( response.data.message, 'success' );
                            }

                            $saveEventWrap.fadeOut( 500, function() {
                                $calendar.eventCalendar( 'refresh' );
                            } );

                        }
        
                    )
                    .fail( function() {
        
                        clearAlertNotification();
                        showAlertNotification( GENERIC_ERROR_MSG, 'error' );
                        
                    })
                    .done( function() {
                        hideChangeTypeModal();
                    } );

                } );

                $dateField.megacalDatepicker({
                    format: 'mm/dd/yyyy',
                    todayHighlight: true,
                    autoclose: true,
                }).megacalDatepicker( 'update' );

                $dateField.on( 'change', function() {
                    
                    checkRequiredFields( $eventForm, $eventSubmitBtn );
                    fetchEventRecurrenceDetails( recurrenceDetails );

                });

                $timepicker.each( function() {
                
                    var val = $( this ).val();

                    $( this ).timepicker({
                        defaultTime: val || '',
                        startTime: '6:00am',
                        timeFormat: 'h:mm a',
                        interval: 15,
                        dropdown: true,
                        dynamic: false,
                        scrollbar: true,
                        zindex: 9999,
                    });

                    if( !val ) {
                        $( this ).val( '' ); // Default state - no value
                    }

                });

                $venueField.select2({
                    placeholder: 'Tag or Add a Venue',
                    tags: true,
                    allowClear: true,
                    createTag: function( tag ) {

                        // Case-insensitive tagging
                        var found = false;

                        $venueField.find( 'option' ).each( function() {
                            
                            if( $.trim( tag.term ).toUpperCase() === $.trim( $( this ).text() ).toUpperCase() ) {
                                found = true;
                            }

                        });
                
                        if( !found ) {
                            
                            // Also don't allow purely numeric venue names
                            if( $.isNumeric( tag.term ) ) {
                                return {};
                            }

                            return {
                                id: tag.term,
                                text: tag.term + " (new)",
                                isNew: true
                            };

                        }

                    },
                    language: {
                        noResults: function( params ){
                            return "Type to add a venue.";
                        }
                    },
                });

                $venueField.on( 'change', function() {

                    var val = $( this ).val();
                    var location = $( this ).find( 'option[value="' + val + '"]' ).data( 'location' );

                    if( $.isNumeric( val ) ) {
                        
                        $venueIdField.val( val );
                        $venueLocationField.val( location ).prop( 'disabled', true );

                    } else {

                        $venueIdField.val( '' );
                        $venueLocationField.val( '' ).prop( 'disabled', false );

                    }

                    checkRequiredFields( $eventForm, $eventSubmitBtn );

                });

                $categoryField.select2({
                    placeholder: 'Tag or Add an Event Category',
                    tags: true,
                    createTag: function( tag ) {

                        // Case-insensitive tagging
                        var found = false;

                        $categoryField.find( 'option' ).each( function() {
                            
                            if( $.trim( tag.term ).toUpperCase() === $.trim( $( this ).text() ).toUpperCase() ) {
                                found = true;
                            }

                        });
                
                        if( !found ) {
                            
                            // Also don't allow purely numeric venue names
                            if( $.isNumeric( tag.term ) ) {
                                return {};
                            }

                            return {
                                id: tag.term,
                                text: tag.term + " (new)",
                                isNew: true
                            };

                        }

                    },
                    language: {
                        noResults: function( params ){
                            return "No Existing Categories Found";
                        }
                    },
                });

                $categoryField.on( 'change', function() {

                    var val = $( this ).val();

                    if( $.isNumeric( val ) ) {
                        $categoryIdField.val( val );
                    } else {
                        $categoryIdField.val( '' );
                    }

                    checkRequiredFields( $eventForm, $eventSubmitBtn );

                });
    
                $( '#megacal-event-form input' ).on( 'keyup', function() {
                    checkRequiredFields( $eventForm, $eventSubmitBtn );
                });

                if( $allDayCheckbox.prop( 'checked' ) ) {
                    
                    $startTimeField.hide().removeClass( 'required' );
                    $endTimeField.hide().removeClass( 'required' );

                }

                $allDayCheckbox.on( 'change', function() {
    
                    var checked = $( this ).prop( 'checked' );
    
                    if( checked ) {
    
                        $startTimeField.hide().removeClass( 'required' );
                        $endTimeField.hide().removeClass( 'required' );
                        
                    } else {
    
                        $startTimeField.show().addClass( 'required' );
                        $endTimeField.show().addClass( 'required' );
    
                    }
    
                    checkRequiredFields( $eventForm, $eventSubmitBtn );
    
                });

                $eventForm.find( 'input' ).on( 'blur, focus', function() { checkRequiredFields( $eventForm, $eventSubmitBtn ); } );
    
                // Form Submission
                $eventForm.on( 'submit', function( e ) {
    
                    e.preventDefault();

                    if( tinyMCE ) {
                        tinyMCE.triggerSave();
                    }
                    
                    var form = $( this )[0];
                    var formData = new FormData( form );

                    if( recurrenceDetails && !changeTypeSelected ) {
                        showChangeTypeModal( 'update' );
                    } else {
                        saveEvent( formData );
                    }
    
                });
    
                // Image Uploads
                $eventImgBtn.on( 'click', function( e ) {
    
                    e.preventDefault();
    
                    checkRequiredFields( $eventForm, $eventSubmitBtn );

                    customUploader = wp.media({
    
                        title: 'Upload Event Image',
                        library : {
                            type : 'image'
                        },
                        button: {
                            text: 'Use this image' // button label text
                        },
                        multiple: false
    
                    }).on('select', function() { // it also has "open" and "close" events
    
                        var attachment = customUploader.state().get( 'selection' ).first().toJSON();
                        $eventImgBtn.hide();
                        $imgPreview.attr( 'src', attachment.url ).show();
                        $eventRemoveBtn.show();
                        $eventImgField.val( attachment.url );
    
                    }).open();
    
                });
    
                $eventRemoveBtn.on( 'click', function( e ) {
    
                    e.preventDefault();

                    checkRequiredFields( $eventForm, $eventSubmitBtn );
    
                    $imgPreview.hide();
                    $eventRemoveBtn.hide();
                    $eventImgBtn.show();
                    $eventImgField.val( '' );
    
                });

                fetchEventRecurrenceDetails( recurrenceDetails );

            }

            function showChangeTypeModal( action ) {
                var $modal = $( '#megacal-change-type-modal' );

                $modal.show();
                $( '#megacal-admin-mask' ).show();

                if( action === 'update' ) {
                    $( '#megacal-change-type-this' ).prop( 'checked', true );
                    $( '#megacal-change-type-options' ).show();
                    $modal.find( '.megacal-button-delete-event' ).hide();
                    $modal.find( '.megacal-button-save-event' ).show();
                    $modal.find( '#megacal-change-type-this' ).focus();
                } else if( action === 'delete' ) {
                    $( '#megacal-delete-type-this' ).prop( 'checked', true );
                    $( '#megacal-delete-type-options' ).show();
                    $modal.find( '.megacal-button-delete-event' ).show();
                    $modal.find( '.megacal-button-save-event' ).hide();
                    $modal.find( '#megacal-delete-type-this' ).focus();
                }

                changeTypeSelected = true;
            }

            function hideChangeTypeModal() {
                $( '#megacal-change-type-modal' ).hide();
                $( '#megacal-admin-mask' ).hide();
                $( '#megacal-change-type-options' ).hide();
                $( '#megacal-delete-type-options' ).hide();
                $( '.megacal-button-save-event' ).focus();
                
                changeTypeSelected = false;
            }

            function saveEvent( formData ) {

                var _nonce = formData.get( '_megacal_event_upsert_nonce' );
                var eventId = formData.get( 'eventId' );
                var eventTitle = formData.get( 'eventTitle' );
                var eventDate = formData.get( 'eventDate' );
                var eventAllDay = formData.get( 'eventAllDay' );
                var eventStartTime = formData.get( 'eventStartTime' );
                var eventEndTime = formData.get( 'eventEndTime' );
                var eventImg = formData.get( 'eventImg' );
                var eventVenueId = formData.get( 'eventVenueId' );
                var eventVenueName = formData.get( 'eventVenueName' );
                var eventVenueLocation = formData.get( 'eventVenueLocation' );
                var eventCatId = formData.get( 'eventCatId' );
                var eventCatName = formData.get( 'eventCatName' );
                var eventOrganizer = formData.get( 'megacal-event-organizer' );
                var eventFacebookUrl = formData.get( 'eventFacebookUrl' );
                var eventTicketUrl = formData.get( 'eventTicketUrl' );
                var eventPrice = formData.get( 'eventPrice' );
                var eventTaggedUsers = formData.getAll( 'eventTaggedUsers' );
                var eventTaggedUsersExtra = formData.get( 'eventTaggedUsersExtra' );
                var megacalEventDescription = formData.get( 'megacal-event-description' );
                var megacalEventPrivateNotes = formData.get( 'megacal-event-private-notes' );
                var published = formData.get( 'publishEvent' );
                var eventRecurrence = formData.get( 'eventRecurrence' );
                var eventRecurrenceRepetition = formData.get( 'eventRecurrenceRepetition' );
                var eventRecurrenceCustomType = formData.get( 'eventRecurrenceCustomType' );
                var eventRecurrenceCustomMonthlyFreq = formData.get( 'eventRecurrenceCustomMonthlyFreq' );
                var eventRecurrenceWeeklyDays = formData.getAll( 'eventRecurrenceWeeklyDays' );
                var eventRecurrenceEnd = formData.get( 'eventRecurrenceEnd' );
                var eventRecurrenceEndDate = formData.get( 'eventRecurrenceEndDate' );
                var eventRecurrenceEndOccurrence = formData.get( 'eventRecurrenceEndOccurrence' );
                var eventRecurrenceDayOfWeek = formData.get( 'eventRecurrenceDayOfWeek' );
                var eventRecurrenceWeekOfMonth = formData.get( 'eventRecurrenceWeekOfMonth' );
                var eventRecurrenceLastDayOfWeek = formData.get( 'eventRecurrenceLastDayOfWeek' );
                var eventRecurrenceDayOfMonth = formData.get( 'eventRecurrenceDayOfMonth' );
                var eventRecurrenceMonth = formData.get( 'eventRecurrenceMonth' );
                var eventChangeType = formData.get( 'eventChangeType' );

                var saveEventData = {
                    action: 'megacal_save_event',
                    _nonce,
                    eventId,
                    eventTitle,
                    eventDate,
                    eventAllDay,
                    eventStartTime,
                    eventEndTime,
                    eventImg,
                    eventVenueId,
                    eventVenueName,
                    eventVenueLocation,
                    eventCatId,
                    eventCatName,
                    eventOrganizer,
                    eventFacebookUrl,
                    eventTicketUrl,
                    eventPrice,
                    eventTaggedUsers,
                    eventTaggedUsersExtra,
                    megacalEventDescription,
                    megacalEventPrivateNotes,
                    published,
                    eventRecurrence,
                    eventRecurrenceRepetition,
                    eventRecurrenceCustomType,
                    eventRecurrenceCustomMonthlyFreq,
                    eventRecurrenceWeeklyDays,
                    eventRecurrenceEnd,
                    eventRecurrenceEndDate,
                    eventRecurrenceEndOccurrence,
                    eventRecurrenceDayOfWeek,
                    eventRecurrenceWeekOfMonth,
                    eventRecurrenceLastDayOfWeek,
                    eventRecurrenceDayOfMonth,
                    eventRecurrenceMonth,
                    eventChangeType,
                };
                
                $.post(

                    megacal_admin_script_opts.ajax_url,
                    saveEventData,
                    function( response ) {

                        if( false == response.success ) {
                            clearAlertNotification();
                            showAlertNotification( response.data.message, 'error' );

                            return;
                        }
                        
                        $saveEventWrap.fadeOut( 500 );
                        $calendar.eventCalendar( 'refresh' );

                        if( response.data.message ) {
                            clearAlertNotification();
                            showAlertNotification( response.data.message, 'success' );
                        }

                        // Refresh cached venues if a new one was added 
                        if( '' == eventVenueId ) {

                            var _nonce = $( '#_megacal_get_event_upsert_nonce' ).val();
                            var eventId = response.data.eventId;

                            var eventUpsertData = {
                                action: 'megacal_get_event_upsert',
                                _nonce,
                                eventId: eventId,
                            };
            
                            $.post(
            
                                megacal_admin_script_opts.ajax_url,
                                eventUpsertData,
                                function( response ) {
                                    
                                    if( false == response.success ) {
                                        clearAlertNotification();
                                        showAlertNotification( response.data.message, 'error' );

                                        return;
                                    }

                                }
                                
                            );

                        }

                    }
    
                )
                .fail( function() {
    
                    clearAlertNotification();
                    showAlertNotification( GENERIC_ERROR_MSG, 'error' );
                    changeTypeSelected = false;

                })
                .done( function() {
                    hideChangeTypeModal(); 
                } );

            }

            function fetchEventRecurrenceDetails( recurrence ) {

                var $eventRecurrenceContainer = $( '.megacal-event-recurrence-container' );
                
                var $select = $eventRecurrenceContainer.find( '#eventRecurrenceSelect' );
                var selectVal = $select ? $select.val() : false;

                var $radio = $eventRecurrenceContainer.find( '.eventRecurrenceEnd:checked' );
                var radioVal = $radio ? $radio.val() : false;

                var $customRecurrenceTypeSelectOr = $( '#eventRecurrenceCustomType' );
                var customRecurrenceTypeVal = $customRecurrenceTypeSelectOr ? $customRecurrenceTypeSelectOr.val() : false;

                var $dateField = $( '#megacal-event-date' );
                var date = $dateField.val();
                var eventId = $( '#megacal-event-id' ).val().trim() ? parseInt( $( '#megacal-event-id' ).val().trim() ) : 0;

                var $endsDetailsContainer = $( '.megacal-ends-details-container' );
                var endsExpanded = $endsDetailsContainer.length > 0 ? !$endsDetailsContainer.hasClass( 'collapsed' ) : false;
                var showRecurrence = true;

                if( !recurrence && eventId > 0 ) {
                    showRecurrence = false;
                }

                if( recurrence ) {
                    selectVal = recurrence.type;

                    if( 'CUSTOM' === recurrence.type ) {
                        customRecurrenceTypeVal = recurrence.custom.type||customRecurrenceTypeVal;
                        radioVal = recurrence.custom.end_condition||radioVal;
                    }
                }

                // Remove content
                var _nonce = $( '#_megacal_event_recurrence_nonce' ).val();

                $.post(

                    megacal_admin_script_opts.ajax_url,
                    { 
                        action: 'megacal_get_event_recurrence',
                        _nonce,
                        date: date || null,
                        showRecurrence,
                    },
                    function( response ) {

                        if( false == response.success ) {
                            clearAlertNotification();
                            showAlertNotification( response.data.message, 'error' );
                            return;
                        }

                        $eventRecurrenceContainer.html( response.data.content );

                        var recurrence_details = response.data.recurrence_details;
                        if( recurrence_details ) {

                            var $eventRecurrenceRepetition = $( '#eventRecurrenceRepetition' );
                            var $eventRecurrenceEndDate = $( '#eventRecurrenceEndDate' );
                            var $eventRecurrenceEndOccurrence = $( '#eventRecurrenceEndOccurrence' );
                            var $customRecurrenceTypeSelect = $( '#eventRecurrenceCustomType' );
                            var $customRecurrenceMonthlyFreq = $( '#eventRecurrenceCustomMonthlyFreq' );
                            var $customRecurrenceWeeklyDays = $( '#eventRecurrenceWeeklyDays' );
                            var $eventRecurrenceSelect = $eventRecurrenceContainer.find( '#eventRecurrenceSelect' );
                            var $customRecurrenceDetailsSection = $eventRecurrenceContainer.find( '.megacal-custom-recurrence-details' );

                            // Reselect options after date change
                            if( selectVal ) {
                                
                                $eventRecurrenceSelect.val( selectVal );

                                if( 'CUSTOM' === selectVal ) {
                                    $customRecurrenceDetailsSection.show();
                                }

                            }

                            if( radioVal ) {
                                $eventRecurrenceContainer.find( '.eventRecurrenceEnd[value="' + radioVal + '"]' ).prop( 'checked', true );
                            }

                            if( customRecurrenceTypeVal ) {
                                $customRecurrenceTypeSelect.val( customRecurrenceTypeVal );
                            }

                            if( $eventRecurrenceSelect.val() === 'CUSTOM' ) {
                                $( '.megacal-custom-recurrence-details' ).removeClass( 'hidden' );
                            }

                            if( $customRecurrenceTypeSelect.length < 1 ) {
                                return;
                            }

                            var customRecurrenceType = $customRecurrenceTypeSelect.val().toLowerCase();
                            var customDetail = recurrence_details.custom;
                            var detailVals = customDetail[customRecurrenceType + '_custom'];
                            var fmtEndDate = moment( detailVals.end_condition.on, 'YYYY-MM-DD' ).format( 'MM/DD/YYYY' );
                            var afterOccurrence = detailVals.end_condition.after_occurrence;
                            var repetition = customDetail.repetition;
                            
                            if( recurrence ) {    
                                
                                if( recurrence.custom ) {
                                    var recurrenceDetails = recurrence.custom[customRecurrenceType + '_custom'] || recurrence.custom;
                                    repetition = recurrence.custom.repetition||repetition;

                                    if( recurrenceDetails.repeat_on ) {
                                        $( '.eventRecurrenceWeeklyDays' ).prop( 'checked', false );
                                        $( '.eventRecurrenceWeeklyDays' ).each( function() {
                                            var $this = $( this );

                                            if( recurrenceDetails.repeat_on.indexOf( $this.val() ) > -1 ) {
                                                $( this ).prop( 'checked', true );
                                            }
                                        });
                                    }

                                    if( recurrenceDetails.day_of_week ) {
                                        var weekOfMonth = recurrenceDetails.week_of_month;
                                        $( '#eventRecurrenceCustomMonthlyFreq' ).val( 'week_of_month-' + weekOfMonth );
                                    }

                                    if( recurrence.custom.end_condition ) {
                                        if( recurrence.custom.end_condition.on ) {
                                            fmtEndDate = moment( recurrence.custom.end_condition.on, 'YYYY-MM-DD' ).format( 'MM/DD/YYYY' );
                                            endsExpanded = true;
                                            $eventRecurrenceContainer.find( '#eventRecurrenceEndDateOp' ).prop( 'checked', true );
                                        } else if( recurrence.custom.end_condition.after_occurrence > 0 ) {
                                            afterOccurrence = recurrence.custom.end_condition.after_occurrence;
                                            endsExpanded = true;
                                            $eventRecurrenceContainer.find( '#eventRecurrenceEndOccurrenceOp' ).prop( 'checked', true );
                                        }
                                    }
                                }
                                
                            }

                            $eventRecurrenceRepetition.val( repetition );
                            $eventRecurrenceEndDate.val( fmtEndDate );
                            $eventRecurrenceEndOccurrence.val( afterOccurrence );

                            // expand/collapse ends details
                            if( endsExpanded ) {
                                var $newEndsDetailsContainer = $eventRecurrenceContainer.find( '.megacal-ends-details-container' );
                                var $toggle = $eventRecurrenceContainer.find( '.collapsable-toggle' );
                                $toggle.find( '.icon-chevron-right' ).removeClass( 'icon-chevron-right' ).addClass( 'icon-chevron-down' );
                                $newEndsDetailsContainer.removeClass( 'collapsed' );
                            }

                            // re-register event listeners
                            $eventRecurrenceSelect.on( 'change', function() {

                                if( 'CUSTOM' === $( this ).val() ) {
                                    $customRecurrenceDetailsSection.slideDown();
                                } else {
                                    $customRecurrenceDetailsSection.slideUp();
                                }

                            } );

                            if( 'WEEKLY' === $customRecurrenceTypeSelect.val() ) {    
                                $customRecurrenceWeeklyDays.removeClass( 'hidden' );
                            } else if( 'MONTHLY' === $customRecurrenceTypeSelect.val() ) {
                                $customRecurrenceMonthlyFreq.removeClass( 'hidden' );
                            }

                            $customRecurrenceTypeSelect.on( 'change', function() {
                                
                                recurrence.custom.type = $( this ).val();
                                fetchEventRecurrenceDetails( recurrence );

                            } );

                            // Register datepicker
                            $eventRecurrenceContainer.find( '#eventRecurrenceEndDate' ).megacalDatepicker({
                                format: 'mm/dd/yyyy',
                                todayHighlight: true,
                                autoclose: true,
                            }).megacalDatepicker( 'update' );

                            $( '#eventRecurrenceEndOccurrence' ).on( 'click', function() {
                                $('#eventRecurrenceEndOccurrenceOp' ).prop( 'checked', true );
                            } );
                            
                            $( '#eventRecurrenceEndDate' ).on( 'click', function() {
                                $('#eventRecurrenceEndDateOp' ).prop( 'checked', true );
                            } );

                            $( '.eventRecurrenceWeeklyDays' ).on( 'click', function() {
                                
                                var $weeklyDaysCBs = $( '.eventRecurrenceWeeklyDays' );
                                var $selectedDayCB;
                                var defaultDay = customDetail.weekly_custom.selected_day_of_week;
                                var allEmpty = true;

                                $weeklyDaysCBs.each( function() {

                                    if( $( this ).prop( 'checked' ) === true ) {
                                        allEmpty = false;
                                    }

                                    if( $( this ).val() !== defaultDay )
                                        return;

                                    $selectedDayCB = $( this );

                                } );

                                if( allEmpty ) {
                                    $selectedDayCB.prop( 'checked', true );
                                }

                            } );

                        }

                    }
    
                )
                .fail( function() {
                    clearAlertNotification();
                    showAlertNotification( GENERIC_ERROR_MSG, 'error' );
                    return;
                } )
                .done( function() {

                    var $eventForm = $( '#megacal-event-form' );
                    var $eventSubmitBtn = $( '.megacal-button-save-event' );

                    checkRequiredFields( $eventForm, $eventSubmitBtn );

                } );
                
            }

            function initWYSIWYGFields() {

                if( !tinyMCE )
                    return; // Safeguard, should never happen
                    
                var $eventForm = $( '#megacal-event-form' );
                var $eventSubmitBtn = $( '.megacal-button-save-event' );

                $saveEventWrap.find( '.wp-editor-area' ).each( function() {
                    
                    var id = $( this ).attr( 'id' );

                    // xxx: Need to jump through some hoops to properly render WYSIWYG editors after AJAX
                    
                    tinyMCEPreInit.mceInit[id].setup = function( ed ) {

                        ed.on( 'keyup', function() {
                            checkRequiredFields( $eventForm, $eventSubmitBtn );
                        });

                    };

                    tinyMCE.init( tinyMCEPreInit.mceInit[id] ); // don't change the settings
                    
                    // Render the editor
                    tinyMCE.execCommand( 'mceRemoveEditor', false, id ); 
                    tinyMCE.execCommand( 'mceAddEditor', false, id ); 

                    quicktags( { id } ); // Text view quicktag buttons

                });

            }

            function showAddEventForm() {
            
                $saveEventWrap.fadeIn( 200, function() {
                    $( '#megacal-event-title' ).focus();
                } );

            }

            function loadCalendarView( $eventCalendar, date ) {

                const format = 'YYYY-MM-DD';
                const aMoment = moment( date ).hours(0)
                    .minutes(0)
                    .seconds(0)
                    .milliseconds(0);

                const startDate = aMoment.clone().startOf( 'month' ).startOf( 'week' ).format( format );
                const endDate = aMoment.clone().endOf( 'month' ).endOf( 'week' ).format( format );
    
                var _nonce = $( '#_megacal_fetch_events_nonce' ).val();
                var $filterForm = $( '#megacal-manage-filter-form' );
                var formData = new FormData( $filterForm[0] );

                var eventCategories = formData.getAll( 'megacalFilterCategories' );

                var fetchEventsData = {
                    action: 'megacal_fetch_calendar_events',
                    _nonce,
                    startDate,
                    endDate,
                    eventCategories,
                };

                $eventCalendar.eventCalendar( 'showLoader' );

                $.post(

                    megacal_admin_script_opts.ajax_url,
                    fetchEventsData,
                    function( response ) {
                        
                        if( false == response.success ) {
                            clearAlertNotification();
                            showAlertNotification( response.data.message, 'error' );
                            return;
                        }

                        $eventCalendar.eventCalendar( 
                            'option', 
                            'events', 
                            { 
                                'events': response.data.events 
                            } 
                        );

                    }

                )
                .fail( function() {
                })
                .done( function() {
                    $eventCalendar.eventCalendar( 'hideLoader' );
                });

            };

            function loadApprovalList() {

                var _nonce = $( '#megacal_get_approval_list_nonce' ).val();
                var getApprovalListData = {
                    action: 'megacal_get_approval_list',
                    _nonce
                };

                $.post(
                    megacal_admin_script_opts.ajax_url,
                    getApprovalListData,
                    function( response ) {
                        
                        if( false == response.success ) {
                            clearAlertNotification();
                            showAlertNotification( response.data.message, 'error' );
                            return;
                        }

                        $approvalList.html( response.data.content );

                        var $approvalActionBtn = $( '.button-approval-action' );
                        $approvalActionBtn.on( 'click', function( e ) {
            
                            e.preventDefault();
                            setEventApproval( $( this ).data( 'action' ), $( this ) );
            
                        });

                    }
                ).fail( function() {
                    clearAlertNotification();
                    showAlertNotification( GENERIC_ERROR_MSG, 'error' );
                });

            }
            
        }

        var $manageRelationships = $( '.megacal-manage-relationships-page' );

        if( $manageRelationships.length > 0 ) {

            var isDirty = false;

            $( window ).on( 'load', function() {
                window.addEventListener("beforeunload", function (e) {

                    if( !isDirty ) {
                        return undefined;
                    }
                    
                    var confirmationMessage = 'Changes you made on this page may not be saved';
            
                    (e || window.event).returnValue = confirmationMessage; //Gecko + IE
                    return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.

                });
            } );

            // Edit button functionality
            $( '.megacal-relationship-edit-btn' ).on( 'click', function( e ) {

                e.preventDefault();
                isDirty = true;

                var $this = $( this );
                var $form = $this.closest( '.megacal-manage-relationship-form' );

                var $inputs = $form.find( 'input, textarea' );
                var $nameInput;
                $inputs.each( function() {
                    $( this ).prop( 'readonly', false );
                    $( this ).prop( 'disabled', false );

                    if( $( this ).attr( 'name' ) == 'name' ) {
                        $nameInput = $( this );
                    }
                });

                if( $nameInput ) {
                    $nameInput.focus();
                }

                $form.find( '.megacal-relationship-save-btn' ).prop( 'disabled', false );
                $this.prop( 'disabled', true );

            } );

            $( '.megacal-manage-relationship-form' ).on( 'submit', function( e ) {

                e.preventDefault();

                var $form = $( this );
                var _nonce = $( '#megacal_update_relationships_nonce' ).val();
                var form = $form[0];
                var formData = new FormData( form );
                var type = formData.get( 'type' );
                var $inputs = $form.find( 'input, textarea' );

                $form.find( '.megacal-relationship-save-btn' ).prop( 'disabled', true );
                
                var putRelationshipData = {
                    name: formData.get( 'name' ),
                    published: formData.get( 'published' ),
                    _nonce,
                    action: 'megacal_update_' + type + '_details',
                };

                putRelationshipData[type + '_id'] = formData.get( 'id' );

                if( 'venue' === type ) {
                    putRelationshipData.location = formData.get( 'location' );
                }

                $.post(

                    megacal_admin_script_opts.ajax_url,
                    putRelationshipData,
                    function( response ) {
                        
                        clearAlertNotification();
                        $form.find( '.megacal-relationship-save-btn' ).prop( 'disabled', true );
                        $form.find( '.megacal-relationship-edit-btn' ).prop( 'disabled', false );

                        if( false == response.success ) {
                            showAlertNotification( response.data.message, 'error' );
                            return;
                        }

                        isDirty = false;

                        $inputs.each( function() {
                            var $this = $( this );

                            if( $this.attr( 'type' ) === 'checkbox' ) {
                                $( this ).prop( 'disabled', true );
                            } else {
                                $( this ).prop( 'readonly', true );
                            }
                        });

                    }
    
                )
                .fail( function() {
    
                    clearAlertNotification();
                    showAlertNotification( GENERIC_ERROR_MSG, 'error' );
                    $form.find( '.megacal-relationship-save-btn' ).prop( 'disabled', false );
                    
                });

            } );
        }

        var $alertNotice = $( '#alert-notice' );
        var alertState = '';
        var clearNotificationTimeout;

        $alertNotice.find( '.alert-notice-close' ).on( 'click', function( e ) {
            e.preventDefault();
            clearAlertNotification();
        } );

        /**
         * Displays an alert notice
         * 
         * @param string msg The message to add to the notice 
         * @param string type The type of notice to show - One of 'success', 'error', 'info'. Custom strings can be used and will result in a 'mystring-notice' class. 
         */
        function showAlertNotification( msg, type ) {

            alertState = type + '-notice';

            $alertNotice.addClass( alertState );
            $alertNotice.find( '.alert-notice-inner' ).html( '<p>' + msg + '</p>' );
            $alertNotice.removeClass( 'hidden' );
            $alertNotice.show();

            $( 'html, body' ).animate({ scrollTop: 0 });

            if( clearNotificationTimeout ) {
                clearTimeout( clearNotificationTimeout );
            }

            clearNotificationTimeout = setTimeout( clearAlertNotification, 5000 );

        }

        function clearAlertNotification() {

            $alertNotice.fadeOut( 2000, function() {
                $alertNotice.removeClass( alertState );
            } );

            if( clearNotificationTimeout ) {
                clearTimeout( clearNotificationTimeout );
            }

        }

        // Shortcode Fields
        megacalShortcodeFieldUpdate({ 
            event_type: 'change', 
            field_selector: '#megacal-events-settings-sc #themeSelect', 
            shortcode_att: 'theme', 
            output_selector: '#megacal-events-settings-sc .shortcode',
            handler: 'val'
        });

        megacalShortcodeFieldUpdate({
            event_type: 'change', 
            field_selector: '#megacal-events-settings-sc #buttonPositions', 
            shortcode_att: 'buttons', 
            output_selector: '#megacal-events-settings-sc .shortcode',
            handler: 'val'
        });

        megacalShortcodeFieldUpdate({ 
            event_type: 'change', 
            field_selector: '#megacal-events-settings-sc #showDesc', 
            shortcode_att: 'descrip', 
            output_selector: '#megacal-events-settings-sc .shortcode',
            handler: 'checked'
        });

        megacalShortcodeFieldUpdate({ 
            event_type: 'change', 
            field_selector: '#megacal-events-settings-sc #displyImgs', 
            shortcode_att: 'display', 
            output_selector: '#megacal-events-settings-sc .shortcode',
            handler: function( att, shortcode, $element ) {

                var display = ($element.prop('checked')) ? 'img' : 'text';
                return megacalReplaceShortcodeAtt( att, display, shortcode );
                
            }
        });

        megacalShortcodeFieldUpdate({ 
            event_type: 'change', 
            field_selector: '#megacal-events-settings-sc #defaultView', 
            shortcode_att: 'view', 
            output_selector: '#megacal-events-settings-sc .shortcode',
            handler: 'val'
        });

        megacalShortcodeFieldUpdate({ 
            event_type: 'change', 
            field_selector: '#megacal-events-settings-sc #hideView', 
            shortcode_att: 'hideview', 
            output_selector: '#megacal-events-settings-sc .shortcode',
            handler: 'checked'
        });

        megacalShortcodeFieldUpdate({  
            event_type: 'change', 
            field_selector: '#megacal-events-settings-sc #listStyleSelect', 
            shortcode_att: 'style', 
            output_selector: '#megacal-events-settings-sc .shortcode',
            handler: 'val',
        });

        megacalShortcodeFieldUpdate({ 
            event_type: 'change', 
            field_selector: '#megacal-events-settings-sc #filterCal', 
            shortcode_att: 'eventOwner', 
            output_selector: '#megacal-events-settings-sc .shortcode',
            handler: function( att, shortcode, $element ) {

                var id = '';
                var ownerId = 0;

                ownerId = $element.val();
                id = ( 0 == ownerId ) ? '' : ownerId;

                return megacalReplaceShortcodeAtt( att, id, shortcode );

            }
        });

        megacalShortcodeFieldUpdate({ 
            event_type: 'change', 
            field_selector: '#megacal-events-settings-sc #filterCat', 
            shortcode_att: 'category', 
            output_selector: '#megacal-events-settings-sc .shortcode',
            handler: function( att, shortcode, $element ) {

                var id = '';
                var catId = 0;

                catId = $element.val();
                id = ( 0 == catId ) ? '' : catId;

                return megacalReplaceShortcodeAtt( att, id, shortcode );

            }
        });

        megacalShortcodeFieldUpdate({  
            event_type: 'change', 
            field_selector: '#megacal-events-settings-sc #imgHeight', 
            shortcode_att: 'imgHeight', 
            output_selector: '#megacal-events-settings-sc .shortcode',
            handler: 'val',
        });

        megacalShortcodeFieldUpdate({ 
            event_type: 'change', 
            field_selector: '#megacal-events-settings-sc #showFilters', 
            shortcode_att: 'showfilters', 
            output_selector: '#megacal-events-settings-sc .shortcode',
            handler: 'checked'
        });

        var $shortcode_btn = $( '#megacal-insert-shortcode' );
        if( $shortcode_btn.length > 0 ) {

            $shortcode_btn.on( 'click', function( e ) {

                e.preventDefault();

                tb_show( 
                    'MegaCal Shortcode Options', 
                    ajax_shortcode_options.url
                );

            });

            $document.on('click', '#megacal-events-settings-sc .insertShortcode', function(e) {
            
                e.preventDefault();

                var target = $(this).data('target-class');

                if( 'undefined' == typeof target ) {
                    console.error( 'no target shortcode field supplied' );
                    return;
                }

                if( '' == target ) {
                    console.error( 'target cannot be empty' );
                    return;
                }

                target = '.' + target;
                var copyTextarea = $(target);

                if( copyTextarea.length > 0 ) {
                 
                    var val = copyTextarea.val();

                    wp.media.editor.insert( val );
                    tb_remove();
                
                }

            });

            // Ehhhhh.....
            // Depending on a mutation observer
            // is undesirable and expensive, but
            // there is no callback after ajax 
            // loads in thickbox
            var in_dom = $( '#megacal-events-settings' ).length > 0;
            var observer = new MutationObserver(function( mutations ) {

                var $loaded_content = $( '#megacal-events-settings' );

                // Make sure tabs get set up
                // after ajax content loads
                if( $loaded_content.length <= 0 && in_dom ) {
                    
                    in_dom = false;
                    return;

                } else if( $loaded_content.length > 0 ) {
                
                    if(!in_dom) {

                        setupAdminTabs( '#megacal-events-settings' );
                        
                        // override thickbox styles...
                        // thickbox doesn't let us dynamically
                        // size content, so this is as good as
                        // this is going to get
                        $('#TB_ajaxContent').css({ 
                            width: '100%',
                            height: '100%',
                            padding: 0
                        });

                        $('#TB_window').css({
                            overflow: 'auto'
                        });

                    }

                    in_dom = true;

                } 
             
            });

            observer.observe( document.body, { childList: true } );

        }

        // collapsable sections
        $( document ).on( 'click', '.mega-collapsable-toggle', function() {

            var $toggle = $( this );
            var $collapsable = $toggle.next( '.mega-collapsable' );
            var slideSpeed = 300;

            if( $collapsable.hasClass( 'collapsed' ) ) {
                
                $toggle.find( '.icon-chevron-right' ).removeClass( 'icon-chevron-right' ).addClass( 'icon-chevron-down' );
                $toggle.attr( 'aria-pressed', true );

                $collapsable.slideDown( slideSpeed, function() { 
                    $collapsable.removeClass( 'collapsed' );
                } );

            } else {

                $toggle.find( '.icon-chevron-down' ).removeClass( 'icon-chevron-down' ).addClass( 'icon-chevron-right' );
                $toggle.attr( 'aria-pressed', false );

                $collapsable.slideUp( slideSpeed, function() { 
                    $collapsable.addClass( 'collapsed' );
                } );
                
            }

        } );

    });

    $( document ).on( 'keyup', '.mega-collapsable-toggle', function( e ) {

        if( e.key === 'Enter' ) {
            $( this ).trigger( 'click' );
        }

    } );

    function setupAdminTabs( selector ) {

        var tabs = $(selector).find('ul.tabs');

        if( tabs.length <= 0 || tabs.hasClass('tabs-init') )
            return;

        tabs.addClass('tabs-init');
        
        tabs.each(function() {
            // For each set of tabs, we want to keep track of
            // which tab is active and its associated content
            var $active, $content, $links = $(this).find('a');

            // If the location.hash matches one of the links, use that as the active tab.
            // If no match is found, use the first link as the initial active tab.
            $active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
            $active.addClass('current');

            $content = $($active[0].hash);
            // Hide the remaining content
            $links.not($active).each(function () {
                $(this.hash).hide();
            });

            // Bind the click event handler
            $(this).on('click', 'a', function(e){
                // Make the old tab inactive.
                $active.removeClass('current');
                $content.hide();

                // Update the variables with the new link and content
                $active = $(this);
                $content = $(this.hash);
                // Make the tab active.
                $active.addClass('current');
                $content.show();

                // Prevent the anchor's default click action
                e.preventDefault();
            });
        });

    }

    // Delegate shortcode options event handlers
    function megacalShortcodeFieldUpdate( opts ) {
        
        if( 'object' != typeof opts )
            return false;

        if( 'undefined' == typeof opts.event_type ) {
            console.error( 'event_type is required by megacalShortcodeFieldUpdate' );
            return false;
        }

        if( 'undefined' == typeof opts.field_selector ) {
            console.error( 'field_selector is required by megacalShortcodeFieldUpdate' );
            return false;
        }

        if( 'undefined' == typeof opts.shortcode_att ) {
            console.error( 'shortcode_att is required by megacalShortcodeFieldUpdate');
            return false;
        }

        if( 'undefined' == typeof opts.output_selector ) {
            console.error( 'output_selector is required by megacalShortcodeFieldUpdate' );
            return false;
        }

        var opts = {
            event_type: opts.event_type, 
            field_selector: opts.field_selector,
            shortcode_att: opts.shortcode_att,
            output_selector: opts.output_selector,
            handler: ( 'undefined' == typeof opts.handler) ? 'val' : opts.handler,
            callback: ( 'undefined' == typeof opts.callback) ? null : opts.callback
        };

        $document.on( opts.event_type, opts.field_selector, function(e) {

            var $shortcode_field = $(opts.output_selector)
            var shortcode = $shortcode_field.val();
            var out = shortcode;

            var default_handler = function( type, att, shortcode, $element ) {

                if( 'val' != type && 'checked' != type )
                    return shortcode;

                var val;

                if( 'val' == type ) {
                    val = $element.val();
                } else if( 'checked' == type ) {
                    val = $element.prop('checked');
                }
    
                return megacalReplaceShortcodeAtt( att, val, shortcode );

            };

            if( 'function' == typeof opts.handler )
                out = opts.handler( opts.shortcode_att, shortcode, $(this) );
            else if( 'string' == typeof opts.handler )
                out = default_handler( opts.handler, opts.shortcode_att, shortcode, $(this) );

            if( 'function' == typeof opts.callback )
                opts.callback( out );

            $shortcode_field.val( out );
        });

    }

    function megacalReplaceShortcodeAtt( att, val, shortcode ) {

        var shortcode_len = shortcode.length;
        var insert_index = shortcode_len - 1;
        var regex = new RegExp( "\\s" + att + '="[^"]*"', 'g' );

        if( shortcode.indexOf( ' ' + att ) > 0 && '' != val )
            return shortcode.replace( regex, ' ' + att + '="' + val + '"' );
        else if( '' != val )
            return shortcode.substring( 0, insert_index ) + ' ' + att + '="' + val + '"' + shortcode.substring( shortcode_len - 1 );
        else
            return shortcode.replace( regex, '' );

    }

    function checkRequiredFields( $form, $submitBtn ) {
      
        var required = $form.find('.required');
        var allValid = true;
    
        required.each(function () {
    
            var $this = $( this );

            if( !$this.val() ) {

                if( $this.hasClass( 'select2-hidden-accessible' ) ) {
                    
                    $this.next( '.select2-container' ).removeClass('valid'); 
                    $this.next( '.select2-container' ).addClass('invalid');

                } else {

                    $this.removeClass('valid'); 
                    $this.addClass('invalid');
                
                }

                allValid = false;

            } else {
                
                if( $this.hasClass( 'select2-hidden-accessible' ) ) {
                    $this.next( '.select2-container' ).removeClass('invalid');
                } else {
                    $this.removeClass('invalid');
                }
            
            }
    
        });
    
        if (allValid) {
            $submitBtn.prop('disabled', false);
        } else {
            $submitBtn.prop('disabled', true);
        }

    }

    function isValidHexCode( hexStr ) {
        
        const hexRegex = /^#[0-9A-F]{6}$/i;
        return hexRegex.test( hexStr );

    }

})(jQuery);

