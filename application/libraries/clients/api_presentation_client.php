<?php
/**
 * Generated automatically through the api client generator
 * @created    Wed, 22 Jan 2014 03:37:10 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_presentation_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_presentation']);
    }
    
	/**
	 * @method get
	 * @param int presentationID	// id of presentation 
	 * @param int presentation_category_id	// id of presentation category 
	 * @param string title	// title 
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
    public function presentation_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_presentation/presentation', $params, false, $format);
    }
	/**
	 * @method post
	 * @param int presentationID	// id parameter optional of type integer
	 * @param int presentation_category_id	// id of category 
	 * @param string title      // title of presentation
	 * @param string url      // link of presentation
	 * @return json/xml data
	 */
    public function presentation_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_presentation/presentation', $params, true, $format);
    }
	/**
	 * @method get
	 * @param int presentationID	// presentation id
	 * @param int presenation_category_id	// presentation categoryid
	 * @return json/xml data
	 */
    public function presentation_remove_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_presentation/presentation_remove', $params, false, $format);
    }
}
