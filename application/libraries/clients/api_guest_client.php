<?php
/**
 * Generated automatically through the api client generator
 * @created    Wed, 22 Jan 2014 03:37:10 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_guest_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_guest']);
    }
    
	/**
	 * @method get
	 * @param string eventAttendeeID // pk id
	 * @param int user_id // guest userid
	 * @param int event_id // event id
	 * @param string reference_id	// reference_id
	 * @param string role_id	// role
	 * @param string reference_type // enum ('event', 'itinerary','activity')
	 * @param string team // guest team
	 * @param string status // enum( 'approved', 'pending', 'rejected')
	 * @param string sort_order // ASC|DESC sort order
	 * @param string sort_by
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
    public function guests_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_guest/guests', $params, false, $format);
    }
	/**
	 * @method post
	 * @param int eventAttendeeID // optional pk
	 * @param int event_id // event id fk
	 * @param int user_id // guest userid
	 * @param string reference_type // enum ('itinerary', 'breakout', 'activity') 
	 * @param int reference_id // remote id of which guest will be attending
	 * @param int role_id // guest role
	 * @param string team // guest team
	 * @param string status // enum( 'approved', 'pending', 'rejected')
	 * @return json/xml data
	 */
    public function guest_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_guest/guest', $params, true, $format);
    }
	/**
	 * @method get
	 * @param int eventAttendeeID // gid 
	 * @param int event_id // event id	 	  
	 * @param int reference_id // reference id optional
	 * @param int user_id // event id optional
	 * @param int role_id // role id optional
	 * @return json/xml data
	 */
    public function remove_guest_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_guest/remove_guest', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int user_id // user_id
	 * @param int event_id // event_id
	 * @return json/xml data
	 */
    public function remove_event_guest_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_guest/remove_event_guest', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int reference_id // reference_id
	 * @return json/xml data
	 */
    public function remove_guest_by_referenceid_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_guest/remove_guest_by_referenceid', $params, false, $format);
    }
	/**
	 * @method get
	 * @param string name //filter of search
	 * @param int event_id //event id
	 * @return json/xml data
	 */
    public function search_guest_by_name_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_guest/search_guest_by_name', $params, false, $format);
    }
	/**
	 * @method get
	 * @return json/xml data
	 */
    public function user_concurrent_activities_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_guest/user_concurrent_activities', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int user_id // user_id
	 * @param string reference_type // reference_type
	 * @param int reference_id // reference_id
	 * @return json/xml data
	 */
    public function remove_guest_by_reference_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_guest/remove_guest_by_reference', $params, false, $format);
    }
	/**
	 * @method post
	 * @param int eventAttendeeIDs // event attendee ids comma separated
	 * @param int status // status ('approved','pending', 'rejected')
	 * @return json/xml data
	 */
    public function multi_update_status_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_guest/multi_update_status', $params, true, $format);
    }
}
