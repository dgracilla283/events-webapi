<?php
/**
 * Generated automatically through the api client generator
 * @created    Tue, 28 Jan 2014 01:37:08 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_record_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_record']);
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
    public function record_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_record/record', $params, false, $format);
    }
	
    public function phpinfo_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_record/phpinfo', $params, false, $format);
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
    public function trecord_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_record/trecord', $params, false, $format);
    }
	/**
	 * @method allRecord
	 * @param string category	// id parameter of type integer
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
    public function allRecord_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_record/allRecord', $params, false, $format);
    }
}
