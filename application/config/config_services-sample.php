<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Services Urls
 */
//-- Production
//$servicesBaseUrl = 'http://api.rcgevents.com/';
//-- Dev
//$servicesBaseUrl = 'http://api.rcgevents.info/';
//-- Local (Set $servicesBaseUrl value to your local uri )
$servicesBaseUrl = 'http://api.rcgevents.local/';  
$config['services'] = array(
    'api_event' => $servicesBaseUrl,
	'api_user' => $servicesBaseUrl,
	'api_record' => $servicesBaseUrl,
	'api_itinerary' => $servicesBaseUrl,
	'api_breakout' => $servicesBaseUrl, 
	'api_role' => $servicesBaseUrl , 
	'api_guest' => $servicesBaseUrl, 
	'api_user_photo' => $servicesBaseUrl, 
	'api_companion' => $servicesBaseUrl,
	'api_activation_key' => $servicesBaseUrl,
	'api_activity_preference' => $servicesBaseUrl,	
	'api_activity_preference_option' => $servicesBaseUrl, 
	'api_attendee_activity_preference' => $servicesBaseUrl,
	'api_admin' => $servicesBaseUrl,
	'api_map_photo' => $servicesBaseUrl,
	'api_map_reference' => $servicesBaseUrl
);