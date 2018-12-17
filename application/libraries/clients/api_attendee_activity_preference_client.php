<?php
/**
 * Generated automatically through the api client generator
 * @created    Wed, 22 Jan 2014 03:37:10 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_attendee_activity_preference_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_attendee_activity_preference']);
    }
    
	/**
	 * @method get
	 * @param int attendeeActivityPreferenceID	// id of attendee activity preferences 
	 * @param int activityPreferenceID  // preference id
	 * @param int activityPreferenceOptionID // Option id
	 * @param int userID  // user id  
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
    public function attendee_activity_preference_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_attendee_activity_preference/attendee_activity_preference', $params, false, $format);
    }
	/**
	 * @method post
	 * @param int attendeeActivityPreferenceID	// id of attendee activity preferences 
	 * @param int activityPreferenceID  // preference id
	 * @param int activityPreferenceOptionID // Option id
	 * @param int userID  // user id 
	 * @param string value     // Optional will be set if Option Display Type is textbox or textarea 
	 * @param date dateCreated   // created date
	 * @param date dateUpdated	 // updated date 
	 * @return json/xml data
	 */
    public function attendee_activity_preference_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_attendee_activity_preference/attendee_activity_preference', $params, true, $format);
    }
	/**
	 * @method get
	 * @param int attendeeActivityPreferenceID	// id of attendee activity preferences 
	 * @param int activityPreferenceID  // preference id
	 * @param int activityPreferenceOptionID // Option id
	 * @param int userID // user id
	 * @return json/xml data
	 */
    public function attendee_activity_preference_remove_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_attendee_activity_preference/attendee_activity_preference_remove', $params, false, $format);
    }
}
