<?php
/**
 * Generated automatically through the api client generator
 * @created    Wed, 22 Jan 2014 03:37:10 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_role_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_role']);
    }
    
	/**
	 * @method get
	 * @param string category	// id parameter of type integer
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
    public function roles_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_role/roles', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int id // the id of the Role to fetch
	 * @return json/xml data
	 */
    public function role_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_role/role', $params, false, $format);
    }
	/**
	 * @method post
	 * @param int eid // optional id of Role
	 * @param string title // Role title
	 * @param string description // Role description
	 * @param string date_start // Role start date
	 * @param string date_end // Role end date
	 * @return json/xml data
	 */
    public function role_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_role/role', $params, true, $format);
    }
}
