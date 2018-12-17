<?php
/**
 * Generated automatically through the api client generator
 * @created    Wed, 22 Jan 2014 03:37:10 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_event_owner_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_event_owner']);
    }
    
	/**
	 * @method get
	 * @param string eventOwnerID // pk id
	 * @param int user_id // guest userid
	 * @param int event_id // event id
	 * @param string sort_order // ASC|DESC sort order
	 * @param string sort_by
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
    public function event_owners_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_event_owner/event_owners', $params, false, $format);
    }
	/**
	 * @method post
	 * @param int eventOwnerID // optional pk
	 * @param int event_id // event id fk
	 * @param int user_id // guest userid
	 * @return json/xml data
	 */
    public function event_owner_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_event_owner/event_owner', $params, true, $format);
    }
	/**
	 * @method get
	 * @param int eventOwnerID // gid 
	 * @param int event_id // event id	 	  
	 * @param int user_id // event id optional
	 * @return json/xml data
	 */
    public function remove_event_owner_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_event_owner/remove_event_owner', $params, false, $format);
    }
	/**
	 * @method get
	 * @param string name //filter of search
	 * @param int event_id //event id
	 * @return json/xml data
	 */
    public function search_event_owner_by_name_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_event_owner/search_event_owner_by_name', $params, false, $format);
    }
}
