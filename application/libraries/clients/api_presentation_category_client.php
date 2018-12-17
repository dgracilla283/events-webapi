<?php
/**
 * Generated automatically through the api client generator
 * @created    Wed, 22 Jan 2014 03:37:10 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_presentation_category_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_presentation_category']);
    }
    
	/**
	 * @method get
	 * @param int presentationCategoryID	// id of presentation category 
	 * @param int event_id	// id of event 
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
    public function presentation_category_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_presentation_category/presentation_category', $params, false, $format);
    }
	/**
	 * @method post
	 * @param int presentationCategoryID	// id parameter optional of type integer
	 * @param int event_id	// id of event 
	 * @param string name      // title of activity preference
	 * @return json/xml data
	 */
    public function presentation_category_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_presentation_category/presentation_category', $params, true, $format);
    }
	/**
	 * @method get
	 * @param int presentationCategoryID	// activity preference id
	 * @return json/xml data
	 */
    public function presentation_category_remove_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_presentation_category/presentation_category_remove', $params, false, $format);
    }
}
