<?php
/**
 * Generated automatically through the api client generator
 * @created    Wed, 22 Jan 2014 03:37:10 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_activity_preference_option_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_activity_preference_option']);
    }
    
	/**
	 * @method get
	 * @param int activityPreferenceOptionID	// id optional  
	 * @param int activityPreferenceID  // activity preference id
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
    public function activity_preference_option_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_activity_preference_option/activity_preference_option', $params, false, $format);
    }
	/**
	 * @method post
	 * @param int activityPreferenceOptionID	// id parameter optional of type integer
	 * @param int activityPreferenceID  // activity preference id	 
	 * @param string title      // title of activity preference
	 * @param string description // description of activity preference
	 * @param date dateCreated   // created date
	 * @param date dateUpdated	 // updated date 
	 * @return json/xml data
	 */
    public function activity_preference_option_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_activity_preference_option/activity_preference_option', $params, true, $format);
    }
	/**
	 * @method get
	 * @param int activityPreferenceOptionID	// activity preference options - option id
	 * @param int activityPreferenceID  // activity preference id	 
	 * @return json/xml data
	 */
    public function activity_preference_option_remove_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_activity_preference_option/activity_preference_option_remove', $params, false, $format);
    }
}
