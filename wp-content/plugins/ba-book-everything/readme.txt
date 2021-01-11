=== BA Book Everything ===
Contributors: bookingalgorithms
Tags: booking, hotels, tours, cars, calendar, apartments, hostels, availability calendar, book everything, booking calendar, events, event schedule, flexible scheduling, fast booking, hotel, accommodation
Requires at least: 4.6.1
Requires PHP: 5.6
Tested up to: 5.6
Stable tag: 1.3.29
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

The really fast and powerful Booking engine with management system for theme/site developers to create any booking or rental sites (tours, hotels, hostels, apartments, cars, events etc., or all together).

== Description ==

BA Book Everything plugin - the really fast and powerful Booking engine with management system for theme/site developers to create any booking or rental sites (tours, hotels, hostels, apartments, cars, events etc., or all together). **Magic one-click "Demo Setup" feature helps you get started with the plugin in minutes!**
Rates and prices system is easy to use and incredibly flexible in adjusting any price variations based on seasons (dates), week days (weekend rates, etc.), number of the guests or/and number of the days/nights.
Thanks to **integration with Elementor plugin**, you’ll be able to see BA Book Everything shortcodes and widgets (e.g. search availability form, booking form, booking item calendar, slideshow and other post elements) in the list of the content modules in the Elementor builder.
It’s highly customizable with hooks, so you need to have some programming skills to drive it on the top gear in your project. But even "out of the box" the plugin is ready for use and could be sufficient in many cases – **[Try Demo](https://ba-booking.com/ba-book-everything/search-result/?request_search_results=1)** and **[Read details](https://ba-booking.com/ba-book-everything/)**.

= Docs & Support =

You can find [Docs](https://ba-booking.com/ba-book-everything/documentation/installation/) and more detailed information about BA Book Everything on [ba-booking.com](https://ba-booking.com/ba-book-everything/). If you were unable to find the answer to your question in any of the documentation, you should check the [support forum](https://wordpress.org/support/plugin/ba-book-everything/) on WordPress.org. If you can't locate any topics that pertain to your particular issue, post a new topic for it.

= Features =
*   One-click Demo content setup
*   Booking rules for nights, days or event booking
*   Custom categories (tours, hotels, apartments, cars, events etc.) with own booking rules
*   Easy to create custom taxonomies from the administrator screen to use them when editing booking objects
*   Easy to create schedule and prices
*   Flexible rate rules: minimum/maximum booking period, days of the week to which the rate applies, days of the week in which the reservation can be started
*   Variable prices based on number of the guests or/and number of the days/nights
*   Cyclic availability: schedule items availability every N days for M days. Useful for cruises and other types of rentals with cycles other than a week.
*   Exclude certain dates from availability calendar 
*   Setup prices for any age categories (customizable)
*   Search form builder: allows to use custom taxonomies as filters, price range picker, guests selection, keyword search, search tabs (different search field set per booking category)
*   Promotional: discount Coupons, discounted prices with time constraints
*   Full control on the Booking process – e-mail confirmations and notifications, customizable booking form, checkout form, option for manually availability confirmation (both email and admin dashboard)
*   Availability calendar with prices, synchronized with booking form widget
*   Widgets: booking form, search form, taxonomy terms filter, prices filter
*   Shortcode [all-items]
*   Elementor support
*   5 star rating integrated with WP comments
*   Product schema markup
*   Service post type - sell services with booking!
*   FAQ post type
*   Google Maps API intergrated to show address map or find nearest meeting points (for tours etc.)
*   Internationalized and Translation ready
*   Multilanguage support for qTranslate-x plugin
*   Hooks for customization (developers)
*   Integrated with WP xml export/import
*   and more...

= Available in Addons =
*   PayPal payments
*   Credit Cards payments with Stripe, including 3D Secure, Apple Pay, Google Pay, Microsoft Pay and the Payment Request API
*   Backend bookings from dashboard: creating, editing, cancelation, manual refund (full or partial)
*   Editing/cancelation orders for both customers and administrators, extra charge, full or partial refund
*   Custom refund rules
*   iCal synchronization
*   anything else on request

You can find [Addons, Themes](https://ba-booking.com/) and more detailed information about BA Book Everything on [ba-booking.com](https://ba-booking.com/).

== Installation ==

1. Upload the 'ba-book-everything' folder to the '/wp-content/plugins/' directory
1. Activate the "BA Book Everything" plugin through the 'Plugins' menu in WordPress
1. Go to "BA Settings" menu to make main settings
1. Go to "BA Settings" > "Demo content" menu to setup demo content in one click
1. Go to "Appearance" > "Widgets" menu to add booking form, search form and search filters to front-end pages

= Customization =
1. Start learning hooks and functions from BABE_html class.
1. [Send us a request](https://ba-booking.com/)

== Changelog ==

= 1.3.29 =
* Fixed issue with selecting "date to" in search form without tabs

= 1.3.28 =
* Fixed search form term selection issue, booking form available time select issue (daily bookings)
* Added new hooks

= 1.3.27 =
* Added extra guests fields to checkout form

= 1.3.26 =
* Fixed issue "CMB2_Hookup not found"

= 1.3.25 =
* Fixed XSS vulnerability in search request params
* Fixed issues based on security review

= 1.3.24 =
* Extended data set for WP export/import

= 1.3.23 =
* Fixed the issue of selecting a category when editing "booking object" post

= 1.3.22 =
* Fixed bug "incorrect datetime value" when using MySQL 8

= 1.3.21 =
* Fixed bug with "price from" calculation and sorting by price

= 1.3.20 =
* Improved performance

= 1.3.19 =
* Extended search form with keyword field, price range picker, advanced field (allows select multiple taxonomy terms via checkboxes)
* Improved performance

= 1.3.18 =
* Fixed booking form bugs: guest selection doesn't work properly with age categories, date fields aren't prefilled with dates after search request

= 1.3.17 =
* Plugin data can be exported into xml and imported to new site via standard WP export/import

= 1.3.16 =
* Added sort option "post_title" to "all-items" shortcode

= 1.3.15 =
* Updated "related items" styles and script on booking object editing page
* Removed source map links from js files

= 1.3.14 =
* Discount Coupon can be set as a percentage of the order amount
* Added category filter for selecting related items on booking object editing page

= 1.3.13 =
* Added integration with Elementor plugin

= 1.3.12 =
* Added tabindex attribute to search form fields for better keyboard navigation
* Added Product schema markup

= 1.3.11 =
* Added setting to define maximum number of months in availability calendar

= 1.3.10 =
* Fixed bug "not sending booking confirmation email"

= 1.3.9 =
* Fixed price calculation error with two or more rates applied to date range 

= 1.3.8 =
* Improved tax display in order details at checkout and in emails
* html tags are supported in email "Body message" field at "Emails" settings tab
* Added "Request Payment" button to order list on Orders admin page. It sends an email "Your order is waiting for payment" to customer
* Updated Search form styles and scripts

= 1.3.7 =
* Updated Search form styles and scripts
* Added Fontawesome class option to field settings in the Search form builder

= 1.3.6 =
* [**New**] Added Search form builder
* [**New**] Added fixed deposit amount option into the booking object post

= 1.3.5 =
* Fixed bug with "not found rates" for availability calendar when number of rates is more than 100

= 1.3.4 =
* Fixed bug "guest selection field lost in booking form"

= 1.3.3 =
* Fixed error with "Undefined offset: 0" in class-babe-html.php, class-babe-prices.php

= 1.3.2 =
* Fixed age terms sorting bug
* Fixed prices format in Demo content
* Fixed database upgrade rates issue

= 1.3.1 =
* Fixed Error: Call to a member function get_var()

= 1.3.0 =
* [**New**] Significant changes in rates and availability calendar database
* [**New**] Added to rates: minimum/maximum booking period, days of the week to which the rate applies, days of the week in which the reservation can be started
* [**New**] Added to rates: flexible prices using the rule constructor based on number of the guests or/and number of the days/nights
* [**New**] Cyclic availability: schedule items availability every N days for M days. Useful for cruises and other types of rentals with cycles other than a week.

= 1.2.9 =
* Changed default search date range to "+1 year"
* Added "date_from" and "date_to" args to [all-items] shortcode

= 1.2.8 =
* Fixed js bug with adding a schedule
* Updated styles

= 1.2.7 =
* [**New**] Added one-click Demo content setup
* Various bugs fixed

= 1.2.6 =
* [**New**] Added user registration form
* Fixed bug: the map section is displayed on the item page when it is turned off in the category
* Various bugs fixed

= 1.2.5 =
* Updated modal window styles

= 1.2.4 =
* Speed optimization
* Fixed js bug with undefined variable

= 1.2.3 =
* Fixed email styles 

= 1.2.2 =
* Added related booking objects option on booking object edit page
* Added email message settings to plugin's settings page
* Added new hooks
* Added option "Use Gutenberg for booking object posts"

= 1.2.1 =
* Fixed js bug with applying coupon on checkout

= 1.2.0 =
* [**New**] Added order statuses "canceled" and "completed"
* [**New**] Added setting to booking object to exclude certain dates from availability calendar
* [**New**] Added shortcode [all-items]
* [**New**] Ready for BABE Backoffice addon
* Added support WP local timezone for current datetime calculation
* Added some hooks
* Improved payments class with refund support
* Fixed bug with PHP 7.2 compatibility of CMB2 plugin

= 1.1.5 =
* Fixed bug with assigning taxonomies terms when updating the booking object post  

= 1.1.4 =
* [**New**] Added setting "Add services to booking form"
* [**New**] Added setting "Remove unitegallery from booking object pages"
* [**New**] Added setting "Remove google map from booking object pages"
* [**New**] Added setting "Remove availability calendar from booking object pages"
* [**New**] Added setting "Waiting before delete orders with "payment processing" status"
* Added some hooks
* Improved booking form elements
* Improved styles of checkout form elements
* Updated price calculation for 'day' basic booking period
* Fixed bug with updating the availability calendar on saving a booking object post

= 1.1.3 =
* Improved and added some hooks
* Improved booking form elements
* Added time select to booking form elements for 'day' basic booking period (useful for car booking, etc.)

= 1.1.2 =
* Ready to integrate payment gateways
* Added some hooks

= 1.1.1 =
* [**New**] Added discount Coupons.
* Fixed bug with reset password on My Account page
* Added some hooks

= 1.1.0 =
* [**New**] Added My account front end page to manage bookings for customer and manager roles.
* Meeting points addresses moved to 'place' post type
* Improved and added some filters
* Fixed bug with price calculation

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.3.0 =
1.3.0 is a major update. It is important that you make backups and ensure themes and extensions are 1.3.0 compatible before upgrading.
