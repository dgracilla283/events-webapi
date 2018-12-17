<?php
/**
 * Generated automatically through the api client generator
 * @created    Wed, 22 Jan 2014 03:37:10 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_companion_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_companion']);
    }
    
	/**
	 * @method get
	 * @param int primary_user_id // primary_user_id
	 * @param string type // companion type('child','adult')
	 * @return json/xml data
	 */
    public function companions_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_companion/companions', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int user_id // user id
	 * @return json/xml data
	 */
    public function companion_primary_user_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_companion/companion_primary_user', $params, false, $format);
    }
}
