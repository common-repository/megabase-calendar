//Front end JS for MegaCal Integration Plugin 
(function( $ ) {

	var RESULTS_PER_PAGE;
	const GENERIC_ERROR_MSG = '<p class="megacal-err-msg">Please <a href="#" class="megacal-err-reload">click to refresh</a> the calendar.</p>';

	$(document).ready(function() {

		/** Only run on pages where the plugin exists **/
		if( $( ".megacal-events-integration" ).length > 0 ) {
			
			var upcomingEvents = $( '.megacalUpcomingEvents' );
			var pastEvents = $( '.megacalPastEvents' );
			var $calendar = $( '.megacal-public-calendar' );
			var date = new Date();
			var calendarChangeDebounce = null;

			$( document ).on( 'click', 'a.megacal-err-reload', function( e ) {
				e.preventDefault();
				window.location.reload();
			});
			
			/** loadEvents function definition **/
			const loadEvents = function( container, listType, opts ) {

				var opts = opts||{};
				var pluginWrap = container.closest( '.megacal-events-integration' );
				var listWrap = container.closest( '.megacal-list-view' );
				var eventList = container.find('.eventsList');
				//var preLoader = container.find('.preLoader');
				var preLoader = container.find('.preLoader').first();
				
				var descrip = pluginWrap.find( '.descripParam' ).val();
				var buttons = pluginWrap.find( '.buttonsParam' ).val();
				var list_style = pluginWrap.find( '.listStyleParam' ).val();
				var nextDateField = ( 'past' === listType ) ? pluginWrap.find( '.megacalPastListDate' ) : pluginWrap.find( '.megacalUpcomingListDate' );
				var list_date = nextDateField.val();
				var eventOwner = pluginWrap.find( '.eventOwnerParam' ).val();
				var currentFilter;
				var eventCategories;

				if( !opts.currentPage ) {
					opts.currentPage = 0;
				}

				if( !opts.reset ) {
					opts.reset = false;
				}

				currentFilter = listWrap.data( 'category-filter' );
				eventCategories = ( currentFilter ) ? [parseInt( currentFilter )] : [];

				if( true === opts.reset ) {
					eventList.html( '' );
					container.find( '.pageNum' ).val( 1 );
				}

				preLoader.show();

				/** Validate POST params **/

					if( typeof listType !== 'string' ) {
						console.error("listType must be a string");
						return false;
					} else if(listType.trim() != 'upcoming' && listType.trim() != 'past') {
						console.error("listType must be 'upcoming' or 'past'");
						return false;
					}

					if( typeof descrip === 'undefined' ) {
						console.error("descrip must be 'true' or 'false'");
						return false;
					}

					if( typeof buttons !== 'string' ) {
						console.error("buttons must be a string");
						return false;
					} else if(buttons.trim() != 'left' && buttons.trim() != 'right' && buttons.trim() != 'center') {
						console.error("buttons must be 'left', 'right', or 'center'");
						return false;
					}

					if( typeof list_style !== 'string' ) {
						console.error( 'list_style must be a string' );
						return false;
					}

					if( typeof opts.currentPage !== 'number' ) {
						console.error( "currentPage must be a number" );
						return false;
					}

				/** End Validation **/

				var _nonce = pluginWrap.find( '#_megacal_fetch_public_events_nonce' ).val();

				var prevMonthLabel = container.find( '.megacal-month-label' ).last();
				var prevMonth = prevMonthLabel.length > 0 ? prevMonthLabel.text() : '';
				var lastEvent = container.find( '.listItem' ).last();

				var event_list_data = {
					'action' : 'megacal_load_events_list',
					_nonce,
					listType,
					descrip,
					buttons,
					list_style,
					list_date,
					eventOwner,
					eventCategories,
					currentPage: opts.currentPage,
					prevMonth,
				};

				$.post(
					megacal_script_opts.ajax_url,
					event_list_data,
					function( response ) {

						if( false === response.success ) {
							
							console.error( 'error loading events' );
							container.find(".loadMoreBtn").hide();
							return;

						}

						eventList.append( response.data.content );

						var $totalPages = container.find( '.megacal-list-total-pages' );
						var total = parseInt( $totalPages.val() ) - 1;

						if( total > opts.currentPage )
							container.find( '.loadMoreBtn' ).show();
						else
							container.find( '.loadMoreBtn' ).hide();

						eventList.find('.summaryToggle').unbind('click').click( function(e) {
							e.preventDefault();

							var event = $(this).parents('.listEvent');

							$(this).toggleClass('expanded');
							$(this).toggleClass('collapsed');

							event.find('.fullInfo').stop().slideToggle(200);
						});

						if( 'past' === listType ) {
							nextDateField.val( response.data.next_date );
						}

						if( opts.currentPage > 0 ) {
							lastEvent.find( 'a' ).first().focus();
						}

				})
				.fail( function() {

					console.error( 'error loading events' );
					container.find(".loadMoreBtn").hide();
					showReloadBtn( container );

				})
				.complete( function() {

					preLoader.hide();

				});

			};

			const loadCalendarView = function( $eventCalendar, date ) {

				var pluginWrap = $eventCalendar.closest( '.megacal-events-integration' );
                
				const format = 'YYYY-MM-DD';
                const aMoment = moment( date ).hours(0)
                    .minutes(0)
                    .seconds(0)
                    .milliseconds(0);

                const startDate = aMoment.clone().startOf( 'month' ).startOf( 'week' ).format( format );
                const endDate = aMoment.clone().endOf( 'month' ).endOf( 'week' ).format( format );
    
				var _nonce = pluginWrap.find( '#_megacal_fetch_public_events_nonce' ).val();
				var eventOwner = pluginWrap.find( '.eventOwnerParam' ).val();
				var currentFilter;
				var eventCategories;

				currentFilter = $eventCalendar.data( 'category-filter' );
				eventCategories = ( currentFilter !== '' ) ? [parseInt( currentFilter )] : null;

                var fetchEventsData = {
                    action: 'megacal_fetch_public_calendar_events',
                    _nonce,
                    startDate,
                    endDate,
					eventOwner,
					eventCategories,
                };

                $.post(

                    megacal_script_opts.ajax_url,
                    fetchEventsData,
                    function( response ) {
                        
                        if( false == response.success ) {
                            console.error( response.data.message );
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
                    
					showReloadBtn( $eventCalendar.parent() );

                })
                .done( function() {
                });
            };

            var popupTimeout;
			const displayPopupContent = function( $eventCalendar, data ) {

				$eventCalendar.eventCalendar( 'showPopup', data.eventId );

				if( popupTimeout ) {
					clearTimeout( popupTimeout );
				}

				popupTimeout = setTimeout( function() {

					var $pluginWrap = $eventCalendar.closest( '.megacal-events-integration' );
					var eventId = data.eventId;
					var _nonce = $pluginWrap.find( '#_megacal_get_event_popup_nonce' ).val();

					var getPopupData = {
						action: 'megacal_load_event_popup',
						eventId,
						_nonce,
					};

					$.post(

	                    megacal_script_opts.ajax_url,
	                    getPopupData,
	                    function( response ) {
	                        
	                        if( false == response.success ) {
	                            console.error( response.data.message );
	                            return;
	                        }

							$eventCalendar.eventCalendar( 'setEvent', response.data.content );
							$eventCalendar.eventCalendar( 'refreshTooltip' );

	                    }

	                ).fail( function() {
						$eventCalendar.eventCalendar( 'setEvent', GENERIC_ERROR_MSG );
						$eventCalendar.eventCalendar( 'refreshTooltip' );
					});

				}, 350 );

			};

			/** LOAD EVENTS ON PAGE LOAD **/
			upcomingEvents.each(function() {
				loadEvents( $( this ), "upcoming" );
			});

			pastEvents.each(function() {
				loadEvents( $( this ), "past" );
			});

			//Click Load More 
			$(".loadMoreBtn").click(function(e) {

				e.preventDefault();

				var container = $( this ).closest( '.megacal-tab' );
				var preLoader = container.find( '.preLoader' );
				var currentPage = parseInt( container.find( '.pageNum' ).val() );
				var listType;

				if( container.hasClass( 'megacalUpcomingEvents' ) ) {
					listType = 'upcoming';
				} else if( container.hasClass( 'megacalPastEvents' ) ) {
					listType = 'past';
				}

				$( this ).hide();
				preLoader.show();

				container.find( '.pageNum' ).val( currentPage + 1 );
				container.find( '.megacal-list-total-pages' ).remove();

				loadEvents( container, listType, { currentPage: currentPage } );

			});

			//Tabs
			$( '.megacal-tabNav' ).each( function() {

				var $this = $( this );
				$this.attr( 'role', 'tablist' );

				$this.find( 'li > a' ).each( function() {
					
					var $tab = $( this );
					var id = $tab.attr( 'href' );

					$tab.attr( 'role', 'tab' );
					$tab.attr( 'aria-controls', id );
					$( id ).attr( 'role', 'tabpanel' );
					
				} );

			} );

			$('.megacal-tabNav a').click(function(e) {
				e.preventDefault();
				
				var id = $(this).attr('href');
				var navContainer = $(this).closest('.megacal-tabNav');
				var container = navContainer.closest('.megacal-tabs');
				var liElem = $(this).parent();

				navContainer.find('li').removeClass('current');
				liElem.addClass('current');

				navContainer.find( 'a' ).attr( 'aria-selected', false );
				$( this ).attr( 'aria-selected', true );

				container.children('.megacal-tab').removeClass('current');
				$(id).addClass('current');
			});

			
			$calendar.each( function() {
				
				$this = $( this );
				var $pluginWrap = $this.closest( '.megacal-events-integration' );
				var imgHeight = $pluginWrap.find( '.imgHeightParam' ).val();

				var sliderVal = ( $.isNumeric( imgHeight ) ) ? parseInt( imgHeight ) : 20;
				var showImage = ( 'img' == $pluginWrap.find( '.displayParam').val() );
				
				$this.eventCalendar({

					showAdd: false,
					showLegends: false,
					showImage: showImage,
					timeFormat: megacal_script_opts.time_fmt_setting,
					dateFormat: {
						calendar: 'D',
						calendarFirst: 'MMM D',
					},
					slider: {
						value: sliderVal, 
					},
					colorOverride: {
						eventBGColor: megacal_script_opts.calendar_color_overrides.eventBGColor,
						eventBGOpacity: megacal_script_opts.calendar_color_overrides.eventBGOpacity,
						eventBorderColor: megacal_script_opts.calendar_color_overrides.eventBorderColor,
						eventTextColor: megacal_script_opts.calendar_color_overrides.eventTextColor,
						navigationBtnColor: megacal_script_opts.calendar_color_overrides.navigationBtnColor,
						navigationBtnTextColor: megacal_script_opts.calendar_color_overrides.navigationBtnTextColor,
					},
					showSlider: false,
					loaderImageUrl: megacal_script_opts.base_url + '/assets/img/loading.svg',
					defaultEventImageUrl: megacal_script_opts.default_image_path

				}).on('eventcalendar.calendarviewchange', ( event, data ) => {
						
					date = data.date;
					loadCalendarView( $this, data.date );

				});

				loadCalendarView( $this, date );
			
			}).on('eventcalendar.eventhover', ( event, data ) => {
    
				displayPopupContent( $this, data );

            }).on( 'eventcalendar.eventclick', ( event, data ) => {

				if( megacal_script_opts.permalink_structure == '/' || megacal_script_opts.permalink_structure == '' ) {
					window.location.assign( megacal_script_opts.event_url + '&event_id=' + data.eventId );
				} else {
					window.location.assign( megacal_script_opts.event_url + data.eventId );
				}

			});

			$( '.megacal-subscribe-select' ).on( 'change', function() {

				var url = $( this ).val();
				if( typeof url == 'undefined' || url.trim() == '' ) {
					return;
				}

				window.open( url, '_blank' );

			});

			$( '.megacal-filter-cat-btn' ).on( 'click', function( e ) {

				e.preventDefault();
				var $this = $( this );
				var pluginWrap = $this.closest( '.megacal-events-integration' );
				var $categoryFilters = pluginWrap.find( '.megacal-filter-section' );
				var $closestCal = pluginWrap.find( '.megacal-public-calendar' );
				var $closestList = pluginWrap.find( '.megacal-list-view' );
				var $upcomingList = pluginWrap.find( '.megacalUpcomingEvents' );
				var $pastList = pluginWrap.find( '.megacalPastEvents' );

				$categoryFilters.find( '.megacal-filter-cat-btn' ).removeClass( 'current' );
				$categoryFilters.find( '.megacal-filter-cat-btn' ).attr( 'aria-pressed', false );
				$this.addClass( 'current' );
				$this.attr( 'aria-pressed', true );

				$closestCal.data( 'category-filter', $this.data( 'cat-id' ) );
				$closestCal.eventCalendar( 'refresh' );

				$closestList.data( 'category-filter', $this.data( 'cat-id' ) );
				loadEvents( $upcomingList, "upcoming", { reset: true } );
				loadEvents( $pastList, "past", { reset: true } );
			
			} );

		}

	});

	$(window).load(function() {
		if($(".megacal-events-integration").length > 0) {
			if($('#viewParam').length > 0) {
				var view = $('#viewParam').val();

				if(view !== undefined && view.trim() !== '') {
					if(view == 'list')
						$('#listViewToggle').click();
					else if(view == 'cal')
						$('#calViewToggle').click();
				}
			}
		}
	});

	//Function Definitions
	function showEventPopupDetails( eventId ) {
		var modalContainer = $('.eventDetailModal');
		var mask = $('.megacal-integration-mask');

		if(megacal_script_opts !== undefined) {		
			var preLoader = modalContainer.find('.preLoader').first();

			var list_style = $('#listStyleParam').val();
			var show_venue = $('#showVenueParam').val();
			
			if( list_style !== undefined && typeof list_style !== 'string' ) {
				console.error( 'list_style must be a string' );
				return false;
			}

			if( show_venue === undefined ) {
				console.error( 'show_venue is required' );
				return false;
			}

			mask.fadeIn(200);
			modalContainer.fadeIn(200);

			/** Validate POST params **/
				if(eventId === undefined || (eventId !== undefined && !$.isNumeric(eventId))) {
					console.log("eventId must be a number");
					return false;
				}
			/** End Validation **/

			var event_detail_data = {
				'action' : 'load_event_details',
				'eventId' : eventId,
				'security' : megacal_script_opts.ajax_nonce,
				'list_style': list_style,
				'show_venue': show_venue
			};

			$.post(
				megacal_script_opts.ajax_url,
				event_detail_data,
				function(html) {
					modalContainer.html(html);

					$('body').addClass('noScroll');
					$('html').css("overflow", "hidden");

					//Set up the click listener on the close button
					modalContainer.find('.modalClose').click(function(e) {
						e.preventDefault();
						
						modalContainer.fadeOut(200, function() {
							modalContainer.html(preLoader);
						});
						
						mask.fadeOut(200);
						$('body').removeClass('noScroll');
						$('html').css("overflow", "auto");
					});

					$(".megacal-integration-mask").click(function(e) {
						e.preventDefault();
						
						modalContainer.fadeOut(200, function() {
							modalContainer.html(preLoader);
						});
						
						mask.fadeOut(200);
						$('body').removeClass('noScroll');
						$('html').css("overflow", "auto");
					});

					loadMediaTabsMegaCal();

				}
			);
		}
	}

	function loadMediaTabsMegaCal() {
		$(".mediaTabNav a").click(function(e){
			e.preventDefault();

			var tabId = $(this).attr("href").substring(1);
			var navContainer = $(this).closest(".mediaTabNav");
			var container = navContainer.closest(".mediaHolder");
			var tabContainer = container.find(".artistMediaTabs");
			var tab = tabContainer.find("."+tabId);

			navContainer.find('.current').removeClass('current');
			$(this).parent().addClass('current');

			tabContainer.find('.current').removeClass('current');
			tab.addClass('current');
		});

		$(".artistMediaExpander").click(function(e){
			e.preventDefault();

			var artistMediaSection = $(this).next(".artistMediaSection");

			if(artistMediaSection.hasClass('expanded')) {
				artistMediaSection.removeClass('expanded').stop().slideUp();
			} else {
				artistMediaSection.addClass('expanded').stop().slideDown();
			}
		});
	}

	function showReloadBtn( $container ) {
		$container.html( GENERIC_ERROR_MSG );
	}

})( jQuery );