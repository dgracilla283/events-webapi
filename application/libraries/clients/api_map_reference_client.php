<?php
/**
 * Generated automatically through the api client generator
 * @created    Wed, 22 Jan 2014 03:37:10 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_map_reference_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_map_reference']);
    }
    
	/**
	 * @method get
	 * @param int mapReferenceID // primary key
	 * @param int map_photo_id // fk map photo id
	 * @param string reference_type // enum('event, itinerary, activity') - 'event' is soon deprecated
	 * @param int reference_id // reference id
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
    public function map_reference_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_map_reference/map_reference', $params, false, $format);
    }
	/**
	 * @method post
	 * @param int mapPhotoID	//primary key
	 * @param int fk_i_eid // foreign key event id
	 * @param string title // map title name
	 * @param string s_fname // filename
	 * @param string s_origdata // serialize array original image data
	 * @param int b_is_deleted // flag primary photo
	 * @return json/xml data
	 */
    public function map_reference_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_map_reference/map_reference', $params, true, $format);
    }
	/**
	 * @method get
	 * @param int p_i_pid // photo id
	 * @return json/xml data
	 */
    public function remove_map_reference_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_map_reference/remove_map_reference', $params, false, $format);
    }
}
