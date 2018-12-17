<?php
/**
 * Generated automatically through the api client generator
 * @created    Tue, 28 Jan 2014 01:37:08 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_activation_key_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_activation_key']);
    }
    
	/**
	 * @method get
	 * @return json/xml data
	 */
    public function activation_keys_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_activation_key/activation_keys', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int user_id // the user_id of the user to fetch
	 * @param int key // key generated 
	 * @return json/xml data
	 */
    public function activation_key_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_activation_key/activation_key', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int user_id 
	 * @param string key
	 * @param int activationKeyID 
	 * @return json/xml data
	 */
    public function add_activation_key_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_activation_key/add_activation_key', $params, false, $format);
    }
	/**
	 * @method post
	 * @return json/xml data
	 */
    public function update_activation_key_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_activation_key/update_activation_key', $params, true, $format);
    }
}
