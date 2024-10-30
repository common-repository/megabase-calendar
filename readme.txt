=== MegaCalendar ===
Contributors: Megabase
Tags: community, event, events, calendar
Requires at least: 4.0
Tested up to: 6.6.1
Requires PHP: 7.4
Stable tag: 1.3.7
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl.html

A flexible calendar and event list for communities, businesses and organizations.

== Description ==

A simple and customizable calendar and events solution for WordPress websites. 

Specially designed for the needs of both the novice website administrator and web designers/developers, MegaCalendar enables you to control all aspects of your calendar, from custom design options to flexible, easily customizable views. Save the hassle and make your events stand out with MegaCalendar - the new standard for event listings.


**With MegaCalendar, you can**

* Create and manage your calendar events with ease from your wp-admin area
* Display your events in month (grid) view, list view, or posterboard layout
* Add notes and photos to events
* Users can sync your calendar with Google Calendar, Outlook, and iCalendar
* Share your events with additional websites (recipient calendar requires Pro API Key)
* Create categories and display separate events on separate pages based on their categories using the convenient shortcode generator.
* Create venues to quickly add a new event at a recurring location.
* Fully responsive for all devices

**With a MegaCalendar Pro API Key, you can**

* Create recurring weekly or monthly events with ease (Second Tuesday, Every Wednesday, Daily, etc)
* Receive events from other MegaCalendar users or websites you manage
* Edit/update/delete Category and Venue details
* [Request a migration](https://megabase.co/support/) of your existing calendar for any 3-month period
* Get [support](https://megabase.co/) from our team


**More information**

The core fucntionality of this plugin is powered by the MegaCalendar API. For more information about the MegaCalendar API you can view [the specification](https://app.swaggerhub.com/apis/Sheep42/mega-calendar/) and our [developer documentation](https://megabase.co/help_doc_type/megacal-docs/developers/). 

By using this plugin you are agreeing to our [Privacy Policy](https://megabase.co/privacy-policy/) and [Terms of Service](https://megabase.co/terms-of-service/).


== Installation ==

Up to date installation instructions can be found in our [help documentation on our website](https://megabase.co/help_doc_type/megacal-docs/). 


== Frequently Asked Questions ==

= How do I get an API Key? =

API Key creation is automatic during plugin activation and setup. See [our help documentation](https://megabase.co/help_docs/setup/) for an in-depth walk-through.

= Are there any limitations to the free version? = 
No limitations!  All the essential calendar features are available at no cost. No trials, no cedits, no limit on how many events you can create.  A MegaCalendar Pro API key is only needed for the additional pro features outlined above.

= Can I send and receive specific events with another website? =

Yes, you can send events from one calendar to another, and auto-approve, or approve one by one. In order to receive events from someone else's Calendar, you must have a MegaCalendar Pro API Key. See [help documentation on our website](https://megabase.co/help_doc_type/megacal-docs/)  

The setup is highly customizable so you can auto-send new events to a particular recipient (skipping any new event as needed), send events one by one, and even send recurring events if needed. 

= Can I have the same calendar on two websites? =

Yes, you can use the same API Key on multiple websites to have identical events display on more than one WordPress website. See [help documentation on our website](https://megabase.co/help_doc_type/megacal-docs/)

= Can I customize the calendar or event lists? =

MegaCalendar is designed to be easy to modify the look, feel and layout as needed.  See our [developer documentation](https://megabase.co/help_doc_type/megacal-docs/developers/) for specific details on theme overrides, hooks, and more. 

In addition you can use custom CSS, shortcode options, and multiple views and categories to present events however is best for your use-case and style needs. 

= Where are events saved? =

Your event data is saved in in the cloud (in our case a protected AWS database). Event listings on your website are powered by the MegaCalendar API. 

= Remind me, what's an API? =

An elegant solution to share data from the cloud to one or more destinations.  MegaCalendar was originally built for a school district that needed to share specific events between eight unique school websites and their main school district website. 

== Screenshots ==

1. Calendar view example
2. List view / Responsive examples
3. Classic calendar management experience from WordPress dashboard
4. Clean and simple add event form
5. Event category filtering tabs and multiple events per day view
6. Event detail view

== Changelog ==

= 1.3.7 =
* Tested up to WordPress 6.6.1
* Improved hover card experience
* Cleaned up admin styles
* Improved timepicker experience
* Added Documentation links & Images to admin screens
* Fixed CSS that was too generic
* Cleaned up PHP 8.2 Warnings

= 1.3.6 =
* Tested up to WordPress 6.5.3
* Implemented Event title background transparency
* Replaced infinite loading in page builder admin previews with layout preview and message
* Cleaned up responsive styles

= 1.3.5 =
* Added help/docs links to bottom of all pages 
* Added specific help links to admin screens
* Fixed render bug with settings tab on new Registration
* Improved Event Calendar loading experience

= 1.3.4 =
* Tested up to WordPress 6.4.3
* Fixed Bootstrap datepicker collision 
* Implemented Event Detail excerpt for Calendar hover cards
* Fixed Event custom color bug on Calendar
* Implemented Event caching for custom implementations of megacal_get_events
* Implemented Admin preview for unpublished Events
* Added a View Event button to the Manage Event modal
* Fixed PHP Warnings when activating plugin for the first time

= 1.3.3 = 
* Tested up to WordPress 6.4.2
* Fixed UI bug when changing recurrence date
* Replaced timepicker UI
* Implemented auto-clear on admin notifications
* Cleaned up loading spinner & mask styles

= 1.3.2 =
* Tested up to WordPress 6.4.1
* Added Category filtering to List views
* Repositioned default Event image

= 1.3.1 =
* Tested up to WordPress 6.3.2 & PHP 8.2
* Cleaned up calendar button styles & changed "Month" button to read "Jump to"
* Cleaned up styles & UX on Plugin Settings page
* Implemented calendar month change delay to allow for quickly changing months 
* Event Caching: Implemented wp_cache functions in front of transients
* Fixed PHP 8.2 deprecation warnings 

= 1.3.0 = 
* Fixed a bug when modifying custom recurrence type
* Implemented custom color overrides
* Implemented informational notices when saving/deleting recurring events
* Tested on WordPress 6.3.1

= 1.2.9 = 
* Fixed a bug with custom daily recurrence

= 1.2.8 =
* Fixed a rogue sourcemap 404 

= 1.2.7 =
* Separate shortcode generator from settings
* Implemented account reset functionality 
* Updated Ping call to happen more frequently - Reducing chance of expired tokens

= 1.2.6 =
* Resized images in organizers section
* Fixed bug with event width introduced by accessibility updates

= 1.2.5 =
* Improved accessibility on frontend and backend

= 1.2.4 =
* Added link to Calendar from Manage Events screen
* Added Back To Calendar link to Event Detail page
* Removed 'All Day' language from frontend & backend

= 1.2.3 =
* Added admin bar and admin menu notice when shared Events are awaiting approval
* Fixed bug that allowed saving an end time that was before start time
* Fixed bug with ics export when end time is before start time 
* Fixed bug on admin calendar - Unable to trigger Add Event modal from a full day
* Added new Event Listing page setting to show "View Calendar" link from the Admin bar
* Removed unused assets
* Removed leading zeroes from calendar day labels

= 1.2.2 =
* Fixed bug with daily/yearly custom recurrence
* Fixed bug with Event Detail URL when using Plain permalink structure

= 1.2.1 =
* Fixed bug with Event Detail page rewrite on subdirectory installs
* Fixed conflict with Yoast - force the_content hook to exit outside of the main loop
* Fixed meta description escaping bug

= 1.2.0 =
* Redesigned and added single event page template which creates a new page called Event - Event Detail Page
* Updated event details to include Schema for proper SEO indexing with search engines
* New filter & action hooks added - see [developer documentation](https://megabase.co/help_doc_type/megacal-docs/developers/)
* Update to API & API wrapper to enable multi-category filtering  

= 1.1.2 =
* Fixed an issue with character escaping
* Cleaned up compact list view

= 1.1 =
* Added ability to edit venues and event categories

= 1.05 =
* Added image sizes

= 1.0 =
* Prepared for public release

== Upgrade Notice ==
