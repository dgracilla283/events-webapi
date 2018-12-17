<?php
/**
 * Generated automatically through the api client generator
 * @created    Wed, 22 Jan 2014 03:37:10 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_admin_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_admin']);
    }
    
	/**
	 * @method get
	 * @return json/xml data
	 */
    public function admins_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_admin/admins', $params, false, $format);
    }
}
