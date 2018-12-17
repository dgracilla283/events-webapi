<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Services Urls
 */
$servicesBaseUrl = 'http://api.rcgevents.com/'; 
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
	'api_map_reference' => $servicesBaseUrl,
	'api_speaker_comment' => $servicesBaseUrl,
	'api_presentation_category' => $servicesBaseUrl,
	'api_presentation' => $servicesBaseUrl
);