<?php
/**
 * Generated automatically through the api client generator
 * @created    Tue, 28 Jan 2014 01:37:08 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_activity_preference_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_activity_preference']);
    }
    
	/**
	 * @method get
	 * @param int activityPreferenceID	// id of activity preferences 
	 * @param int referenceID  // reference id
	 * @param int referenceType // reference type
	 * @param int eventID  // event id  
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
    public function activity_preference_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_activity_preference/activity_preference', $params, false, $format);
    }
	/**
	 * @method post
	 * @param int activityPreferenceID	// id parameter optional of type integer
	 * @param int referenceID  // reference id
	 * @param string referenceType // reference type ('agenda','activity')
	 * @param int eventID  // event id
	 * @param string title      // title of activity preference
	 * @param string description // description of activity preference
	 * @param string optionDisplayType // display type (selectbox, radio, checkbox, textbox, textarea)
	 * @param int isRequired	 // activity preference is required 
	 * @param date dateCreated   // created date
	 * @param date dateUpdated	 // updated date 
	 * @return json/xml data
	 */
    public function activity_preference_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_activity_preference/activity_preference', $params, true, $format);
    }
	/**
	 * @method get
	 * @param int activityPreferenceID	// activity preference id
	 * @param int referenceID  // reference id
	 * @param string referenceType // reference type ('agenda','activity')
	 * @param int eventID  // event id
	 * @return json/xml data
	 */
    public function activity_preference_remove_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_activity_preference/activity_preference_remove', $params, false, $format);
    }
}
